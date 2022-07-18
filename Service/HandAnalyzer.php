<?php

namespace App\Service;

require_once("Entity/Card.php");
require_once("Entity/Result.php");

use App\Entity\Card;
use App\Entity\Result;

class HandAnalyzer
{
    private array $hand = [];
    private array $orderedValueHand = [];
    private array $orderedSuitHand = [];

    private string $playerName;

    public function __construct(array $hand, string $playerName)
    {
        $this->hand = $hand;
        $this->orderedValueHand = $this->orderByValue($hand);
        $this->orderedSuitHand = $this->orderBySuit($hand);

        $this->playerName = $playerName;
    }

    public function analyse() : ?Result
    {
        if ($this->hasStraightFlush()) {
            return $this->hasStraightFlush();
        }

        if ($this->hasFourOfKind()) {
            return $this->hasFourOfKind();
        }

        if ($this->hasFullHouse()) {
            return $this->hasFullHouse();
        }

        if ($this->hasFlush()) {
            return $this->hasFlush();
        }

        if ($this->hasStraight()) {
            return $this->hasStraight();
        }

        if ($this->hasThreeOfKind()) {
            return $this->hasThreeOfKind();
        }

        if ($this->hasTwoPair()) {
            return $this->hasTwoPair();
        }

        if ($this->hasPair()) {
            return $this->hasPair();
        }

        if ($this->hasHighCard()) {
            return $this->hasHighCard();
        }

        return null;
    }

    private function hasStraightFlush() : ?Result
    {
        $flushResult = $this->hasFlush();
        $straightResult = $this->hasStraight();

        if ($this->hasFlush() !== null && $this->hasStraight() !== null) {
            return new Result(
                $this->playerName,
                $this->hand,
                Result::STRAIGHT_FLUSH,
                $straightResult->getHighCardValue(),
                $straightResult->getDescription()
            );
        }
        return null;
    }

    private function hasFourOfKind() : ?Result
    {
        foreach ($this->orderedValueHand as $key => $cardsValue) {
            if (count($cardsValue) === 4) {
                return new Result(
                    $this->playerName,
                    $this->hand,
                    Result::FOUR_OF_KIND,
                    array_search($key, Card::$cardValueWeight),
                    array_search($key, Card::$cardValueWeight)
                );
            }
        }
        return null;
    }

    private function hasFullHouse() : ?Result
    {
        $threeOfKindResult = $this->hasThreeOfKind();
        $pairResult = $this->hasPair();

        if ($this->hasThreeOfKind() !== null && $this->hasPair() !== null) {
            return new Result(
                $this->playerName,
                $this->hand,
                Result::FULL_HOUSE,
                $threeOfKindResult->getHighCardValue(),
                $threeOfKindResult->getDescription() . ' and ' . $pairResult->getDescription()
            );
        }
        return null;
    }

    private function hasFlush() : ?Result
    {
        if (count($this->orderedSuitHand) === 1) {

            $orderValueHand = $this->orderedValueHand;
            $card = array_shift($orderValueHand)[0];

            return new Result(
                $this->playerName,
                $this->hand,
                Result::FLUSH,
                $card->getValue(),
                $card->getValue()
            );
        }

        return null;
    }

    private function hasStraight() : ?Result
    {
        if (count($this->orderedValueHand) < 5) {
            return null;
        }

        $previousCardValue = null;

        foreach ($this->orderedValueHand as $key => $cardsValue) {
            if ($previousCardValue !== null && ($key * 2) !== $previousCardValue) {
                return null;
            }
            $previousCardValue = $key;
        }

        return new Result(
            $this->playerName,
            $this->hand,
            Result::STRAIGHT,
            array_search(array_key_first($this->orderedValueHand), Card::$cardValueWeight),
            array_search(array_key_first($this->orderedValueHand), Card::$cardValueWeight)
        );
    }

    private function hasThreeOfKind() : ?Result
    {
        foreach ($this->orderedValueHand as $key => $cardsValue) {
            if (count($cardsValue) === 3) {
                return new Result(
                    $this->playerName,
                    $this->hand,
                    Result::THREE_OF_KIND,
                    array_search($key, Card::$cardValueWeight),
                    array_search($key, Card::$cardValueWeight)
                );
            }
        }
        return null;
    }

    private function hasTwoPair() : ?Result
    {
        $topPairValue = null;
        foreach ($this->orderedValueHand as $key => $cardsValue) {
            if (count($cardsValue) === 2) {
                if ($topPairValue !== null) {
                    return new Result(
                        $this->playerName,
                        $this->hand,
                        Result::TWO_PAIR,
                        $topPairValue,
                        $topPairValue . ' and ' . array_search($key, Card::$cardValueWeight)
                    );
                }
                $topPairValue = array_search($key, Card::$cardValueWeight);
            }
        }
        return null;
    }

    private function hasPair() : ?Result
    {
        foreach ($this->orderedValueHand as $key => $cardsValue) {
            if (count($cardsValue) === 2) {
                return new Result(
                    $this->playerName,
                    $this->hand,
                    Result::PAIR,
                    array_search($key, Card::$cardValueWeight),
                    array_search($key, Card::$cardValueWeight)
                );
            }
        }
        return null;
    }

    private function hasHighCard() : ?Result
    {
        return new Result(
            $this->playerName,
            $this->hand,
            Result::HIGH_CARD,
            array_search(array_key_first($this->orderedValueHand), Card::$cardValueWeight),
            array_search(array_key_first($this->orderedValueHand), Card::$cardValueWeight)
        );
    }

    /**
     * @param Card[] $hand
     *
     * @return array
     */
    private function orderByValue(array $hand) : array
    {
        $orderedHand = [];

        foreach ($hand as $card) {
            if (!isset($orderedHand[$card->getValueWeight()])) {
                $orderedHand[$card->getValueWeight()] = [];
            }
            $orderedHand[$card->getValueWeight()][] = $card;
        }
        krsort($orderedHand);

        return $orderedHand;
    }

    /**
     * @param Card[] $hand
     *
     * @return array
     */
    private function orderBySuit(array $hand) : array
    {
        $orderedHand = [];

        foreach ($hand as $card) {
            if (!isset($orderedHand[$card->getSuit()])) {
                $orderedHand[$card->getSuit()] = [];
            }
            $orderedHand[$card->getSuit()][] = $card;
        }
        return $orderedHand;
    }
}
