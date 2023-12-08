package main

import (
	"fmt"
	"os"
	"sort"
	"strconv"
	"strings"
)

type TypeHand int

const (
	fiveOfKind  TypeHand = 7
	fourOfKind  TypeHand = 6
	fullHouse   TypeHand = 5
	threeOfKind TypeHand = 4
	twoPairs    TypeHand = 3
	pair        TypeHand = 2
	highCard    TypeHand = 1
)

type card struct {
	value    int
	position int
}

type hand struct {
	bid      int
	cards    []card
	typeHand TypeHand
}

var hands []hand

func main() {
	input, _ := os.ReadFile("data.txt")
	lines := strings.Split(string(input), "\n")
	do(lines, false, map[string]int{
		"A": 14,
		"K": 13,
		"Q": 12,
		"J": 11,
		"T": 10,
	})
	fmt.Println("Part1: " + strconv.Itoa(calcResult()))

	hands = hands[:0]
	do(lines, true, map[string]int{
		"A": 14,
		"K": 13,
		"Q": 12,
		"J": 11,
		"T": 10,
	})

	fmt.Println("Part2: " + strconv.Itoa(calcResult()))
}

func calcResult() int {
	var res = 0
	for idx, h := range hands {
		res += h.bid * (idx + 1)
	}
	return res
}

func do(lines []string, useJoker bool, cardValues map[string]int) {
	for _, line := range lines {
		var h hand
		tmp := strings.Split(line, " ")
		h.bid, _ = strconv.Atoi(tmp[1])
		cards := strings.Split(tmp[0], "")
		for idx, c := range cards {
			var card card
			card.position = idx
			val, ok := cardValues[c]
			if ok {
				card.value = val
			} else {
				card.value, _ = strconv.Atoi(c)
			}
			h.cards = append(h.cards, card)
		}
		h.typeHand = calcTypeHand(h.cards, useJoker)
		hands = append(hands, h)
	}

	if useJoker {
		for hi, h := range hands {
			for ci, c := range h.cards {
				if c.value == 11 {
					hands[hi].cards[ci].value = 1
				}
			}
		}
	}

	sort.SliceStable(hands, sortCardValue)
}

func sortCardValue(i, j int) bool {
	if hands[i].typeHand == hands[j].typeHand {
		if hands[i].cards[0].value == hands[j].cards[0].value {
			if hands[i].cards[1].value == hands[j].cards[1].value {
				if hands[i].cards[2].value == hands[j].cards[2].value {
					if hands[i].cards[3].value == hands[j].cards[3].value {
						if hands[i].cards[4].value == hands[j].cards[4].value {
							return hands[i].cards[0].position < hands[j].cards[0].position
						}
						return hands[i].cards[4].value < hands[j].cards[4].value
					}
					return hands[i].cards[3].value < hands[j].cards[3].value
				}
				return hands[i].cards[2].value < hands[j].cards[2].value
			}
			return hands[i].cards[1].value < hands[j].cards[1].value
		}
		return hands[i].cards[0].value < hands[j].cards[0].value
	}
	return hands[i].typeHand < hands[j].typeHand
}

func calcTypeHand(cards []card, joker bool) TypeHand {
	var typeHand TypeHand
	var values []int
	for _, c := range cards {
		if c.value == 11 {
			values = append(values, 1)
			continue
		}
		values = append(values, c.value)
	}
	sort.Ints(values)

	typeHand = highCard
	if values[0] == values[1] && values[1] == values[2] && values[2] == values[3] && values[3] == values[4] {
		typeHand = fiveOfKind
	} else if values[0] == values[1] && values[1] == values[2] && values[2] == values[3] {
		typeHand = fourOfKind
	} else if values[1] == values[2] && values[2] == values[3] && values[3] == values[4] {
		typeHand = fourOfKind
	} else if values[0] == values[1] && values[1] == values[2] && values[3] == values[4] {
		typeHand = fullHouse
	} else if values[0] == values[1] && values[2] == values[3] && values[3] == values[4] {
		typeHand = fullHouse
	} else if values[0] == values[1] && values[1] == values[2] {
		typeHand = threeOfKind
	} else if values[1] == values[2] && values[2] == values[3] {
		typeHand = threeOfKind
	} else if values[2] == values[3] && values[3] == values[4] {
		typeHand = threeOfKind
	} else if values[0] == values[1] && values[2] == values[3] {
		typeHand = twoPairs
	} else if values[0] == values[1] && values[3] == values[4] {
		typeHand = twoPairs
	} else if values[1] == values[2] && values[3] == values[4] {
		typeHand = twoPairs
	} else if values[0] == values[1] {
		typeHand = pair
	} else if values[1] == values[2] {
		typeHand = pair
	} else if values[2] == values[3] {
		typeHand = pair
	} else if values[3] == values[4] {
		typeHand = pair
	}
	nbJoker := nbJoker(values)
	if joker && nbJoker > 0 {
		typeHand = calcTypeHandWithJoker(typeHand, nbJoker)
	}
	return typeHand
}

func calcTypeHandWithJoker(typeHand TypeHand, nbJoker int) TypeHand {
	if nbJoker == 1 {
		if typeHand == highCard {
			return pair
		}
		if typeHand == pair {
			return threeOfKind
		}
		if typeHand == twoPairs {
			return fullHouse
		}
		if typeHand == threeOfKind {
			return fourOfKind
		}
		if typeHand == fourOfKind {
			return fiveOfKind
		}
	}
	if nbJoker == 2 {
		if typeHand == pair {
			return threeOfKind
		}
		if typeHand == twoPairs {
			return fourOfKind
		}
		if typeHand == fullHouse {
			return fiveOfKind
		}
	}
	if nbJoker == 3 {
		if typeHand == threeOfKind {
			return fourOfKind
		}
		if typeHand == fullHouse {
			return fiveOfKind
		}
	}
	if nbJoker == 4 {
		return fiveOfKind
	}
	return typeHand
}

func nbJoker(b []int) int {
	var nb = 0
	for _, b := range b {
		if b == 1 {
			nb++
		}
	}
	return nb
}
