package main

import (
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

func reduce(slice []int, reducer func(int, int, byte) int, operators string) int {
	result := slice[0]
	for i, value := range slice[1:] {
		result = reducer(result, value, operators[i])
	}
	return result
}

func sumReducer(acc, value int, operator byte) int {
	expString := strconv.Itoa(acc) + string(operator) + strconv.Itoa(value)
	exp, _ := expr.Compile(expString)
	res, _ := expr.Run(exp, nil)
	return res.(int)
}

func main() {
	input, _ := os.ReadFile("data.txt")
	lines := strings.Split(string(input), "\n")
	el := formatData(lines)

	var possibleResults []int
	sumOfPossibleResults := 0
	for _, e := range el {
		itMax := int(math.Pow(float64(2), float64(len(e.operands)-1)))
		bin := strings.Repeat("0", len(e.operands)-1)
		for i := 0; i < itMax; i++ {
			binToArith := strings.ReplaceAll(bin, "0", "+")
			binToArith = strings.ReplaceAll(binToArith, "1", "*")

			result := reduce(e.operands, sumReducer, binToArith)
			if result == e.result && !slices.Contains(possibleResults, result) {
				possibleResults = append(possibleResults, result)
				sumOfPossibleResults += result
			}

			bin = addOneToBinaryString(bin)
		}
	}
	spew.Dump(sumOfPossibleResults)
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
