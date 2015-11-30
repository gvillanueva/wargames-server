<?php

require('config.php');

$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    exit("Failed to connect to Wargames database: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

?>