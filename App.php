<?php

namespace App;

require_once("./Service/GameManager.php");

use App\Service\GameManager;

$gameManager = new GameManager();
$gameManager->launchGame();


