<?php

namespace App\Service;

require_once("Entity/Card.php");

use App\Entity\Card;

class DeckManager
{
    public static array $cardValueList = ['2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'];
    public static array $cardSuitList = ['H', 'D', 'S', 'C'];

    private array $deck;


    public function __construct()
    {
        $this->buildDeck();
        $this->mixDeck();
    }

    public function buildDeck() : void
    {
        foreach (self::$cardSuitList as $suit) {
            foreach (self::$cardValueList as $value) {
                $this->deck[] = new Card($value, $suit);
            }
        }
    }

    public function mixDeck() : void
    {
        shuffle($this->deck);
    }

    public function getDeck(): array
    {
        return $this->deck;
    }
}
