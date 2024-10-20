<?php
$timeTarget = 0.350; //miliseonds
$cost = 10; //base cost (default aslo)

do {
    $cost++;
    $start = microtime(true);
    password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
    $end = microtime(true);
} while (($end - $start) < $timeTarget);
echo "Appropriate cost: " . $cost;
?>