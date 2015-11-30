<?php

require('include.php');
require('database.php');
require('class/matchmaker.php');

$matchmaker = new Matchmaker();
Tivoka\Server::provide($matchmaker)->dispatch();

?>