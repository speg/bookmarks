<?php


$file = file_get_contents("Files/chrome.html");

$pattern = "|href=\"http://(.*)\".*>(.*)</a>|i";

preg_match_all($pattern,$file,$matches,PREG_SET_ORDER);

echo "<pre>";
foreach ($matches as $val) {
    echo "matched: " . $val[0] . "\n";
    echo "part 1: " . $val[1] . "\n";
    echo "part 2: " . $val[2] . "\n\n";
}
echo "</pre>";
