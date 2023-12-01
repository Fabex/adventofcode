package main

import (
	"fmt"
	"github.com/davecgh/go-spew/spew"
	"os"
	"regexp"
	"slices"
	"strings"
)

func main() {
	input, _ := os.ReadFile("data.txt")
	nums := []string{"1", "2", "3", "4", "5", "6", "7", "8", "9",
		"one", "two", "three", "four", "five", "six", "seven", "eight", "nine"}

	calc := func(nums []string) (result int) {
		first := regexp.MustCompile(`(` + strings.Join(nums, "|") + `)`)
		last := regexp.MustCompile(`.*` + first.String())

		for _, s := range strings.Fields(string(input)) {
			t := slices.Index(nums, first.FindStringSubmatch(s)[1])%9 + 1
			a := slices.Index(nums, last.FindStringSubmatch(s)[1])%9 + 1
			spew.Dump(fmt.Sprintf("%d%d", t, a))
			result += 10 * (t)
			result += a
		}

		return
	}

	fmt.Println(calc(nums[:9]))
	fmt.Println(calc(nums))
}
