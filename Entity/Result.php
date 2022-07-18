<?php

namespace App\Entity;

class Result
{
    const STRAIGHT_FLUSH    = 'Straight flush';
    const FOUR_OF_KIND      = 'Four of Kind';
    const FULL_HOUSE        = 'Full house';
    const FLUSH             = 'Flush';
    const STRAIGHT          = 'Straight';
    const THREE_OF_KIND     = 'Three of kind';
    const TWO_PAIR          = 'Two pair';
    const PAIR              = 'Pair';
    const HIGH_CARD         = 'High card';

    public static array $handRanking = [
        self::HIGH_CARD         => 50000,
        self::PAIR              => 100000,
        self::TWO_PAIR          => 150000,
        self::THREE_OF_KIND     => 300000,
        self::STRAIGHT          => 450000,
        self::FLUSH             => 600000,
        self::FULL_HOUSE        => 750000,
        self::FOUR_OF_KIND      => 900000,
        self::STRAIGHT_FLUSH    => 1050000,
    ];

    /** @var Card[] */
    private array $hand;

    private string $playerName;
    private string $rank;
    private string $description;
    private string $highCardValue;

    public function __construct(string $playerName, array $hand, string $rank, string $highCardValue, string $description)
    {
        $this->playerName = $playerName;
        $this->hand = $hand;
        $this->rank = $rank;
        $this->highCardValue = $highCardValue;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getPlayerName(): string
    {
        return $this->playerName;
    }

    /**
     * @return Card[]
     */
    public function getHand(): array
    {
        return $this->hand;
    }

    public function getRank(): string
    {
        return $this->rank;
    }

    public function getHighCardValue(): string
    {
        return $this->highCardValue;
    }

    public function getHighCardWeight(): string
    {
        return Card::$cardValueWeight[$this->highCardValue];
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getHandTotalWeight() : int
    {
        $totalWeight = 0;

        foreach ($this->hand as $card) {
            $totalWeight += $card->getValueWeight();
        }
        $totalWeight += self::$handRanking[$this->rank];
        return $totalWeight;
    }
}
