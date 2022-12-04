package main

import (
	"fmt"
	"os"
	"strconv"
	"strings"
)

func main() {
	data, _ := os.ReadFile("./data.txt")
	ar := strings.Split(string(data), "\n")

	countPart1 := 0
	countPart2 := 0
	for _, line := range ar {
		parts := strings.Split(line, ",")
		if len(parts) < 2 {
			break
		}
		subPart1 := strings.Split(parts[0], "-")
		minPart1, _ := strconv.Atoi(subPart1[0])
		maxPart1, _ := strconv.Atoi(subPart1[1])
		subPart2 := strings.Split(parts[1], "-")
		minPart2, _ := strconv.Atoi(subPart2[0])
		maxPart2, _ := strconv.Atoi(subPart2[1])

		if ((minPart1 <= minPart2) && (maxPart1 >= maxPart2)) || ((minPart2 <= minPart1) && (maxPart2 >= maxPart1)) {
			countPart1++
		}

		if !((maxPart1 < minPart2) || (minPart1 > maxPart2)) {
			countPart2++
		}
	}
	fmt.Println(countPart1)
	fmt.Println(countPart2)
}
