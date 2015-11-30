<?php
require 'class/game.php';

class Matchmaker
{
    /*!
     * \brief Gets a list of games the user is currently playing.
     * \param authToken The token of an authenticated user.
     */
    function getUserGames($params)
    {
        global $db;

        // Set up the games query
        $userGamesSql = 'SELECT ToGuid(Game.Guid) AS Guid, Game.Name, Game.Password, Game.MaxUsers FROM User
                         JOIN Game_User ON User.AuthToken = ?
                         AND User.AuthTokenExpires > NOW()
                         AND Game_User.UserGuid = User.Guid
                         JOIN Game ON Game.Guid = Game_User.GameGuid';
        $userGamesStmt = $db->prepare($userGamesSql);
        $userGamesStmt->bind_param('s', $params[0]);

        // Execute our query
        if (!$userGamesStmt->execute())
            throw new Tivoka\Exception\ProcedureException('Database query error.');

        // Get the results of the query
        $userGamesResult = $userGamesStmt->get_result();
        $userGamesResult->data_seek(0);

        // Create JSON representations of the user's games
        $games = [];
        while ($userGamesRow = $userGamesResult->fetch_assoc())
            $games[] = Game::fromAssocRow($userGamesRow);

        return $games;
    }

    /*!
     *  \brief Gets a list of games from the matchmaker.
     */
    function getGames()
    {
        global $db;
        $getAllGamesSql =
            'SELECT ToGuid(Guid) AS Guid, Name, MaxUsers, Public, COUNT(Game_User.UserGuid) AS NumUsers
            FROM Game
            LEFT JOIN Game_User ON Game.Guid = Game_User.GameGuid
            GROUP BY Game.Guid';

        $result = $db->query($getAllGamesSql);
        $result->data_seek(0);
        $games = [];
        while ($row = $result->fetch_assoc())
            $games[] = Game::fromAssocRow($row);
        return $games;
    }
}

?>