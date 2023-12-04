package main

import (
	"fmt"
	"os"
	"regexp"
	"strconv"
	"strings"
)

func main() {
	input, _ := os.ReadFile("data.txt")
	lines := strings.Split(string(input), "\n")
	var resPart1, resPart2 = 0, 0
	tmp := make(map[int]int)
	for idx, _ := range lines {
		tmp[idx+1] = 1
	}
	for _, line := range lines {
		cardSet := strings.Split(line, ":")
		cardNumber, _ := strconv.Atoi(regexp.MustCompile(`\d+`).FindAllString(cardSet[0], -1)[0])
		cardNumbers := strings.Split(cardSet[1], "|")
		winningNumbers := regexp.MustCompile(`\d+`).FindAllString(cardNumbers[0], -1)
		myNumbers := regexp.MustCompile(`\d+`).FindAllString(cardNumbers[1], -1)

		same := arraySame(myNumbers, winningNumbers)
		var point = 0
		var nbSame = len(same)

		if nbSame > 0 {
			point = 1
			for i := 1; i < nbSame; i++ {
				point *= 2
			}
			for i := cardNumber + 1; i <= cardNumber+nbSame; i++ {
				t := tmp[cardNumber]
				for j := 0; j < t; j++ {
					tmp[i]++
				}
			}
		}
		resPart1 += point
	}

	resPart2 = arraySum(tmp)
	fmt.Println("Part1: " + strconv.Itoa(resPart1))
	fmt.Println("Part2: " + strconv.Itoa(resPart2))
}

func arraySum(a map[int]int) int {
	var sum int
	for _, a := range a {
		sum += a
	}
	return sum
}

func arraySame(a []string, b []string) []string {
	var diff []string
	for _, a := range a {
		if contains(b, a) {
			diff = append(diff, a)
		}
	}
	return diff
}

func contains(b []string, a string) bool {
	for _, b := range b {
		if b == a {
			return true
		}
	}
	return false
}
