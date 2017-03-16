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
        // set the default php timezone to Johannesburg in Africa
        if (date_default_timezone_get()!=="Africa/Johannesburg") {
            date_default_timezone_set("Africa/Johannesburg");
        }
    }

    public static function stopServer(){
        ob_end_flush();
    }

    public static function serverSecurityValidation():bool{
        // checks to see if a Session variable is set before continuing to a further method
        $session = self::fetchSessionHandler();
        $result = $session->getSessionVariable("UserID");
        if($result != null)
            return true;
        else
            return false;
    }

    public static function hashPassword($password):string{
        return password_hash($password,PASSWORD_DEFAULT);
    }

    public static function login($username, $password):bool {
        $isSuccess = false;
            if(is_string($username) && is_string($password)){
                // create instacne of database
                $dbHandler = self::fetchDatabaseHandler();
                // create instance/get instance of session
                $sessionHandler = self::fetchSessionHandler();

                // run commands to DB to verify the user is registered
                $dbHandler->runCommand("SELECT `Password`,`UserID`,`Name`,`Username`,`UserType` FROM REGISTERED_USER WHERE `Username` = ?", $username);
                // gather results from the DB if the results are present
                $result = $dbHandler->getResults();
                    if(count($result)==1 && password_verify($password, $result[0]['Password'])){
                        // mark success
                        $isSuccess = true;
                        //set relevant session variables
                        $sessionHandler->setSessionVariable("UserID",$result[0]['UserID']);
                        $sessionHandler->setSessionVariable("Name", $result[0]['Name']);
                        $sessionHandler->setSessionVariable("Username", $result[0]['Username']);
                        $sessionHandler->setSessionVariable("UserType", $result[0]['UserType']);
                    }
            }
        return $isSuccess;
    }

    public static function logout():bool{
        $isSuccess = true;
        //Clear and end the current session
       self::fetchSessionHandler()->endSession() ;
        return $isSuccess ;
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
            $dbHandler = new DatabaseHandler("localhost","root","Sebenza","viewme");
            $session->setSessionVariable("dbHandler", $dbHandler);
        }
        return $dbHandler;
    }

    public static function createAndResetDatabase():bool {
        //$dbHandler = new DatabaseHandler("eu-cdbr-azure-west-d.cloudapp.net","bb5f5a5205e9c5","74c8233a","");
        $dbHandler = new DatabaseHandler("localhost","root","Sebenza","");
        $success = $dbHandler->executeSQLScriptFile("database/VU-ME.sql");
        self::fetchSessionHandler()->setSessionVariable("dbHandler", $dbHandler);
        return $success;
    }

    public static function registerUser(array $details):bool{
        $isSuccess = false ;
        $name = $details[0];
        $surname = $details[1];
        $username = $details[2];
        $email = $details[3];
        $gender = $details[4];
        $contactNumber = $details[5];
        $password = self::hashPassword($details[6]) ;
        return $isSuccess;
    }

    public static function fetchUserDetails(){
        $uName = self::fetchSessionHandler()->getSessionVariable("Username");
        $dbHandler = self::fetchDatabaseHandler();
        $dbHandler->runCommand("SELECT * FROM REGISTERED_USER WHERE `Username` = ?", $uName);
        $results = $dbHandler->getResults();
        if($results != null ){
            return $results ;
        }else{
            return false;
        }
    }

    public static function fetchUsers(){
        $dbHandler = self::fetchDatabaseHandler();
        $dbHandler->runCommand("SELECT * FROM REGISTERED_USER");
        $results = $dbHandler->getResults();
        if($results != null ){
            return $results ;
        }else{
            return false;
        }
    }

    public static function fetchFollowers(){
        $uID = self::fetchSessionHandler()->getSessionVariable("UserID");
        $dbHandler = self::fetchDatabaseHandler();
        $dbHandler->runCommand("SELECT * FROM `FOLLOWERS` WHERE `UserID` = ?",$uID);
        $results = $dbHandler->getResults();
        $FollowerValues = [];
        if($results != null ){
            for($i = 0; $i < count($results); $i++){
                $followerID = $results[$i]['FollowedByUserID'] ;
                $dbHandler->runCommand("SELECT * FROM `REGISTERED_USER` WHERE `UserID` = ?",$followerID);
                $FollowerValues[$i] = $dbHandler->getResults();
            }
            return $FollowerValues ;
        }else{
            return false;
        }
    }

    public static function fetchFollowing(){
        $uID = self::fetchSessionHandler()->getSessionVariable("UserID");
        $dbHandler = self::fetchDatabaseHandler();
        $dbHandler->runCommand("SELECT * FROM `FOLLOWING` WHERE `UserID` = ?",$uID);
        $results = $dbHandler->getResults();
        $FollowingValues = [];
        if($results != null ){
            for($i = 0; $i < count($results); $i++){
                $followingID = $results[$i]['FollowingUserID'] ;
                $dbHandler->runCommand("SELECT * FROM `REGISTERED_USER` WHERE `UserID` = ?",$followingID);
                $FollowingValues[$i] = $dbHandler->getResults();
            }
            return $FollowingValues ;
        }else{
            return $FollowingValues;
        }
    }

    // This function fetchs all posts that a User is following
    public static function fetchFollowingPosts(){

        $uID = self::fetchSessionHandler()->getSessionVariable("UserID");
        $dbHandler = self::fetchDatabaseHandler();
        $dbHandler->runCommand("SELECT * FROM `FOLLOWING` WHERE `UserID` = ?",$uID);
        $results = $dbHandler->getResults();
        $FollowingValues = null;
        $count = 0;
        if($results != null ){
            // loop through each Following user ID for a specific user
            for($i = 0; $i < count($results); $i++){
                $followingID = $results[$i]['FollowingUserID'] ;
                $dbHandler->runCommand("SELECT COUNT(*) FROM `POST` WHERE `UserID` = ?",$followingID );
                $res = $dbHandler->getResults();
                // loop through each followed user
                for($r= 0; $r <count($res);$r++){
                    $dbHandler->runCommand("SELECT * FROM `POST` WHERE `UserID` = ? ORDER BY `TimePosted` ASC",$followingID);
                    $FollowingValues = $dbHandler->getResults();
                    // loop through each post by the followed user
                   for($j = 0; $j < count($FollowingValues); $j++) {
                       $count++ ;
                       $returnValue[$count]['PostID'] = $FollowingValues[$j]['PostID'];
                       $returnValue[$count]['UserID'] = $FollowingValues[$j]['UserID'];
                       $returnValue[$count]['Text'] = $FollowingValues[$j]['Text'];
                       $returnValue[$count]['Source'] = $FollowingValues[$j]['Source'];
                       $returnValue[$count]['Visibility'] = $FollowingValues[$j]['Visibility'];
                       $returnValue[$count]['TimeViewable'] = $FollowingValues[$j]['TimeViewable'];
                       $returnValue[$count]['TimePosted'] = $FollowingValues[$j]['TimePosted'];

                   }
                }

            }
            return $returnValue;//$returnValue ;
        }else{
            return $returnValue = null ;
        }


    }


    //TODO perform validation on user if following or not when the user clicks on the user they want to follows profile instead of on the follow button click
    public static function followUser($UserToFollowUsername,$userID): bool{
        $isFollowed = false;
        $canFollow = false ;
        $dbHandler = self::fetchDatabaseHandler();
        $dbHandler->runCommand("SELECT `UserID` FROM `REGISTERED_USER` WHERE `Username` = ?" ,$UserToFollowUsername);
        $UserToFollowID = $dbHandler->getResults();

        if($UserToFollowID!= null){
            $dbHandler->runCommand("SELECT * FROM FOLLOWING WHERE `UserID` =?",$userID);
            $results = $dbHandler->getResults();
                //loop through to check if a user is already following the user
            for($i = 0; $i < count($results); $i++){
                if($results[$i]['FollowingUserID'] == $UserToFollowID ){
                    $isFollowed = true;
                }
            }
            // if no results were found with corresponding ID's in database the user can then proceed to follow
            if($isFollowed==false)
                $canFollow = true ;

        }

        if($canFollow){
            $dbHandler->runCommand("INSERT INTO `FOLLOWING`(`UserID`,`FollowingUserID`) VALUES (?,?)",$userID,$UserToFollowID) ;
            $res = $dbHandler->getResults();
            if($res!= null) {
                return true;
            }else{
                return false ;
            }

        }else{
            return false ;
        }

    }

    //TODO perform validation on user if following or not when the user clicks on the user they want to follows profile instead of on the un-follow button click
    public static function unfollowUser($UserToUnfollowUsername, $userID):bool{
        $isFollowed = false;
        $canUnFollow = false ;
        $dbHandler = self::fetchDatabaseHandler();
        $dbHandler->runCommand("SELECT `UserID` FROM `REGISTERED_USER` WHERE `Username` = ?" ,$UserToUnfollowUsername);
        $UserToUnFollowID = $dbHandler->getResults();

        if($UserToUnFollowID != null){
            $dbHandler->runCommand("SELECT * FROM FOLLOWING WHERE `UserID` =?",$userID);
            $results = $dbHandler->getResults();
            //loop through to check if a user is already following the user
            for($i = 0; $i < count($results); $i++){
                if($results[$i]['FollowingUserID'] == $UserToUnFollowID ){
                    $isFollowed = true;
                }
            }
            // if a result was found with corresponding ID's in database the user can then proceed to unfollow
            if($isFollowed==true)
                $canUnFollow = true ;

        }

        if($canUnFollow){
            $dbHandler->runCommand("DELETE FROM `FOLLOWING` WHERE `UserID` = ? AND `FollowingUserID` = ?",$userID,$UserToUnFollowID) ;
            $res = $dbHandler->getResults();
            if($res!= null) {
                return true;
            }else{
                return false ;
            }

        }else{
            return false ;
        }
    }

    public static function updateUserLocation($userID, $lat, $long){
        $isSuccess = false ;
        $dbHandler = self::fetchDatabaseHandler();
        $dbHandler->runCommand("INSERT INTO `LOCATION`(`UserID`,`Latitude`,`Longitude`) VALUES (?,?,?)",$userID,$lat,$long);
        $results = $dbHandler->getResults();
        if($results!= null){
            return $isSuccess = true ;
        }else{
            return $isSuccess ;
        }
    }

}

