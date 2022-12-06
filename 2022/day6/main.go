package main

import (
	"fmt"
	"os"
	"strings"
)

func main() {
	data, _ := os.ReadFile("./data.txt")
	stream := strings.Split(string(data), "\n")[0]
	fmt.Println(findMarker(stream, 4))  // part1
	fmt.Println(findMarker(stream, 14)) // part2
}

func findMarker(stream string, size int) int {
	for i := 0; i <= len(stream)-size; i++ {
		subPart := stream[i : i+size]
		countTotal := 0
		for j := 0; j < len(subPart); j++ {
			countTotal += strings.Count(subPart, subPart[j:j+1])
		}
		if countTotal == size {
			return i + size
		}
	}
	panic("impossible")
}
