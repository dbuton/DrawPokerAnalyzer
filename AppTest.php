<?php

namespace App;

use App\Test\HandAnalyzerTest;

require_once("./Test/HandAnalyzerTest.php");

$handAnalyzerTest = new HandAnalyzerTest();

if (isset($argv[1])) {
    if (!in_array($argv[1], HandAnalyzerTest::$handTypeTest)) {
        echo "Parameter must be : " . implode(',', HandAnalyzerTest::$handTypeTest) . "\n";
    } else {
        $function = $argv[1].'Test';
        $handAnalyzerTest->$function();
    }
} else {
    $handAnalyzerTest->testAll();
}



