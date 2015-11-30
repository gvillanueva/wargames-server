<?php

require('include.php');
require('database.php');
require('class/game.php');

$game_server = new Game();
Tivoka\Server::provide($game_server)->dispatch();

?>