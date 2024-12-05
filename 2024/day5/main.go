package main

import (
	"fmt"
	"os"
	"strconv"
	"strings"
)

func main() {
	input, _ := os.ReadFile("data.txt")
	lines := strings.Split(string(input), "\n")
	orderingRules, updateRules := prepareData(lines)

	resultPart1 := 0
	var incorrectlyOrderedUpdate [][]int
	for _, ur := range updateRules {
		correct := true
		for i := 0; i < len(ur)-1; i++ {
			for j := i + 1; j < len(ur); j++ {
				found := false
				for _, or := range orderingRules {
					if ur[i] == or[0] && ur[j] == or[1] {
						found = true
						break
					}
				}
				if !found {
					correct = false
					break
				}
			}
			if !correct {
				break
			}
		}
		if !correct {
			incorrectlyOrderedUpdate = append(incorrectlyOrderedUpdate, ur)
			continue
		}
		resultPart1 += ur[len(ur)/2]
	}
	fmt.Printf("Part 1: %d\n", resultPart1)

	resultPart2 := 0
	for _, ur := range incorrectlyOrderedUpdate {
		for i := 0; i < len(ur)-1; i++ {
			for j := i + 1; j < len(ur); j++ {
				found := false
				for _, or := range orderingRules {
					if ur[i] == or[0] && ur[j] == or[1] {
						found = true
						break
					}
				}
				if !found {
					ur[i], ur[j] = ur[j], ur[i]
				}
			}
		}
		resultPart2 += ur[len(ur)/2]
	}

	fmt.Printf("Part 2: %d\n", resultPart2)

}

func prepareData(lines []string) ([][]int, [][]int) {
	var orderingRules [][]int
	var updateRules [][]int
	ordersCollected := false
	for _, l := range lines {
		if l == "" {
			ordersCollected = true
			continue
		}
		if !ordersCollected {
			r := strings.Split(l, "|")
			rl, _ := strconv.Atoi(r[0])
			rr, _ := strconv.Atoi(r[1])
			orderingRules = append(orderingRules, []int{rl, rr})
			continue
		}
		u := strings.Split(l, ",")
		var updateRule []int
		for _, uu := range u {
			ul, _ := strconv.Atoi(uu)
			updateRule = append(updateRule, ul)
		}

		updateRules = append(updateRules, updateRule)
	}
	return orderingRules, updateRules
}
