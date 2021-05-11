<?php

try {
    $dbh = new PDO("mysql:host=csunix.mohawkcollege.ca;dbname=000805099", "000805099", "19991222");
    try {
        $command = "SELECT id, name, comment FROM comments ORDER BY id DESC";
        $stmt = $dbh->prepare($command);
        $success = $stmt->execute();
        $commentlist = [];
        if ($success) {
            while ($row = $stmt->fetch()) {
                $acomment = [
                    "id"=>$row["id"],
                    "name"=>$row["name"],
                    "comment"=>$row["comment"]
                ];
                array_push($commentlist, $acomment);
            }
        } else {
            echo "Fail";
        }
        echo json_encode($commentlist);
    } catch (Exception $e) {
        echo "Error selecting";
    }
} catch (Exception $e) {
    echo "Error connecting";
}

?>