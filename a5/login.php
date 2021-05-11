<?php
/* 
Andy Le
000805099
PHP file login page
I, Andy Le, 000805099 certify that this material is my original work. No other person's work has been used without due acknowledgement.
*/
session_start();
include "connect.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>TODO supply a title</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/
jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    
</head>
<body>
	<?php
    $message = "Empty";
    $userid = filter_input(INPUT_POST, "userid", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $command = "SELECT UserName FROM users WHERE UserName=?";
    $stmt = $dbh->prepare($command);
    $success = $stmt->execute([$userid]);
    if ($success) {
        if ($row = $stmt->fetch()) {
            $command = "SELECT Password FROM users WHERE Password=?";
            $stmt = $dbh->prepare($command);
            $success = $stmt->execute([$password]);
            if ($success) {
                if ($row = $stmt->fetch()) {
                    $message = "Logged in successfully!";
                    $_SESSION["userid"] = $userid;
                    $_SESSION["password"] = $password;
                } else {
                    $message = "Incorrect password!";
                    session_unset();
                    session_destroy();
                }
            } else {
                $message = "Fail...";
            }
        } else {
            $command = "INSERT into users VALUES (?, ?)";
            $stmt = $dbh->prepare($command);
            $params = [$userid, $password];
            $success = $stmt->execute($params);
            if ($success) {
                $message = "You have registered and are now logged in!";
                $_SESSION["userid"] = $userid;
                $_SESSION["password"] = $password;
            } else {
                $message = "Fail...";
                session_unset();
                session_destroy();
            }
        }
    } else {
        $message = "Fail...";
    }
    echo "<p>{$message}</p>";

    if (isset($_SESSION["userid"])) {
        echo "<table>";
        echo "<tr><th>Stock Name</th><th>Stock Price</th><th>Date</th></tr>";
        echo "</table>";
    }
    ?>
    <div id="inputs">
        <form id="myForm" method="post" action="add.php">
            <input class="myInput" type="text" name="stockname1" id="stockname1" placeholder="Stock Name">
            <input class="myInput" type="text" name="stockprice1" id="stockprice1" placeholder="0.00">
            <input class="myInput" type="date" name="stocktime1" id="stocktime1">
            <input class="myInput" type="text" name="stockname2" id="stockname2" placeholder="Stock Name">
            <input class="myInput" type="text" name="stockprice2" id="stockprice2" placeholder="0.00">
            <input class="myInput" type="date" name="stocktime2" id="stocktime2">
            <input class="myInput" type="text" name="stockname3" id="stockname3" placeholder="Stock Name">
            <input class="myInput" type="text" name="stockprice3" id="stockprice3" placeholder="0.00">
            <input class="myInput" type="date" name="stocktime3" id="stocktime3">
            <button class="myInput" type="button" id="submit">Submit</button>
        </form>
    </div>
    <p id="message"></p>
    <a href="logout.php">Logout</a>
    <script type="text/javascript" src="js/script.js"></script>
</body>
</html>