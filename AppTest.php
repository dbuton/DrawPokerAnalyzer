<?php

namespace App;

require_once("./Entity/Card.php");
require_once("./Service/GameManager.php");

use App\Entity\Card;
use App\Service\GameManager;

$gameManager = new GameManager();

//High Card Test
$hand = [
    new Card('2', 'C'),
    new Card('8', 'D'),
    new Card('6', 'S'),
    new Card('A', 'C'),
    new Card('K', 'C'),
];

$result = $gameManager->analyzeHand($hand, 'High Card Test');
$gameManager->displayCards($hand);
$gameManager->displayHandResult($result);


//Pair Test
$hand = [
    new Card('2', 'C'),
    new Card('A', 'D'),
    new Card('6', 'S'),
    new Card('A', 'C'),
    new Card('K', 'C'),
];

$result = $gameManager->analyzeHand($hand, 'Pair Test');
$gameManager->displayCards($hand);
$gameManager->displayHandResult($result);

//Two Pair Test
$hand = [
    new Card('2', 'C'),
    new Card('A', 'D'),
    new Card('K', 'S'),
    new Card('A', 'C'),
    new Card('K', 'C'),
];

$result = $gameManager->analyzeHand($hand, 'Two Pair Test');
$gameManager->displayCards($hand);
$gameManager->displayHandResult($result);

//Three of kind Test
$hand = [
    new Card('2', 'C'),
    new Card('8', 'D'),
    new Card('K', 'S'),
    new Card('K', 'D'),
    new Card('K', 'C'),
];

$result = $gameManager->analyzeHand($hand, 'Three of kind Test');
$gameManager->displayCards($hand);
$gameManager->displayHandResult($result);


//Straight Test
$hand = [
    new Card('6', 'C'),
    new Card('7', 'D'),
    new Card('8', 'S'),
    new Card('9', 'D'),
    new Card('T', 'C'),
];

$result = $gameManager->analyzeHand($hand, 'Straight Test');
$gameManager->displayCards($hand);
$gameManager->displayHandResult($result);


//Flush Test
$hand = [
    new Card('2', 'D'),
    new Card('7', 'D'),
    new Card('A', 'D'),
    new Card('9', 'D'),
    new Card('K', 'D'),
];

$result = $gameManager->analyzeHand($hand, 'Straight Test');
$gameManager->displayCards($hand);
$gameManager->displayHandResult($result);

//Full House Test
$hand = [
    new Card('3', 'C'),
    new Card('3', 'D'),
    new Card('3', 'S'),
    new Card('T', 'D'),
    new Card('T', 'C'),
];

$result = $gameManager->analyzeHand($hand, 'Full house Test');
$gameManager->displayCards($hand);
$gameManager->displayHandResult($result);

//Straight Flush Test
$hand = [
    new Card('3', 'C'),
    new Card('3', 'D'),
    new Card('3', 'S'),
    new Card('3', 'D'),
    new Card('T', 'C'),
];

$result = $gameManager->analyzeHand($hand, 'Four of kind Test');
$gameManager->displayCards($hand);
$gameManager->displayHandResult($result);

$hand = [
    new Card('3', 'C'),
    new Card('4', 'C'),
    new Card('5', 'C'),
    new Card('6', 'C'),
    new Card('7', 'C'),
];

$result = $gameManager->analyzeHand($hand, 'Straight Flush Test');
$gameManager->displayCards($hand);
$gameManager->displayHandResult($result);
