package main

import (
	"fmt"
	"os"
	"strings"
)

func main() {
	data, err := os.ReadFile("./data.txt")
	ar := strings.Split(string(data), "\n")
	if err != nil {
		panic(err)
	}
	totalScorePart1 := 0
	totalScorePart2 := 0
	for _, round := range ar {
		if round == "" {
			break
		}
		ligne := strings.Split(round, " ")
		winScorePart1 := getScore(ligne[0], ligne[1])
		roundScorePart1 := getShapeScore(ligne[1]) + winScorePart1
		totalScorePart1 += roundScorePart1

		winScorePart2 := getScorePart2(ligne[1])
		roundScorePart2 := getShapeScore(getShapeToUse(ligne[0], winScorePart2)) + winScorePart2
		totalScorePart2 += roundScorePart2
	}

	fmt.Println(totalScorePart1)
	fmt.Println(totalScorePart2)
}

func getShapeScore(shape string) int {
	switch shape {
	case "X":
		return 1
	case "Y":
		return 2
	case "Z":
		return 3
	}

	panic("impossible")
}

func getScore(op string, me string) int {
	switch op {
	case "A":
		switch me {
		case "X":
			return 3
		case "Y":
			return 6
		case "Z":
			return 0
		}
	case "B":
		switch me {
		case "X":
			return 0
		case "Y":
			return 3
		case "Z":
			return 6
		}
	case "C":
		switch me {
		case "X":
			return 6
		case "Y":
			return 0
		case "Z":
			return 3
		}
	}

	panic("impossible")
}

func getScorePart2(me string) int {
	switch me {
	case "X":
		return 0
	case "Y":
		return 3
	case "Z":
		return 6
	}
	panic("impossible")
}

func getShapeToUse(shape string, result int) string {
	switch shape {
	case "A":
		switch result {
		case 0:
			return "Z"
		case 3:
			return "X"
		case 6:
			return "Y"
		}
	case "B":
		switch result {
		case 0:
			return "X"
		case 3:
			return "Y"
		case 6:
			return "Z"
		}
	case "C":
		switch result {
		case 0:
			return "Y"
		case 3:
			return "Z"
		case 6:
			return "X"
		}
	}
	panic("impossible")
}
