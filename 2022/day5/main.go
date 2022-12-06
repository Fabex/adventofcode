package main

import (
	"fmt"
	"os"
	"regexp"
	"strconv"
	"strings"
)

type stack struct {
	Coord  int
	Crates string
}

func main() {
	data, _ := os.ReadFile("./data.txt")
	ar := strings.Split(string(data), "\n")

	stacks := initEmptyStacks(ar)
	fillStack(ar, &stacks)

	for _, line := range ar {
		if line == "" || line[0:1] != "m" {
			continue
		}
		printStack(stacks)
		fmt.Println(line)
		rMove, _ := regexp.Compile("[1-9]")
		rMoveResult := rMove.FindAllString(line, 3)
		number, _ := strconv.Atoi(rMoveResult[0])
		from := rMoveResult[1]
		to := rMoveResult[2]
		if number > len(stacks[from].Crates) {
			number = len(stacks[from].Crates)
		}

		slice := reverse(stacks[from].Crates[0:number])
		stacks[from].Crates = stacks[from].Crates[number:]
		stacks[to].Crates = slice + stacks[to].Crates
		printStack(stacks)
	}

	//printStack(stacks)
}

func printStack(stacks map[string]*stack) {
	fmt.Println("-------------------------------------")
	for idx, stack := range stacks {
		fmt.Println("idx : " + idx + " -- crates : " + *&stack.Crates)
	}
	fmt.Println("-------------------------------------")
}

func fillStack(ar []string, stacks *map[string]*stack) {
	for _, line := range ar {
		if line == "" {
			break
		}
		rStack, _ := regexp.Compile("[A-Z]")
		rStackResult := rStack.FindAllStringIndex(line, 10)
		if len(rStackResult) > 0 {
			for _, coord := range rStackResult {
				for _, stack := range *stacks {
					if stack.Coord == coord[0]+coord[1] {
						stack.Crates += line[coord[0]:coord[1]]
					}
				}
			}
		}
	}
}

func initEmptyStacks(ar []string) map[string]*stack {
	crates := make(map[string]*stack)
	for _, line := range ar {
		if line == "" {
			break
		}
		rStackNumber, _ := regexp.Compile("[0-9]")
		rStackNumberResult := rStackNumber.FindAllStringIndex(line, 10)
		if len(rStackNumberResult) > 0 {
			for i, v := range rStackNumberResult {
				crates[strconv.Itoa(i+1)] = createStack(v[0] + v[1])
			}
		}
	}

	return crates
}

func createStack(coord int) *stack {
	return &stack{Coord: coord, Crates: ""}
}

func reverse(s string) string {
	rns := []rune(s)
	for i, j := 0, len(rns)-1; i < j; i, j = i+1, j-1 {
		rns[i], rns[j] = rns[j], rns[i]
	}
	return string(rns)
}
