<?php

include "camp.php";
try {
    $dbh = new PDO("mysql:host=localhost;dbname=camp", "root", "");
    try {
        $command = "SELECT id, name, url, longitude, latitude, address, community FROM camp";
        $stmt = $dbh->prepare($command);
        $success = $stmt->execute();
        $camplist = [];
        if ($success) {
            while ($row = $stmt->fetch()) {
                $acamp = [
                    "id"=>$row["id"],
                    "name"=>$row["name"],
                    "url"=>$row["url"],
                    "longitude"=>$row["longitude"],
                    "latitude"=>$row["latitude"],
                    "address"=>$row["address"],
                    "community"=>$row["community"]
                ];
                array_push($camplist, $acamp);
            }
        } else {
            echo "Fail";
        }

        echo json_encode($camplist);
    } catch (Exception $e) {
        echo "Error selecting";
    }
} catch (Exception $e) {
    echo "Error connecting";
}

?>