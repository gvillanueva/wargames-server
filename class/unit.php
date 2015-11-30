<?php

class Unit
{
    /*!
     * \brief Moves an authenticated user's unit.
     * \param authToken The 64-character authorization token identifying a user.
     * \param unitGuid The 16-character guid specifying the unit.
     * \param x A double indicating the unit's new X-position.
     * \param y A double indicating the unit's new Y-position.
     * \param z A double indicating the unit's new Y-position.
     */
    function move($params)
    {
        global $db;

        // Set up convenience references
        $authToken = $params[0];
        $unitGuid = $params[1];
        $x = $params[2];
        $y = $params[3];
        $z = $params[4];

        // Set up the Unit query
        $unitSql = 'SELECT Guid, X, Y, Z, JsonData, AuthToken, AuthTokenExpires
                     FROM Unit
                     JOIN User WHERE Unit.UserGuid = User.Guid
                     AND AuthToken = ? AND AuthTokenExpires > NOW() AND Unit.Guid = ?';
        $unitStmt = $db->prepare($unitSql);
        $unitStmt->bind_param("ss", $authToken, $unitGuid);

        // Execute the unit query
        if ($unitStmt->execute())
            throw new Tivoka\Exception\ProcedureException('User table query error.');

        // Get the result of the query; ensure authorization and unit is valid
        $unitResult = $unitStmt->get_result();
        if ($unitResult->num_rows != 1) // Unit.Guid should return exactly one result
            throw new Tivoka\Exception\ProcedureException('Unit does not exist, or authorization invalid or expired.');

        // Get current unit position, additional game state info, pass to game logic
        //logic.move($unit, $newPos);
//        $unitResult->data_seek(0);
//        $unitRow = $unitResult->fetch_assoc();
        $moveSql = 'UPDATE Unit SET X = ?, Y = ?, Z = ? WHERE Unit.Guid = ?';
        $moveStmt = $db->prepare($moveSql);
        $moveStmt->bind_param("ddds", $x, $y, $z, $unitGuid);
//        $res->data_seek(0);
//        $row = $res->fetch_assoc();

        // Call unit's move
        move();
    }
}

?>