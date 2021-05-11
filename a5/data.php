<?php
/*
Andy Le
000805099
PHP file for getting data
I, Andy Le, 000805099 certify that this material is my original work. No other person's work has been used without due acknowledgement.
*/
include "connect.php";
include "stock.php";
session_start();
$access = isset($_SESSION["userid"]);
if ($access) {
	$command = "SELECT stockid, stockname, currentprice, updatedatetime from stockupdates ORDER BY updatedatetime DESC";
	$stmt = $dbh->prepare($command);
	$success = $stmt->execute();
	$stocklist = [];
	if ($success) {
		while ($row = $stmt->fetch()) {
			$astock = [
				"id"=>$row["stockid"],
				"name"=>$row["stockname"],
				"price"=>$row["currentprice"],
				"time"=>$row["updatedatetime"]
			];
			array_push($stocklist, $astock);
		}
	} else {
		echo "<p>Fail…</p>";
	}
} else {
	echo "<p>Not Logged in. Access denied.</p>";
}

echo json_encode($stocklist);
?>