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

	memory := lines[0]
	r := regexp.MustCompile(`mul\((\d{1,3}),(\d{1,3})\)`)
	resultPart1 := 0
	matches := r.FindAllStringSubmatch(memory, -1)
	for _, match := range matches {
		a, _ := strconv.Atoi(match[1])
		b, _ := strconv.Atoi(match[2])
		resultPart1 += a * b
	}

	fmt.Printf("Part 1: %d\n", resultPart1)

	resultPart2 := 0
	r = regexp.MustCompile(`do\(\)|mul\((\d{1,3}),(\d{1,3})\)|don't\(\)`)
	collect := true
	matches = r.FindAllStringSubmatch(memory, -1)
	for _, match := range matches {
		if match[0] == "do()" {
			collect = true
		} else if match[0] == "don't()" {
			collect = false
		} else if collect {
			a, _ := strconv.Atoi(match[1])
			b, _ := strconv.Atoi(match[2])
			resultPart2 += a * b
		}
	}

	fmt.Printf("Part 2: %d\n", resultPart2)

}

//881592 to low
//8469785 to low
//87815398 to low
//88811886
