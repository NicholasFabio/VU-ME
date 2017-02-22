<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 2017-02-22
 * Time: 08:12 PM
 */
include_once $_SERVER['DOCUMENT_ROOT'] . "/php/classes/Server.php";
Server::startServer();
?>
<!DOCTYPE html>
<html>
<head>
    <title> Create/Reset Database </title>
</head>
<body>
<?php
echo "<pre>";
if (Server::createAndResetDatabase()) {
    echo 'Database created and reset.';
} else {
    echo 'Could not successfully create and reset the database.';
    var_dump(Server::fetchDatabaseHandler()->getCommandsReport());
}
echo "</pre>";
?>
</body>
</html>
<?php Server::stopServer();?>
