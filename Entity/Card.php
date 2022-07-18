<?php

namespace App\Entity;

class Card
{
    public static array $cardValueWeight = [
        '1' => 1,
        '2' => 2,
        '3' => 4,
        '4' => 8,
        '5' => 16,
        '6' => 32,
        '7' => 64,
        '8' => 128,
        '9' => 256,
        'T' => 512,
        'J' => 1024,
        'Q' => 2048,
        'K' => 4096,
        'A' => 8192
    ];

    private string $value;
    private string $suit;

    /**
     * Card constructor.
     *
     * @param string $value
     * @param string $suit
     */
    public function __construct(string $value, string $suit)
    {
        $this->value = $value;
        $this->suit = $suit;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getValueWeight(): int
    {
        return self::$cardValueWeight[$this->value];
    }

    public function getSuit(): string
    {
        return $this->suit;
    }
}
