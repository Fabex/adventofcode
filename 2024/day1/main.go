package main

import (
	"fmt"
	"math"
	"os"
	"sort"
	"strconv"
	"strings"
)

func main() {
	input, _ := os.ReadFile("data.txt")
	lines := strings.Split(string(input), "\n")
	left, right := make([]int, len(lines)), make([]int, len(lines))
	for _, line := range lines {
		if line == "" {
			continue
		}
		numbers := strings.Fields(line)
		l, _ := strconv.Atoi(numbers[0])
		left = append(left, l)
		r, _ := strconv.Atoi(numbers[1])
		right = append(right, r)
	}
	sort.Ints(left)
	sort.Ints(right)

	sum := 0
	for i := 0; i < len(left); i++ {
		sum += int(math.Abs(float64(left[i] - right[i])))
	}
	fmt.Printf("part 1 : %d \n", sum)

	sum = 0
	for _, l := range left {
		sum += countOccurrences(right, l) * l
	}
	fmt.Printf("part 2 : %d \n", sum)
}

func countOccurrences(arr []int, target int) int {
	count := 0
	for _, str := range arr {
		if str == target {
			count++
		}
	}
	return count
}
