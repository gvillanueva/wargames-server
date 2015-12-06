<?php

require('class/unit.php');
require('class/user.php');

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

    /*  \brief Gets the state of a game.
     *  \param The GUID identifying the game.
     *  \param The GUID identifying a user, presumably a player in the game.
     */
    function getState($params)
    {
        global $db;

        if (count(params) != 1)
            throw new \Tivoka\Exception\InvalidParamsException("Parameter count mismatch.");

        // Set up our game state query
        $stateSql = 'SELECT Guid, X, Y, Z, Rotation, JsonData FROM Unit WHERE GameGuid = UNHEX(?)';
        $stateStmt = $db->prepare($stateSql);
        $stateStmt->bind_param('s', $params[0]);

        // Execute game state query
        if (!$stateStmt->execute())
            throw new Tivoka\Exception\ProcedureException('Unit table query error.');

        // Get all the units
        $stateResult = $stateStmt->get_result();
        $stateResult->data_seek(0);
        $units = [];
        while ($row = $stateResult->fetch_assoc())
            $units[] = Unit::fromAssocRow($row);

        return $units;
    }

    /*  \brief  Creates a new game using the specified system.
     *  \param  The authentication token of a logged in user.
     *  \param  The GUID of the system to create a game for.
     *  \param  The name of the room (must be unique).
     *  \param  The maximum number of users.
     *  \param  A password for the game room.
     */
    function createGame($params)
    {
        global $db;

        // Ensure use is logged in
        User::validateToken($params[0]);

        // TODO: Maximum number of games for a user to create?
        $createGameSql = 'INSERT INTO Game VALUES(ordered_uuid(uuid()), ?, ?, ?, ?)';
        $createGameStmt = $db->prepare($createGameSql);
        $createGameStmt->bind_param('sssi', $params[1], $params[2], password_hash($params[3], PASSWORD_DEFAULT), $params[4]);

        if (!$createGameStmt->execute())
            throw new \Tivoka\Exception\ProcedureException('Game table query error.');

        return $game_uuid;
    }

    function setupGame($params)
    {
        // Figure out which creation script to call from system
        $system->create();
    }

    function teardownGame($params)
    {

    }
}

?>