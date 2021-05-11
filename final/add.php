<?php

$name = $_REQUEST["name"];
$comment = $_REQUEST["text"];

try {
    $dbh = new PDO("mysql:host=csunix.mohawkcollege.ca;dbname=000805099", "000805099", "19991222");
    try {
        $stmt = $dbh->prepare("INSERT INTO comments (name, comment) VALUES (?, ?)");
        $stmt->execute([$name, $comment]);
        echo "Success";
    } catch (Exception $e) {
        echo "Error selecting";
    }
} catch (Exception $e) {
    echo "Error connecting";
}


?>