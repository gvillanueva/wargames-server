<?php

// Piece types
// 1 = King
// 2 = Queen
// 3 = Bishop
// 4 = Knight
// 5 = Rook
// 6 = Pawn

class Game
{
    public static function fromAssocRow($row)
    {
        $game = new self();
        $game->id = $row['Guid'];
        $game->name = $row['Name'];
        $game->public = is_null($row['Password']);
        $game->maxUsers = (int)$row['MaxUsers'];
        $game->numUsers = (int)$row['NumUsers'];
        return $game;
    }

    function getUnits($gameUuid)
    {
//        $stmt = $db->prepare('SELECT Guid, Name, MaxUsers, IsPublic, COUNT(UserId)');
//        $stmt->bind_param("i", intval($unitId));
//        $unitStmt->execute();
//        $result = $unitStmt->get_result();
//        if ($result->num_rows <= 0) {
//            throw InvalidParamsException('No ')
//            exit;
//        }
//        $res->data_seek(0);
//        $row = $res->fetch_assoc();
    }

    function getState($params)
    {
    }

    function newGame()
    {
        global $db;

        // Clear the board
        $db->query('DELETE FROM Pieces');

        // Add black's pieces
        $db->query('INSERT INTO Pieces VALUES(NULL, 0, 5, 0, 0)');
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
}

?>