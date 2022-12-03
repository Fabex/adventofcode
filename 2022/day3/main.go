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
	var resultPart1 int32 = 0
	// PART1
	for _, line := range ar {
		if line == "" {
			break
		}
		len := len(line)
		resultPart1 += getResult(Intersection(line[0:len/2], line[len/2:]))
	}
	fmt.Println(resultPart1)
	// PART2
	var resultPart2 int32 = 0
	chunk := chunkBy(ar, 3)
	for _, ch := range chunk {
		if len(ch) == 1 {
			break
		}
		resultPart2 += getResult(IntersectionBis(ch[0], ch[1], ch[2])[0])
	}
	fmt.Println(resultPart2)
}

func getResult(val int32) int32 {
	res := val - 96
	if res < 0 {
		res = val - 38
	}

	return res
}

func Intersection(a, b string) int32 {
	m := make(map[int32]bool)

	for _, item := range a {
		m[item] = true
	}

	for _, item := range b {
		if _, ok := m[item]; ok {
			return item
		}
	}
	panic("no intersect")
}

func IntersectionBis(a, b, c string) (d []int32) {
	m := make(map[int32]bool)
	n := make(map[int32]bool)

	for _, item := range a {
		m[item] = true
	}
	for _, item := range b {
		n[item] = true
	}

	for _, item := range c {
		if _, ok := m[item]; ok {
			if _, ok := n[item]; ok {
				d = append(d, item)
			}
		}
	}
	return
}

func chunkBy(items []string, chunkSize int) (chunks [][]string) {
	for chunkSize < len(items) {
		items, chunks = items[chunkSize:], append(chunks, items[0:chunkSize:chunkSize])
	}

	return append(chunks, items)
}
