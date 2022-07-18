<?php

namespace App\Service;

require_once("Entity/Card.php");
require_once("Entity/Result.php");

use App\Entity\Card;
use App\Entity\Result;

class HandAnalyzer
{
    /** @var Card[] $hand  */
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
        if ($result = $this->hasStraightFlush()) {
            return $result;
        }

        if ($result = $this->hasFourOfKind()) {
            return $result;
        }

        if ($result = $this->hasFullHouse()) {
            return $result;
        }

        if ($result = $this->hasFlush()) {
            return $result;
        }

        if ($result = $this->hasStraight()) {
            return $result;
        }

        if ($result = $this->hasThreeOfKind()) {
            return $result;
        }

        if ($result = $this->hasTwoPair()) {
            return $result;
        }

        if ($result = $this->hasPair()) {
            return $result;
        }

        if ($result = $this->hasHighCard()) {
            return $result;
        }

        return null;
    }

    private function hasStraightFlush() : ?Result
    {
        $straightResult = $this->hasStraight(true);

        if ($this->hasFlush() !== null && $straightResult !== null) {
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

    private function hasStraight($forStraightFlush = false) : ?Result
    {
        if (count($this->orderedValueHand) < 5) {
            return null;
        }

        $previousCardValue = null;
        $hasAs = false;
        $hasFive = false;

        foreach ($this->orderedValueHand as $key => $cardsValue) {
            if ($previousCardValue !== null &&
                $previousCardValue !== 8192 &&
                $key !== 8192 &&
                ($key * 2) !== $previousCardValue || ($key === 2 && $hasAs === false))
            {
                return null;
            }
            $previousCardValue = $key;
            $hasAs   = ($hasAs || $key === 8192);
            $hasFive = ($hasFive || $key === 16);
        }

        if ($hasFive === true && $hasAs === true && $forStraightFlush === false) {
            foreach ($this->hand as $key => $card) {
                if ($card->getValue() === "A") {
                    $this->hand[] = new Card('1', $card->getSuit());
                    unset($this->hand[$key]);
                    $this->orderedValueHand = $this->orderByValue($this->hand);
                }
            }
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
