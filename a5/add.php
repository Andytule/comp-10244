<?php
/*
Andy Le
000805099
PHP file to add to database
I, Andy Le, 000805099 certify that this material is my original work. No other person's work has been used without due acknowledgement.
*/
session_start();
include "connect.php";
include "stock.php";

$stockname = filter_input(INPUT_POST, "stockname", FILTER_SANITIZE_SPECIAL_CHARS);
$stockprice = filter_input(INPUT_POST, "stockprice", FILTER_VALIDATE_FLOAT);
$stocktime = filter_input(INPUT_POST, "stocktime", FILTER_SANITIZE_STRING);

$valid = true;
if ((!$stockname) or (!$stockprice or $stockprice === null) or (!$stocktime)) {
	$valid = false;
}

$access = isset($_SESSION["userid"]);

if ($access) {
	if ($valid) {
		date_default_timezone_set("America/Toronto");
		$today = date("H:i:s"); 
		$stocktime = $stocktime . " " . $today;
		$command = "INSERT into stockupdates (stockname, currentprice, updatedatetime) VALUES (?, ?, ?)";
		$stmt = $dbh->prepare($command);
		$params = [$stockname, $stockprice, $stocktime];
		$success = $stmt->execute($params);
		if ($success) {
			echo "<p>Added {$stockname} to stock database</p>";
		} else {
			echo "<p>Fail…</p>";
		}
	} else {
		echo "<p>Fail…</p>";
	}
} else {
	echo "<p>Not Logged in. Access denied.</p>";
}

?>