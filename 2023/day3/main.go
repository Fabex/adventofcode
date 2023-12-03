package main

import (
	"fmt"
	"os"
	"regexp"
	"strconv"
	"strings"
)

type coords struct {
	line  int
	start int
	end   int
}

type symbol struct {
	symbol string
	coords coords
}

type data struct {
	num    int
	coords coords
	border []coords
}

func main() {
	input, _ := os.ReadFile("data.txt")
	lines := strings.Split(string(input), "\n")
	var resPart1, resPart2 = 0, 0
	var dataMap []data
	var symbolMap []symbol
	for idLine, line := range lines {
		res := regexp.MustCompile(`(\d+)`).FindAllStringIndex(line, -1)
		resSymbol := regexp.MustCompile(`[^\w\.\n\t\r]`).FindAllStringIndex(line, -1)
		for _, r := range resSymbol {
			symbolMap = append(symbolMap, symbol{
				line[r[0]:r[1]],
				coords{idLine, r[0], r[1]},
			})
		}
		for _, r := range res {
			n, _ := strconv.Atoi(line[r[0]:r[1]])
			dataMap = append(dataMap, data{
				n,
				coords{idLine, r[0], r[1]},
				calcBorders(idLine, r[0], r[1]),
			})
		}
	}
	var tmp []data
	for _, d := range dataMap {
		for _, b := range d.border {
			for _, s := range symbolMap {
				if coordsAreEqual(b, s.coords) {
					resPart1 += d.num
					if s.symbol == "*" {
						tmp = append(tmp, data{
							num:    d.num,
							coords: s.coords,
							border: nil,
						})
					}
				}
			}
		}
	}

	for i := 0; i < len(tmp); i++ {
		for j := i + 1; j < len(tmp); j++ {
			if coordsAreEqual(tmp[i].coords, tmp[j].coords) {
				resPart2 += tmp[i].num * tmp[j].num
			}
		}
	}
	fmt.Println("Part1: " + strconv.Itoa(resPart1))
	fmt.Println("Part2: " + strconv.Itoa(resPart2))
}

func calcBorders(line int, start int, end int) []coords {
	var borders []coords
	lines := []int{line, line + 1}
	if line > 0 {
		lines = append(lines, line-1)
	}
	for _, l := range lines {
		if l == line {
			borders = append(borders, coords{l, start - 1, start})
			borders = append(borders, coords{l, end, end + 1})
			continue
		}
		for i := start - 1; i <= end; i++ {
			borders = append(borders, coords{l, i, i + 1})
		}
	}

	return borders
}

func coordsAreEqual(a coords, b coords) bool {
	return a.line == b.line && a.start == b.start && a.end == b.end
}
