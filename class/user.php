<?php

class User implements JsonSerializable
{
    public $guid = '';
    public $name = '';
    public $email = '';
    public $password = '';

    static function fromAssocRow($row)
    {
        $user = new self();
        $user->guid = $row['Guid'];
        $user->name = $row['Name'];
        $user->email = $row['Email'];
        return $user;
    }

    function jsonSerialize()
    {
        return [
            'guid' => $this->guid,
            'name' => $this->name,
            'email' => $this->email
        ];
    }

//    function create($params)
//    {
//        global $db;
//
//        if (is_string($params[0]) && is_string($params[1]) && is_string($params[2])) {
//            $newUser = new self();
//            $newUser->name = $params[0];
//            $newUser->password = $params[1];
//            $newUser->email = $params[2];
//        } else
//            throw new Tivoka\Exception\InvalidParamsException('Invalid new user parameters');
//
//        $createSql = 'INSERT INTO User VALUES(ordered_uuid(uuid()), NULL, NULL, ?, ?, ?)';
//        $createStmt = $db->prepare($createSql);
//        $createStmt->bind_param('sss',
//            $newUser->name, password_hash($newUser->password, PASSWORD_DEFAULT), $newUser->email);
//
//        if (!$createStmt->execute())
//            throw new Tivoka\Exception\ProcedureException('Failed to create new user. Try again later.');
//
//        return $newUser;
//    }
    function validateToken($authToken)
    {
        global $db;

        // Set up the authentication token validation query
        $validateSql = 'SELECT AuthToken FROM User WHERE AuthToken = ? AND AuthTokenExpires > NOW()';
        $validateStmt = $db->prepare($validateSql);
        $validateStmt->bind_param('s', $authToken);

        // Execute validation query
        if (!$validateStmt->execute())
            throw new \Tivoka\Exception\ProcedureException('User table query error.');

        $validateResult = $validateStmt->get_result();
        if ($validateResult->num_rows <= 0)
            throw new \Tivoka\Exception\ProcedureException('Authentication token is invalid or expired.');
    }

    function login($params)
    {
        global $db;

        // Set up our user query
        $loginSql = 'SELECT ToGuid(Guid) as Guid, Name, Password, Email FROM User WHERE Name = ?';
        $loginStmt = $db->prepare($loginSql);
        $loginStmt->bind_param('s', $params[0]);

        // Execute the user query
        if (!$loginStmt->execute())
            throw new Tivoka\Exception\ProcedureException('User table query error.');

        // Get the result of the query; ensure user exists
        $loginResult = $loginStmt->get_result();
        if ($loginResult->num_rows <= 0)
            throw new Tivoka\Exception\ProcedureException('User name or password incorrect.');

        // TODO: Handle scenario: 'User Auth-Token Exists'

        // Validate the username and password combo
        $loginResult->data_seek(0);
        $loginRow = $loginResult->fetch_assoc();
        if (!password_verify($params[1], $loginRow['Password']))
            throw new Tivoka\Exception\ProcedureException('User name or password incorrect.');

        // Create the user and auth-token, set it in the database
        $authToken = hash('sha256', rand());
        $tokenSql = 'UPDATE User SET AuthToken = ?, AuthTokenExpires = DATE_ADD(NOW(), INTERVAL 60 MINUTE) WHERE Name = ?';
        $tokenStmt = $db->prepare($tokenSql);
        $tokenStmt->bind_param('ss', $authToken, $loginRow['Name']);
        if (!$tokenStmt->execute())
            throw new Tivoka\Exception\ProcedureException('User table query error.');

        // Return auth-token to user
        return $authToken;
    }

    function logout($params)
    {
        global $db;

        // Set up our user query
        $logoutSql = 'SELECT AuthToken FROM User WHERE AuthToken = ? AND AuthTokenExpires > NOW()';
        $logoutStmt = $db->prepare($logoutSql);
        $logoutStmt->bind_param('s', $params[0]);

        // Execute the user query
        if (!$logoutStmt->execute())
            throw new Tivoka\Exception\ProcedureException('User table query error.');

        // Get the result of the query; ensure user exists
        $logoutResult = $logoutStmt->get_result();
        if ($logoutResult->num_rows <= 0)
            throw new Tivoka\Exception\ProcedureException('Authorization token is invalid.');

        // Invalidate the existing auth-token and expiry date
        $tokenSql = 'UPDATE User SET AuthToken = NULL, AuthTokenExpires = NULL WHERE AuthToken = ?';
        $tokenStmt = $db->prepare($tokenSql);
        $tokenStmt->bind_param('s', $params[0]);
        $tokenStmt->execute();
        if (!$tokenStmt->execute())
            throw new Tivoka\Exception\ProcedureException('User table query error.');

        return null;
    }

    // TODO: Change user email
    // TODO: Change user password
    function setPassword($params)
    {
        global $db;

        // Set up our user query
        $setPasswordSql = 'SELECT AuthToken FROM User WHERE AuthToken = ? AND AuthTokenExpires > NOW()';
        $setPasswordStmt = $db->prepare($setPasswordSql);
        $setPasswordStmt->bind_param('s', $params[0]);

        // Execute the user query
        if (!$setPasswordStmt->execute())
            throw new Tivoka\Exception\ProcedureException('User table query error.');

        // Get the result of the query; ensure user exists
        $setPasswordResult = $setPasswordStmt->get_result();
        if ($setPasswordResult->num_rows <= 0)
            throw new Tivoka\Exception\ProcedureException('Authorization token is invalid.');

        // Update the authenticated user's password
        $tokenSql = 'UPDATE User SET Password = ?, AuthTokenExpires = DATE_ADD(NOW(), INTERVAL 60 MINUTE) WHERE AuthToken = ?';
        $tokenStmt = $db->prepare($tokenSql);
        $tokenStmt->bind_param('ss', password_hash($params[1], PASSWORD_DEFAULT), $params[0]);
        if (!$tokenStmt->execute())
            throw new Tivoka\Exception\ProcedureException('User table query error.');

        return null;
    }

    // TODO: Reset password -- Use random string, email to user; or single-use URI?
    // TODO: Delete user?
    // TODO: List online users? Users with non-expired, non-null auth-token
    // TODO: Static authenticateUser method?
}

?>