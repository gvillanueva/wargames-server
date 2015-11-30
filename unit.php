<?php

require('include.php');
require('database.php');
require('class/unit.php');

$unit = new Unit();
Tivoka\Server::provide($unit)->dispatch();

?>