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
	reports := make([][]int, len(lines))
	for i, line := range lines {
		if line == "" {
			continue
		}
		r := strings.Split(line, " ")
		reports[i] = make([]int, len(r))
		for j, w := range r {
			reports[i][j], _ = strconv.Atoi(w)
		}
	}

	totalSafePart1 := 0
	totalSafePart2 := 0
	for _, report := range reports {
		if len(report) == 0 {
			continue
		}
		safe := isReportSafe(report)
		if safe {
			totalSafePart1++
		} else {
			if findMistake(report) {
				totalSafePart2++
			}
		}
	}

	fmt.Printf("part 1 : %d \n", totalSafePart1)
	fmt.Printf("part 2 : %d \n", totalSafePart1+totalSafePart2)
}

func findMistake(report []int) bool {
	safe := false
	for i := 0; i < len(report); i++ {
		dolly := make([]int, len(report))
		_ = copy(dolly, report)
		safe = isReportSafe(remove(dolly, i))
		if safe {
			return true
		}
	}

	return false
}

func remove(slice []int, s int) []int {
	return append(slice[:s], slice[s+1:]...)
}

// copilot solution
func isReportSafe(report []int) bool {
	for i := 0; i < len(report)-1; i++ {
		diff := report[i+1] - report[i]
		if diff == 0 || diff < -3 || diff > 3 {
			return false
		}
		if i > 0 && (diff > 0) != (report[i] > report[i-1]) {
			return false
		}
	}
	return true
}

// my solution

//type direction int
//
//const (
//	ascending direction = iota
//	descending
//	undetermined
//)
//
//func isReportSafe(report []int) bool {
//	dir := undetermined
//	for i := 0; i < len(report)-1; i++ {
//		if report[i] == report[i+1] {
//			return false
//		}
//		if report[i] < report[i+1] {
//			//ascending
//			if dir == descending {
//				return false
//			}
//			dir = ascending
//			if report[i+1]-report[i] < 1 || report[i+1]-report[i] > 3 {
//				return false
//			}
//		}
//		if report[i] > report[i+1] {
//			//descending
//			if dir == ascending {
//				return false
//			}
//			dir = descending
//			if report[i]-report[i+1] < 1 || report[i]-report[i+1] > 3 {
//				return false
//			}
//		}
//	}
//	return true
//}
