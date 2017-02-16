<?php

/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 2017-01-28
 * Time: 01:28 PM
 */
/*
 *
 */
class Server
{
    public static function startServer() {
        ob_start() ;
    }

    public static function stopServer(){
        ob_end_flush();
    }

    public static function serverSecurityValidation():bool{
        // checks to see if a Session variable is set before continuing to a further method
        $result = "" ;

        if($result != null)
            return true;
        else
            return false;
    }

    public static function hashPassword($password):string{
        return password_hash($password,PASSWORD_DEFAULT);
    }

    public static function login($username, $password):bool{
        $isSuccess = false;
            if(is_string($username) && is_string($password)){
                // create instacne of database
                // create instance of session
                // run commands to DB to verify the user is registered
                // gather results from the DB if the results are present
                // set $isSuccessful to true else it remains false
            }
        return $isSuccess;
    }
}

// Superglobal variable POST used to retreive any data sent from the client side
if (!empty($_POST)) {
    Server::startServer();

    $response = "" ;
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        // Based on the action provided the server will interact appropriately
        switch ($action) {
            case 'testServer':
                $response = json_encode("true");
                break;

            case 'login':
                break;

            case 'register':
                break;

            default:
                //If the action was not one of the handled cases by the server
                $response = json_encode("Invalid Request.");
                break;
        }
    }
    // send all data gatherd and clear the buffer
    echo $response;
    Server::stopServer();
}