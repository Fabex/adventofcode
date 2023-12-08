package main

import (
	"fmt"
	"os"
	"regexp"
	"strconv"
	"strings"
)

type node struct {
	left  string
	right string
}

func main() {
	part1()
	part2()
}

func part1() {
	var nodes = make(map[string]node)
	input, _ := os.ReadFile("data.txt")
	lines := strings.Split(string(input), "\n")
	var res int
	instructions := strings.Split(lines[0], "")
	reg := regexp.MustCompile(`([A-Z]{3}).*\(([A-Z]{3}), ([A-Z]{3})\)`)
	currentStep := "AAA"
	for _, line := range lines[2:] {
		step, left, right := parseNode(reg, line)
		nodes[step] = node{left, right}
	}
	i := 0
	for {
		switch instructions[i%len(instructions)] {
		case "R":
			currentStep = nodes[currentStep].right
		case "L":
			currentStep = nodes[currentStep].left
		}
		i++
		res++
		if currentStep == "ZZZ" {
			break
		}
	}

	fmt.Println("Part1: " + strconv.Itoa(res))
}

func part2() {
	var nodes = make(map[string]node)
	input, _ := os.ReadFile("data.txt")
	lines := strings.Split(string(input), "\n")
	instructions := strings.Split(lines[0], "")
	reg := regexp.MustCompile(`([A-Z0-9]{3}).*\(([A-Z0-9]{3}), ([A-Z0-9]{3})\)`)

	var currentsSteps []string
	for _, line := range lines[2:] {
		step, left, right := parseNode(reg, line)
		nodes[step] = node{left, right}
		if step[len(step)-1:] == "A" {
			currentsSteps = append(currentsSteps, step)
		}
	}

	nbByWay := make(map[string]int, len(currentsSteps))
	for _, currentStep := range currentsSteps {
		currentCurrentStep := currentStep
		i := 0
		for {
			switch instructions[i%len(instructions)] {
			case "R":
				currentCurrentStep = nodes[currentCurrentStep].right
			case "L":
				currentCurrentStep = nodes[currentCurrentStep].left
			}
			i++
			nbByWay[currentStep] = i
			if currentCurrentStep[len(currentCurrentStep)-1:] == "Z" {
				break
			}
		}
	}

	fmt.Println("Part2: " + strconv.Itoa(lcm(nbByWay)))
}

func parseNode(reg *regexp.Regexp, line string) (step string, left string, right string) {
	matches := reg.FindStringSubmatch(line)
	return matches[1], matches[2], matches[3]
}
func gcd(a, b int) int {
	for b != 0 {
		a, b = b, a%b
	}
	return a
}

func lcm(numbers map[string]int) int {
	result := 1
	for _, num := range numbers {
		result = (result * num) / gcd(result, num)
	}
	return result
}
