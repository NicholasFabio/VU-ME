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
                $response = json_encode("Your server is running =)!");
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