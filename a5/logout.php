<?php\
/*
Andy Le
000805099
PHP file logout page
I, Andy Le, 000805099 certify that this material is my original work. No other person's work has been used without due acknowledgement.
*/
session_start();
session_unset();
session_destroy();
?><!DOCTYPE html>
<html>
<head>
    <title>Login Example</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/logout.css">
</head>

<body>
    <h1>You are so logged out.</h1>
    <a href="index.html">Log in again</a>
</body>

</html>