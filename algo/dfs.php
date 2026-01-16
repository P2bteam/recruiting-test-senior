<?php

// TODO algorithme Depth-First Search

include("DFSUtil.php");
// Cf Tree.png
$tabData = [1 => [2 => [5 => [9 => []]], 3 => [6 => [10 => []], 7 => []], 4 => [8 => []]]];
$objDfs = new DFSUtil($tabData);
$objDfs->buildResult();

$tabResultExpected = [1, 2, 5, 9, 3, 6, 10, 7, 4, 8];
if ($tabResultExpected === $objDfs->getTabResult()) {
    echo "OK\n";
} else {
    echo "NOK\n";
}