<?php

/**
 * Created by PhpStorm.
 * User: Nicholas
 * Date: 2017-01-28
 * Time: 01:28 PM
 */

include_once $_SERVER['DOCUMENT_ROOT']."/php/classes/Session.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php/classes/DatabaseHandler.php";

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
                $dbHandler = self::fetchDatabaseHandler();

                // run commands to DB to verify the user is registered
                $dbHandler->runCommand("SELECT `Password`,`UserID`,`Username`,`UserType`, FROM REGISTERED_USER WHERE `Username` = ?", $username);
                // gather results from the DB if the results are present
                $result = $dbHandler->getResults();
                    if(count($result)==1 && password_verify($password, $result[0]['Password'])){
                        $isSuccess == true;


                    }

                // set $isSuccessful to true else it remains false
            }
        return $isSuccess;
    }

    public static function fetchSessionHandler():Session {
        $session = new Session();
        if ($session->exists('sessionHandler')) {
            $session = $session->getSessionVariable('sessionHandler');
        } else {
            $session->setSessionVariable('sessionHandler', $session);
        }
        return $session;
    }

    public static function fetchDatabaseHandler():DatabaseHandler {
        $session = self::fetchSessionHandler();
        if ($session->exists("dbHandler")) {
            $dbHandler = $session->getSessionVariable("dbHandler");
        } else {
            //$dbHandler = new DatabaseHandler("eu-cdbr-azure-west-d.cloudapp.net","bb5f5a5205e9c5","74c8233a","sebenzasa_database");
            $dbHandler = new DatabaseHandler("localhost","root","Sebenza","SebenzaSA_Database");
            $session->setSessionVariable("dbHandler", $dbHandler);
        }
        return $dbHandler;
    }

    public static function createAndResetDatabase():bool {
        //$dbHandler = new DatabaseHandler("eu-cdbr-azure-west-d.cloudapp.net","bb5f5a5205e9c5","74c8233a","");
        $dbHandler = new DatabaseHandler("localhost","root","Sebenza","");
        $success = $dbHandler->executeSQLScriptFile("database/SebenzaSA_Database.sql");
        self::fetchSessionHandler()->setSessionVariable("dbHandler", $dbHandler);
        return $success;
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