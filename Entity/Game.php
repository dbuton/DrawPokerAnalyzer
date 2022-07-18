<?php

namespace App\Entity;

require_once("Entity/Card.php");

class Game
{
    private array $blackHand = [];
    private array $whiteHand = [];

    public function __construct(array $deck)
    {
        $this->managePlayersHand($deck);
    }

    private function managePlayersHand(array $deck) : array
    {
        $i = 5;
        while ($i > 0) {
            $this->whiteHand[] = array_pop($deck);
            $this->blackHand[] = array_pop($deck);
            $i--;
        }

        return $deck;
    }

    public function getBlackHand(): array
    {
        return $this->blackHand;
    }

    public function getWhiteHand(): array
    {
        return $this->whiteHand;
    }
}
