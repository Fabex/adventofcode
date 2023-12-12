package main

import (
	"fmt"
	"os"
	"slices"
	"strconv"
	"strings"
)

type coords struct {
	x int
	y int
}
type space struct {
	coords coords
}

var universe = make(map[string]space)

var expansion, _ = strconv.Atoi(os.Args[1])

func main() {
	input, _ := os.ReadFile("data.txt")
	lines := strings.Split(string(input), "\n")
	var res int

	var emptyL []int
	var emptyC []int
	var tmp = make([]int, len(lines[0]))
	for iLine, line := range lines {
		if !strings.Contains(line, "#") {
			emptyL = append(emptyL, iLine)
		}
		for i, c := range strings.Split(line, "") {
			if c == "#" {
				tmp[i]++
			}
		}
	}
	for i, c := range tmp {
		if c == 0 {
			emptyC = append(emptyC, i)
		}
	}

	for iLine, line := range lines {
		for i, c := range line {
			if c == '#' {
				universe[strconv.Itoa(i)+"-"+strconv.Itoa(iLine)] = space{coords: coords{x: i, y: iLine}}
			}
		}
	}

	var pairsAlreadyLinked []string
	for c, g := range universe {
		for c2, g2 := range universe {
			if g.coords.x == g2.coords.x && g.coords.y == g2.coords.y {
				continue
			}
			if !slices.Contains(pairsAlreadyLinked, c+"-"+c2) {
				pairsAlreadyLinked = append(pairsAlreadyLinked, c+"-"+c2)
				pairsAlreadyLinked = append(pairsAlreadyLinked, c2+"-"+c)

				var allx []int
				if g.coords.x < g2.coords.x {
					allx = sliceFill(g.coords.x+1, g2.coords.x+1)
				}
				if g.coords.x > g2.coords.x {
					allx = sliceFill(g2.coords.x+1, g.coords.x+1)
				}
				x := len(allx)
				for _, el := range emptyC {
					if slices.Contains(allx, el) {
						x += expansion - 1
					}
				}

				var ally []int
				if g.coords.y < g2.coords.y {
					ally = sliceFill(g.coords.y+1, g2.coords.y+1)
				}
				if g.coords.y > g2.coords.y {
					ally = sliceFill(g2.coords.y+1, g.coords.y+1)
				}
				y := len(ally)
				for _, el := range emptyL {
					if slices.Contains(ally, el) {
						y += expansion - 1
					}
				}
				res += x + y
			}
		}
	}

	fmt.Println("Part1: " + strconv.Itoa(res))
}

func sliceFill(start int, end int) []int {
	s := make([]int, end-start)
	for i := 0; i < end-start; i++ {
		s[i] = start + i
	}
	return s
}

func part2() {

	fmt.Println("Part2: " + strconv.Itoa(0))
}
