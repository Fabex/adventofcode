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
	h := len(ar)
	l := len(ar[0])
	edge := l*2 + h*2 - 4

	count := 0
	for idx, line := range ar {
		if idx == 0 || idx == len(ar)-1 {
			continue
		}
		for idxTree := 1; idxTree < len(line)-1; idxTree++ {
			tree, _ := strconv.Atoi(string(line[idxTree]))
			fmt.Println(tree, idx, idxTree)
			if visibleFromRight(line, idxTree, tree) {
				count++
				continue
			}
			if visibleFromleft(line, idxTree, tree) {
				count++
				continue
			}
			if visibleFromTop(ar, idx, idxTree, tree) {
				count++
				continue
			}
		}
		println("----")
	}

	println(edge, count)
}

func visibleFromTop(ar []string, idx int, idxTree int, tree int) bool {
	for _, l := range ar[0 : idx-1] {
		t, _ := strconv.Atoi(string(l[idxTree]))
		if t >= tree {
			return false
		}
	}
	return true
}

func visibleFromRight(line string, idxTree int, tree int) bool {
	for i := idxTree + 1; i < len(line); i++ {
		nearTree, _ := strconv.Atoi(string(line[i]))
		if nearTree >= tree {
			return false
		}
	}

	return true
}

func visibleFromleft(line string, idxTree int, tree int) bool {
	for i := idxTree - 1; i >= 0; i-- {
		nearTree, _ := strconv.Atoi(string(line[i]))
		if nearTree >= tree {
			return false
		}
	}

	return true
}
