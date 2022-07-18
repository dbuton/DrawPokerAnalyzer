<?php

namespace App\Test;

require_once("./Service/GameManager.php");

use App\Entity\Card;
use App\Service\GameManager;

class HandAnalyzerTest
{
    private GameManager $gameManager;

    public static array $handTypeTest = [
        'highCard',
        'pair',
        'twoPair',
        'threeOfKind',
        'straight',
        'flush',
        'fullHouse',
        'straightFlush',
    ];

    public function __construct()
    {
        $this->gameManager = new GameManager();
    }

    public function testAll() {
        $this->highCardTest();
        $this->pairTest();
        $this->twoPairTest();
        $this->threeOfKindTest();
        $this->straightTest();
        $this->flushTest();
        $this->fullHouseTest();
        $this->fourOfKindTest();
        $this->straightFlushTest();
    }

    public function highCardTest() {

        $hand = [
            new Card('2', 'C'),
            new Card('8', 'D'),
            new Card('6', 'S'),
            new Card('A', 'C'),
            new Card('K', 'C'),
        ];

        $result = $this->gameManager->analyzeHand($hand, 'High Card Test');
        $this->gameManager->displayCards($hand);
        $this->gameManager->displayHandResult($result);
    }

    public function pairTest()
    {
        $hand = [
            new Card('2', 'C'),
            new Card('A', 'D'),
            new Card('6', 'S'),
            new Card('A', 'C'),
            new Card('K', 'C'),
        ];

        $result = $this->gameManager->analyzeHand($hand, 'Pair Test');
        $this->gameManager->displayCards($hand);
        $this->gameManager->displayHandResult($result);
    }

    public function twoPairTest()
    {
        $hand = [
            new Card('2', 'C'),
            new Card('A', 'D'),
            new Card('K', 'S'),
            new Card('A', 'C'),
            new Card('K', 'C'),
        ];

        $result = $this->gameManager->analyzeHand($hand, 'Two Pair Test');
        $this->gameManager->displayCards($hand);
        $this->gameManager->displayHandResult($result);
    }

    public function threeOfKindTest()
    {
        $hand = [
            new Card('2', 'C'),
            new Card('8', 'D'),
            new Card('K', 'S'),
            new Card('K', 'D'),
            new Card('K', 'C'),
        ];

        $result = $this->gameManager->analyzeHand($hand, 'Three of kind Test');
        $this->gameManager->displayCards($hand);
        $this->gameManager->displayHandResult($result);
    }

    public function straightTest()
    {
        $hand = [
            new Card('A', 'C'),
            new Card('2', 'D'),
            new Card('3', 'S'),
            new Card('4', 'D'),
            new Card('5', 'C'),
        ];

        $result = $this->gameManager->analyzeHand($hand, 'Straight Test');
        $this->gameManager->displayCards($hand);
        $this->gameManager->displayHandResult($result);

        $hand = [
            new Card('A', 'C'),
            new Card('K', 'D'),
            new Card('Q', 'S'),
            new Card('J', 'D'),
            new Card('T', 'C'),
        ];

        $result = $this->gameManager->analyzeHand($hand, 'Straight Test');
        $this->gameManager->displayCards($hand);
        $this->gameManager->displayHandResult($result);
    }

    public function flushTest()
    {
        $hand = [
            new Card('2', 'D'),
            new Card('7', 'D'),
            new Card('A', 'D'),
            new Card('9', 'D'),
            new Card('K', 'D'),
        ];

        $result = $this->gameManager->analyzeHand($hand, 'Flush Test');
        $this->gameManager->displayCards($hand);
        $this->gameManager->displayHandResult($result);
    }

    public function fullHouseTest()
    {
        $hand = [
            new Card('3', 'C'),
            new Card('3', 'D'),
            new Card('3', 'S'),
            new Card('T', 'D'),
            new Card('T', 'C'),
        ];

        $result = $this->gameManager->analyzeHand($hand, 'Full house Test');
        $this->gameManager->displayCards($hand);
        $this->gameManager->displayHandResult($result);
    }

    public function fourOfKindTest()
    {
        $hand = [
            new Card('3', 'C'),
            new Card('3', 'D'),
            new Card('3', 'S'),
            new Card('3', 'D'),
            new Card('T', 'C'),
        ];

        $result = $this->gameManager->analyzeHand($hand, 'Four of kind Test');
        $this->gameManager->displayCards($hand);
        $this->gameManager->displayHandResult($result);
    }

    public function straightFlushTest()
    {
        $hand = [
            new Card('3', 'C'),
            new Card('4', 'C'),
            new Card('5', 'C'),
            new Card('6', 'C'),
            new Card('7', 'C'),
        ];

        $result = $this->gameManager->analyzeHand($hand, 'Straight Flush Test');
        $this->gameManager->displayCards($hand);
        $this->gameManager->displayHandResult($result);
    }
}
