<?php

// TODO algorithme Breadth-First Search

include("BFSUtil.php");
// Cf Tree.png
$tabData = [1 => [2 => [5 => [9 => []]], 3 => [6 => [10 => []], 7 => []], 4 => [8 => []]]];
$objDfs = new BFSUtil($tabData);
$objDfs->buildResult();

$tabResultExpected = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
if ($tabResultExpected === $objDfs->getTabResult()) {
    echo "OK\n";
} else {
    echo "NOK\n";
}