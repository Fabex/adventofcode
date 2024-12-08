package main

import (
	"fmt"
	"os"
	"slices"
	"strings"
	"sync"
)

const (
	out   = 0
	right = 1
	left  = 2
	down  = 3
	up    = 4
	loop  = 5
)

type pos struct {
	x int
	y int
}

type visitedPosition struct {
	previous  pos
	current   pos
	direction string
}

type guard struct {
	position               pos
	direction              string
	step                   int
	visitedUniquePositions []pos
	visitedPositions       []visitedPosition
}

func main() {
	input, _ := os.ReadFile("data.txt")
	lines := strings.Split(string(input), "\n")
	var filteredLines []string
	var g guard
	for i, line := range lines {
		line = strings.TrimSpace(line)
		if line != "" {
			filteredLines = append(filteredLines, line)
		}
		if strings.Contains(line, "^") {
			g.position.y = i
			g.position.x = strings.Index(line, "^")
			g.direction = "^"
			g.step = 0
		}
	}

	g, _ = makeRun(g, filteredLines)
	fmt.Println("Part 1:", len(g.visitedUniquePositions))
	loopDetected := 0
	results := make(chan int)
	var wg sync.WaitGroup

	for y, line := range filteredLines {
		for x := 0; x < len(line); x++ {
			if filteredLines[y][x] == '#' {
				continue
			}
			dolly := make([]string, len(filteredLines))
			_ = copy(dolly, filteredLines)
			dolly[y] = dolly[y][:x] + "#" + dolly[y][x+1:]
			wg.Add(1)
			go func(dolly []string) {
				defer wg.Done()
				_, err := makeRun(g, dolly)
				if err != nil {
					results <- 1
				} else {
					results <- 0
				}
			}(dolly)
		}
	}

	go func() {
		wg.Wait()
		close(results)
	}()

	for result := range results {
		loopDetected += result
	}

	fmt.Println("Part 2:", loopDetected)
}

func makeRun(g guard, filteredLines []string) (guard, error) {
	end := -1
	for {
		if g.direction == "^" {
			end = moveUp(filteredLines, &g)
		}
		if g.direction == ">" {
			end = moveRight(filteredLines, &g)
		}
		if g.direction == "V" {
			end = moveDown(filteredLines, &g)
		}
		if g.direction == "<" {
			end = moveLeft(filteredLines, &g)
		}
		if end == out {
			break
		}
		if end == loop {
			return g, fmt.Errorf("loop detected")
		}
	}
	return g, nil
}

func moveRight(lines []string, g *guard) int {
	for {
		var p visitedPosition
		p.previous = g.position
		if g.position.x+1 >= len(lines[0]) {
			return out
		}
		if lines[g.position.y][g.position.x+1] == '#' {
			p.direction = g.direction
			g.direction = "V"
			p.current = g.position
			if slices.Contains(g.visitedPositions, p) {
				return loop
			}
			g.visitedPositions = append(g.visitedPositions, p)
			return down
		}
		g.position.x++
		g.step++
		if !slices.Contains(g.visitedUniquePositions, g.position) {
			g.visitedUniquePositions = append(g.visitedUniquePositions, g.position)
		}
	}
}

func moveDown(lines []string, g *guard) int {
	for {
		var p visitedPosition
		p.previous = g.position
		if g.position.y+1 >= len(lines) {
			return out
		}
		if lines[g.position.y+1][g.position.x] == '#' {
			p.direction = g.direction
			g.direction = "<"
			p.current = g.position
			if slices.Contains(g.visitedPositions, p) {
				return loop
			}
			g.visitedPositions = append(g.visitedPositions, p)
			return right
		}
		g.position.y++
		g.step++
		if !slices.Contains(g.visitedUniquePositions, g.position) {
			g.visitedUniquePositions = append(g.visitedUniquePositions, g.position)
		}
	}
}

func moveLeft(lines []string, g *guard) int {
	for {
		var p visitedPosition
		p.previous = g.position
		if g.position.x-1 < 0 {
			return out
		}
		if lines[g.position.y][g.position.x-1] == '#' {
			p.direction = g.direction
			g.direction = "^"
			p.current = g.position
			if slices.Contains(g.visitedPositions, p) {
				return loop
			}
			g.visitedPositions = append(g.visitedPositions, p)
			return up
		}
		g.position.x--
		g.step++
		if !slices.Contains(g.visitedUniquePositions, g.position) {
			g.visitedUniquePositions = append(g.visitedUniquePositions, g.position)
		}
	}
}

func moveUp(lines []string, g *guard) int {
	for {
		var p visitedPosition
		p.previous = g.position
		if g.position.y-1 < 0 {
			return out
		}
		if lines[g.position.y-1][g.position.x] == '#' {
			p.direction = g.direction
			g.direction = ">"
			p.current = g.position
			if slices.Contains(g.visitedPositions, p) {
				return loop
			}
			g.visitedPositions = append(g.visitedPositions, p)
			return left
		}
		g.position.y--
		g.step++
		if !slices.Contains(g.visitedUniquePositions, g.position) {
			g.visitedUniquePositions = append(g.visitedUniquePositions, g.position)
		}
	}
}
