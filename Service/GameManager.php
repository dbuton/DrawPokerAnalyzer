<?php

namespace App\Service;

require_once("Entity/Card.php");
require_once("Entity/Game.php");
require_once("Service/DeckManager.php");
require_once("Service/HandAnalyzer.php");

use App\Entity\Card;
use App\Entity\Game;
use App\Entity\Result;

class GameManager
{
    public function launchGame()
    {
        $deckManager = new DeckManager();
        $deck = $deckManager->getDeck();

        $game = $this->distribute($deck);

        $this->displayGame($game);

        $blackHandResult = $this->analyzeHand($game->getBlackHand(), 'Black');
        $whiteHandResult = $this->analyzeHand($game->getWhiteHand(), 'White');

        $this->displayGameResult($blackHandResult, $whiteHandResult);
        $winner = $this->checkWinner($blackHandResult, $whiteHandResult);

        $this->displayWinner($winner);
    }

    public function distribute(array $deck) : Game
    {
        return new Game($deck);
    }

    public function analyzeHand(array $playerHand, string $playerName) : Result
    {
        $handAnalyzer = new HandAnalyzer($playerHand, $playerName);
        return $handAnalyzer->analyse();

    }

    public function checkWinner(Result $blackHandResult, Result $whiteHandResult) : ?Result
    {
        if ($blackHandResult->getHandTotalWeight() > $whiteHandResult->getHandTotalWeight()) {
            return $blackHandResult;
        }

        if ($blackHandResult->getHandTotalWeight() < $whiteHandResult->getHandTotalWeight()) {
            return $whiteHandResult;
        }

        return null;
    }

    private function displayGame(Game $game) : void
    {
        echo 'Black Player : ';
        $this->displayCards($game->getBlackHand());
        echo 'White Player : ';
        $this->displayCards($game->getWhiteHand());
        echo ("\n");
    }

    private function displayGameResult(Result $blackHandResult, Result $whiteHandResult) : void
    {
        $this->displayHandResult($blackHandResult);
        $this->displayHandResult($whiteHandResult);
    }

    public function displayHandResult(Result $handResult) : void
    {
        echo $handResult->getPlayerName() . ' Player : ' . $handResult->getRank() . ' with ' . $handResult->getDescription();
        echo ("\n");
    }

    /**
     * @param Card[] $cards
     */
    public function displayCards(array $cards) : void
    {
        foreach ($cards as $card) {
            echo $card->getValue() . $card->getSuit() . ' ';
        }
        echo ("\n");
    }

    private function displayWinner(?Result $winner) : void
    {
        if ($winner === null) {
            echo 'SPLIT !!!';
        }

        echo 'Winner : '. $winner->getPlayerName();
        echo ("\n");
    }
}
