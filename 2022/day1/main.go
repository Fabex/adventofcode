package main

import (
	"fmt"
	"os"
	"sort"
	"strconv"
	"strings"
)

func main() {
	data, err := os.ReadFile("./data.txt")
	ar := strings.Split(string(data), "\n")
	if err != nil {
		panic(err)
	}
	var elfs []int
	i := 0
	for _, cal := range ar {
		c, _ := strconv.Atoi(cal)
		if c == 0 {
			elfs = append(elfs, i)
			i = 0
			continue
		}
		i += c
	}
	sort.Sort(sort.Reverse(sort.IntSlice(elfs[:])))
	fmt.Println(elfs[0:1][0])
	t := 0
	for _, v := range elfs[0:3] {
		t += v
	}
	fmt.Println(t)
}
