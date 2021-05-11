<?php
/*
Andy Le
000805099
PHP file that connects to the database
I, Andy Le, 000805099 certify that this material is my original work. No other person's work has been used without due acknowledgement.
*/
try {
    $dbh = new PDO(
        "mysql:host=csunix.mohawkcollege.ca;dbname=000805099",
        "000805099",
        "19991222"
    );
} catch (Exception $e) {
    die("ERROR: Couldn't connect. {$e->getMessage()}");
}

?>
