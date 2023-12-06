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
	var resPart1, resPart2 int
	times := regexp.MustCompile(`\d+`).FindAllString(lines[0], -1)
	distances := regexp.MustCompile(`\d+`).FindAllString(lines[1], -1)
	resPart1 = arrayMul(calcWays(times, distances))
	resPart2 = arrayMul(calcWays([]string{strings.Join(times, "")}, []string{strings.Join(distances, "")}))

	fmt.Println("Part1: " + strconv.Itoa(resPart1))
	fmt.Println("Part2: " + strconv.Itoa(resPart2))
}

func arrayMul(ways []int) int {
	var mul = 1
	for _, w := range ways {
		mul *= w
	}
	return mul
}

func calcWays(times []string, distances []string) []int {
	var ways []int
	for idx, t := range times {
		distance, _ := strconv.Atoi(distances[idx])
		time, _ := strconv.Atoi(t)
		var nbWays = 0
		for i := 1; i < time; i++ {
			if i*(time-i) > distance {
				nbWays++
			}
		}
		ways = append(ways, nbWays)
	}
	return ways
}
