<?php

function create()
{
    // Add black's pieces
    $db->query('INSERT INTO Unit VALUES(NULL, 0, 5, 0, 0)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 0, 4, 1, 0)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 0, 3, 2, 0)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 0, 1, 3, 0)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 0, 2, 4, 0)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 0, 3, 5, 0)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 0, 4, 6, 0)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 0, 5, 7, 0)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 0, 6, 0, 1)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 0, 6, 1, 1)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 0, 6, 2, 1)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 0, 6, 3, 1)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 0, 6, 4, 1)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 0, 6, 5, 1)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 0, 6, 6, 1)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 0, 6, 7, 1)');

    // Add whites's pieces
    $db->query('INSERT INTO Pieces VALUES(NULL, 1, 6, 0, 6)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 1, 6, 1, 6)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 1, 6, 2, 6)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 1, 6, 3, 6)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 1, 6, 4, 6)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 1, 6, 5, 6)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 1, 6, 6, 6)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 1, 6, 7, 6)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 1, 5, 0, 7)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 1, 4, 1, 7)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 1, 3, 2, 7)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 1, 1, 3, 7)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 1, 2, 4, 7)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 1, 3, 5, 7)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 1, 4, 6, 7)');
    $db->query('INSERT INTO Pieces VALUES(NULL, 1, 5, 7, 7)');
}

?>