// Superglobal variable POST used to retrieve any data sent from the client side
if (!empty($_POST)) {
    Server::startServer();

    $response = "" ;
    if (isset($_POST['action'])) {
        // Get the action that was provided for server to interpret
        $action = $_POST['action'];

        // Based on the action provided the server will interact appropriately
        switch ($action) {
            case 'testServer':
                $response = json_encode(true);
                break;

            case 'validate-session':
                $response = json_encode(Server::serverSecurityValidation());
                break;

            case 'login':
                if (isset($_POST['username']) && isset($_POST['password'])) {
                    $response = json_encode(Server::login($_POST['username'], $_POST['password']));
                } else {
                    $response = json_encode(false . " Username and password not set " . print_r($_POST));
                }
                break;

            case 'logout':
                $response = json_encode(Server::logout());
                break;

            case 'register':

                break;

            case 'fetch-user-details':
                $response = json_encode(Server::fetchUserDetails());
                break;

            case 'fetch-users':
                $response = json_encode(Server::fetchUsers());
                break;

            case 'fetch-followers':
                $OK = Server::serverSecurityValidation();
                if ($OK) {
                   $response = json_encode(Server::fetchFollowers());
                }else{
                    $response = json_encode(false);
                }
                break;

            case 'fetch-following':
               $OK = Server::serverSecurityValidation();
                if ($OK) {
                    $response = json_encode(Server::fetchFollowing());
                }else{
                    $response = json_encode("User is required to log In again");
                }
                 break;

            case 'fetch-following-posts':
                $OK = Server::serverSecurityValidation();
                    if($OK){
                        $response = json_encode(Server::fetchFollowingPosts());

                    }else{
                        $response = json_encode(false);
                    }
                break;

            case 'updateLocation':
                if(isset($_POST['UserID']) && isset($_POST['Latitude']) && isset($_POST['Longitude'])) {
                    $response = Server::unfollowUser($_POST['UserID'],$_POST['Latitude'],$_POST['Longitude']);
                }else{
                    $response = "Post variables not set";
                }
                break;

            case 'FollowUser':
                if(isset($_POST['UserID']) && isset($_POST['UserToFollowUsername'])) {
                    $response = Server::followUser($_POST['UserToFollowUsername'],$_POST['UserID']);
                }else{
                    $response = "Post variables not set";
                }
                break;

            case 'UnFollowUser':
                if(isset($_POST['UserID']) && isset($_POST['UserToUnFollowUsername'])) {
                    $response = Server::unfollowUser($_POST['UserToUnFollowUsername'],$_POST['UserID']);
                }else{
                    $response = "Post variables not set";
                }
                break;

            case 'BlockUser':
                break;

            case 'searchRegion':
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