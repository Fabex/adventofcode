package main

import (
	"fmt"
	"os"
	"strings"
)

type Item struct {
	Type  string
	Size  int
	Name  string
	Items []Item
}

func main() {
	data, _ := os.ReadFile("./data.txt")
	ar := strings.Split(string(data), "\n")
	//pwd := Item{Type: "folder", Name: "/"}
	for i := 0; i < len(ar); i++ {
		line := ar[i]
		if line[0:1] == "$" {
			if line[2:3] == "l" {
				fmt.Println(line)
			}
		}
	}
}
