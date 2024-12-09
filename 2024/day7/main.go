package main

import (
	"fmt"
	"github.com/davecgh/go-spew/spew"
	"github.com/expr-lang/expr"
	"math"
	"os"
	"slices"
	"strconv"
	"strings"
)

type equation struct {
	result   int
	operands []int
}

type equationList []equation

func reduce(slice []int, reducer func(int, int, string) int, operators string, maxResult int) int {
	result := slice[0]
	for i, value := range slice[1:] {
		result = reducer(result, value, string(operators[i]))
		if result > maxResult {
			return -1
		}
	}
	return result
}

func sumReducer(acc, value int, operator string) int {
	if operator == "|" {
		ret, _ := strconv.Atoi(fmt.Sprintf("%d%d", acc, value))
		return ret
	}
	expString := strconv.Itoa(acc) + operator + strconv.Itoa(value)
	exp, _ := expr.Compile(expString)
	res, _ := expr.Run(exp, nil)
	return res.(int)
}

func main() {
	input, _ := os.ReadFile("data.txt")
	lines := strings.Split(string(input), "\n")
	el := formatData(lines)

	var possibleResults []int
	var unPossibleEquations equationList
	sumOfPossibleResults := 0
	for _, e := range el {
		found := false
		itMax := int(math.Pow(float64(2), float64(len(e.operands)-1)))
		bin := strings.Repeat("0", len(e.operands)-1)
		for i := 0; i < itMax; i++ {
			binToArith := strings.ReplaceAll(bin, "0", "+")
			binToArith = strings.ReplaceAll(binToArith, "1", "*")

			result := reduce(e.operands, sumReducer, binToArith, e.result)
			if result == e.result && !slices.Contains(possibleResults, result) {
				possibleResults = append(possibleResults, result)
				sumOfPossibleResults += result
				found = true
				break
			}

			bin = addOneToBinaryString(bin)
		}
		if !found {
			unPossibleEquations = append(unPossibleEquations, e)
		}
	}
	fmt.Printf("Part 1: %d\n", sumOfPossibleResults)
	var possibleResultsPart2 []int
	for _, e := range unPossibleEquations {
		itMax := int(math.Pow(float64(3), float64(len(e.operands)-1)))
		ter := strings.Repeat("0", len(e.operands)-1)
		for i := 0; i < itMax; i++ {
			terToArith := strings.ReplaceAll(ter, "0", "+")
			terToArith = strings.ReplaceAll(terToArith, "1", "*")
			terToArith = strings.ReplaceAll(terToArith, "2", "|")

			result := reduce(e.operands, sumReducer, terToArith, e.result)
			if result == e.result && !slices.Contains(possibleResultsPart2, result) {
				possibleResultsPart2 = append(possibleResultsPart2, result)
				sumOfPossibleResults += result
				break
			}

			ter = addOneToTernaryString(ter)
		}
	}
	spew.Dump(sumOfPossibleResults)
	fmt.Printf("Part 2: %d\n", sumOfPossibleResults)

}

func formatData(lines []string) equationList {
	el := make(equationList, 0)
	for _, line := range lines {
		line = strings.TrimSpace(line)
		if line != "" {
			a := strings.Split(line, ":")
			r, _ := strconv.Atoi(a[0])
			ops := strings.Split(a[1], " ")
			var operands []int
			for _, op := range ops {
				if op == "" {
					continue
				}
				o, _ := strconv.Atoi(op)
				operands = append(operands, o)
			}
			el = append(el, equation{r, operands})
		}
	}
	return el
}

func addOneToBinaryString(binStr string) string {
	n := len(binStr)
	carry := 1
	result := make([]byte, n)

	for i := n - 1; i >= 0; i-- {
		if binStr[i] == '1' && carry == 1 {
			result[i] = '0'
		} else {
			result[i] = binStr[i] + byte(carry)
			carry = 0
		}
	}

	if carry == 1 {
		return "1" + string(result)
	}
	return string(result)
}

func addOneToTernaryString(ternStr string) string {
	n := len(ternStr)
	carry := 1
	result := make([]byte, n)

	for i := n - 1; i >= 0; i-- {
		if carry == 0 {
			result[i] = ternStr[i]
			continue
		}

		if ternStr[i] == '2' {
			result[i] = '0' // '2' + 1 in base 3 causes a carry
		} else {
			result[i] = ternStr[i] + byte(carry)
			carry = 0 // Reset carry after successful addition
		}
	}

	if carry == 1 {
		return "1" + string(result)
	}
	return string(result)
}
