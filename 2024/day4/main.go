package main

import (
	"fmt"
	"os"
	"regexp"
	"strings"
)

func main() {
	input, _ := os.ReadFile("data.txt")
	lines := strings.Split(string(input), "\n")

	var filteredLines []string
	for _, line := range lines {
		line = strings.TrimSpace(line)
		if line != "" {
			filteredLines = append(filteredLines, line)
		}
	}

	gridWidth := len(filteredLines[0])

	part1(filteredLines, gridWidth)
	part2(filteredLines, gridWidth)
}

func part2(filteredLines []string, gridWidth int) {
	resultPart2 := 0

	for i, l := range filteredLines[1 : len(filteredLines)-1] {
		r := regexp.MustCompile(`A`)
		matches := r.FindAllStringIndex(l[1:len(l)-1], -1)
		for _, match := range matches {
			idx := match[0] + 1
			if (string(filteredLines[i][idx-1]) == "M" && string(filteredLines[i+2][idx+1]) == "S" || string(filteredLines[i][idx-1]) == "S" && string(filteredLines[i+2][idx+1]) == "M") &&
				(string(filteredLines[i][idx+1]) == "M" && string(filteredLines[i+2][idx-1]) == "S" || string(filteredLines[i][idx+1]) == "S" && string(filteredLines[i+2][idx-1]) == "M") {
				resultPart2 += 1
			}
		}
	}
	fmt.Printf("Part 2: %d\n", resultPart2)
}

func part1(filteredLines []string, gridWidth int) {
	resultPart1 := 0

	// By line
	for _, l := range filteredLines {
		resultPart1 += findXMASinLine(l)
		resultPart1 += findXMASinLine(reverse(l))
	}

	// By column
	for i := 0; i < gridWidth; i++ {
		column := ""
		for _, l := range filteredLines {
			column += string(l[i])
		}
		resultPart1 += findXMASinLine(column)
		resultPart1 += findXMASinLine(reverse(column))
	}

	// Diagonals
	diagonalsTLBR := extractDiagonals(filteredLines, true) // Top-left to bottom-right
	for _, l := range diagonalsTLBR {
		resultPart1 += findXMASinLine(l)
		resultPart1 += findXMASinLine(reverse(l))
	}
	diagonalsTRBL := extractDiagonals(filteredLines, false) // Top-right to bottom-left
	for _, l := range diagonalsTRBL {
		resultPart1 += findXMASinLine(l)
		resultPart1 += findXMASinLine(reverse(l))
	}

	fmt.Printf("Part 1: %d\n", resultPart1)
}

func findXMASinLine(line string) int {
	result := 0
	r := regexp.MustCompile(`XMAS`)
	matches := r.FindAllString(line, -1)
	for _, match := range matches {
		if match == "XMAS" {
			result += 1
		}
	}
	return result
}

func extractDiagonals(grid []string, topLeftToBottomRight bool) []string {
	n := len(grid)
	m := len(grid[0])
	var diagonals []string

	// Helper function to extract diagonal starting at (row, col)
	getDiagonal := func(row, col int, dx, dy int) string {
		diagonal := ""
		for row >= 0 && row < n && col >= 0 && col < m {
			diagonal += string(grid[row][col])
			row += dx
			col += dy
		}
		return diagonal
	}

	if topLeftToBottomRight {
		// Top-left to bottom-right diagonals
		// Start at each column of the first row
		for col := 0; col < m; col++ {
			diagonals = append(diagonals, getDiagonal(0, col, 1, 1))
		}
		// Start at each row of the first column (skip the first element to avoid duplicates)
		for row := 1; row < n; row++ {
			diagonals = append(diagonals, getDiagonal(row, 0, 1, 1))
		}
	} else {
		// Top-right to bottom-left diagonals
		// Start at each column of the first row
		for col := 0; col < m; col++ {
			diagonals = append(diagonals, getDiagonal(0, col, 1, -1))
		}
		// Start at each row of the last column (skip the first element to avoid duplicates)
		for row := 1; row < n; row++ {
			diagonals = append(diagonals, getDiagonal(row, m-1, 1, -1))
		}
	}

	return diagonals
}

func reverse(str string) (result string) {
	for _, v := range str {
		result = string(v) + result
	}
	return
}
