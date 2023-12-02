package main

import (
	"fmt"
	"os"
	"regexp"
	"strconv"
	"strings"
)

var maxRed = 12
var maxGreen = 13
var maxBlue = 14

func main() {
	input, _ := os.ReadFile("data.txt")
	lines := strings.Split(string(input), "\n")
	var resPart1, resPart2 = 0, 0
	for gId, line := range lines {
		var totalRed, totalGreen, totalBlue = 0, 0, 0
		subsets := strings.Split(strings.Split(line, ":")[1], ";")
		var maxRedInGame, maxGreenInGame, maxBlueInGame = 0, 0, 0
		for _, subset := range subsets {
			colors := strings.Split(subset, ",")
			for _, color := range colors {
				res := regexp.MustCompile(`(\d+) (red|green|blue)`).FindStringSubmatch(color)
				number, _ := strconv.Atoi(res[1])
				color := res[2]
				switch color {
				case "red":
					if totalRed < number {
						totalRed = number
					}
					if maxRedInGame < number {
						maxRedInGame = number
					}
				case "green":
					if totalGreen < number {
						totalGreen = number
					}
					if maxGreenInGame < number {
						maxGreenInGame = number
					}
				case "blue":
					if totalBlue < number {
						totalBlue = number
					}
					if maxBlueInGame < number {
						maxBlueInGame = number
					}
				}
			}
		}
		if (totalRed <= maxRed) && (totalGreen <= maxGreen) && (totalBlue <= maxBlue) {
			resPart1 += gId + 1
		}
		resPart2 += maxRedInGame * maxGreenInGame * maxBlueInGame
	}
	fmt.Println("Part1: " + strconv.Itoa(resPart1))
	fmt.Println("Part2: " + strconv.Itoa(resPart2))
}
