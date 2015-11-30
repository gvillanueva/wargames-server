<?php

require('include.php');
require('database.php');
require('class/user.php');

$user = new User();
Tivoka\Server::provide($user)->dispatch();

?>