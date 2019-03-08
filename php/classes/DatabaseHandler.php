<?php
/**
 * Created by PhpStorm.
 * User: Nicholas
 * Date: 2017/02/22
 * Time: 07:51 PM
 * References: php.net/manual & stackexchange
 */


/**
 * Class ServerSessionDatabaseHandler
 *
 * This class handles the connection to a database and running any command on that connection.
 * The database language is MySQL.
 */
//TODO: research into multiple entry additions so that if any entry fails all the previously run commands related to that command will revert - multi commands
class DatabaseHandler {

    private $dbHost = null;             //String URL of database server
    private $dbUser = null;             //String Database user
    private $dbUserPassword = null;     //String User's password
    private $dbName = null;             //String or null Database name
    private $lastCommand = null;        //String of last command
    private $results = null;            //Array containing results of last command (select)
    private $errors = null;             //Array of errors relating to last command
    private $insertID = null;           //Integer id of last command (insert, update)
    private $rowsAffected = null;       //Integer number of rows affected by last command
    private $commandsReport = null;     //Array of preceding five variable relating to multiple commands

    /**
     * ServerSessionDatabaseHandler constructor.
     *
     * This constructor sets the settings needed to connect to the database.
     *
     * Example: $dbHandler = new ServerSessionDatabaseHandler("localhost","root","Sebenza","SebenzaSA_Database");
     *
     * @param string $dbHost The address where the database server can be found.
     * @param string $dbUser The name of the user with access rights to the database.
     * @param string $dbUserPassword The password of the aforementioned user.
     * @param string $dbName The name of the database on the server.
     */
    function __construct($dbHost, $dbUser, $dbUserPassword, $dbName = null) {
        $this->setConnectionSettings($dbHost, $dbUser, $dbUserPassword, $dbName);
    }

    /**
     * @return string The address that hosts the database.
     */
    public function getDbHost(): string {
        return $this->dbHost;
    }

    /**
     * Set the address of the database host.
     * @param string $dbHost The address that hosts the database.
     */
    private function setDbHost($dbHost) {
        if (is_string($dbHost)) {
            $this->dbHost = $dbHost;
        }
    }

    /**
     * @return string The user associated with the current connection.
     */
    public function getDbUser(): string {
        return $this->dbUser;
    }

    /**
     * Sets the user for the current connection to the database.
     * @param string $dbUser The user for the current connection.
     */
    private function setDbUser($dbUser) {
        if (is_string($dbUser)) {
            $this->dbUser = $dbUser;
        }
    }

    /**
     * @return string The plain text password of the current connection's user.
     */
    public function getDbUserPassword(): string {
        return $this->dbUserPassword;
    }

    /**
     * Sets the user's password for the current connection.
     * @param string $dbUserPassword The password of the user for the current connection.
     */
    private function setDbUserPassword($dbUserPassword) {
        if (is_string($dbUserPassword)) {
            $this->dbUserPassword = $dbUserPassword;
        }
    }

    /**
     * @return string The name of the database associated with the current connection.
     */
    public function getDbName(): string {
        return $this->dbName;
    }

    /**
     * Sets the name of the database against which commands will be executed.
     * @param string $dbName The name of the database associated with the connection. Null if none.
     */
    private function setDbName($dbName) {
        if (is_string($dbName) || is_null($dbName)) {
            $this->dbName = $dbName;
        }
    }

    /**
     * Resets the name of the database to null.
     */
    public function resetDbName() {
        $this->setDbName(null);
    }

    /**
     * @return string The command that was passed to runCommand().
     */
    public function getLastCommand(): string {
        return $this->lastCommand;
    }

    /**
     * Used to set the last command sent to runCommand().
     * @param string $lastExecutedCommand The command that was passed to runCommand().
     */
    private function setLastCommand($lastExecutedCommand) {
        if (is_string($lastExecutedCommand)) {
            $this->lastCommand = $lastExecutedCommand;
        }
    }

    /**
     * Sets the last command to the empty string.
     */
    private function resetLastCommand() {
        $this->setLastCommand("");
    }

    /**
     * Fetches the array of results relating to the last command executed by this database connection.
     * @return array The array of results relating to the last command that was run by this instance.
     */
    public function getResults(): array {
        return $this->results;
    }

    /**
     * Returns a JSON string representation of the results relating to the last command.
     *
     * @return string The json string of the results from the last command.
     */
    public function getResultsInJSON(): string {
        return json_encode($this->getResults());
    }

    /**
     * Adds a result to the results array.
     * @param array $result The result to add to the results array.
     */
    private function addResult($result) {
        //Adds a result to the results array
        $this->results[] = $result;
    }

    /**
     * Resets the results array.
     */
    private function resetResults() {
        $this->results = array();
    }

    /**
     * @return array The array of errors associated with the last command sent to runCommand().
     */
    public function getErrors(): array {
        return $this->errors;
    }

    /**
     * Adds an error message to the errors array.
     * Example: $dbHandler->addError("Could not connect to database");
     * @param string $errorMessage The error message to be added to the errors array.
     */
    private function addError($errorMessage) {
        //Check the error message is of type string
        if (is_string($errorMessage)) {
            $this->errors[] = $errorMessage;
        }
    }

    /**
     * Resets the error array.
     */
    private function resetErrors() {
        $this->errors = array();
    }

    /**
     * @return int The ID of an insert on an auto_increment entity if it was the last command sent to runCommand(), 0 if
     * not applicable. It the single command contains multiple inserts, the id that is returned is of the first instance
     * inserted -> add (getRowsAffected()-1) to find the id of the last insert in this case.
     */
    function getInsertID(): int {
        return $this->insertID;
    }

    /**
     * Sets the value of insertID.
     * @param int $id The ID to set insertID to. Must be an integer.
     */
    private function setInsertID($id) {
        if (is_integer($id)) {
            $this->insertID = $id;
        }
    }

    /**
     * Resets insertID to 0.
     */
    private function resetInsertID() {
        $this->setInsertID(0);
    }

    /**
     * @return int The number of rows affected by an update, delete or insert command if it was the last command sent to
     * runCommand().
     */
    function getRowsAffected(): int {
        return $this->rowsAffected;
    }

    /**
     * Sets numRowsAffected.
     *
     * @param int $numRows The number of rows affected by the last runCommand().
     */
    private function setRowsAffected($numRows) {
        if (is_integer($numRows)) {
            $this->rowsAffected = $numRows;
        }
    }

    /**
     * Resets rowsAffected to 0.
     */
    private function resetRowsAffected() {
        $this->setRowsAffected(0);
    }

    /**
     * @return array An array containing a collection of the lastCommand, results, errors, insertID and rowsAffected for
     * every command that was passed to runCommands.
     */
    public function getCommandsReport(): array {
        return $this->commandsReport;
    }

    /**
     * @return string The JSON representation of getCommandsReport().
     */
    function getCommandsReportInJSON(): string {
        return json_encode($this->getCommandsReport());
    }

    /**
     * Adds the current lastCommand, results, errors, insertID and rowsAffected to commandsReport.
     */
    private function addCommandsReportEntry() {
        $this->commandsReport[] = array(
            "Command" => $this->getLastCommand(),
            "Results" => $this->getResults(),
            "Errors" => $this->getErrors(),
            "InsertID" => $this->getInsertID(),
            "RowsAffected" => $this->getRowsAffected()
        );
    }

    /**
     * Resets commandsReport to an empty array.
     */
    private function resetCommandsReport() {
        $this->commandsReport = array();
    }

    /**
     * Sets the relevant settings for creating a new connection. By default this is a helper function for the
     * constructor, but can be used to change the connection settings during a session.
     *
     * Example: $dbHandler->setConnectionSettings("localhost","root","Sebenza","SebenzaSA_Database");
     *
     * @param string $dbHost The address where the database server can be found.
     * @param string $dbUser The name of the user with access rights to the database.
     * @param string $dbUserPassword The password of the aforementioned user.
     * @param string $dbName The name of the database on the server.
     */
    public function setConnectionSettings($dbHost, $dbUser, $dbUserPassword, $dbName = null) {
        //Check that all the arguments are of the right type
        if (is_string($dbHost) && is_string($dbUser) && is_string($dbUserPassword) && (is_string($dbName) || is_null($dbName))) {
            //Set the instance properties
            $this->setDbHost($dbHost);
            $this->setDbUser($dbUser);
            $this->setDbUserPassword($dbUserPassword);
            $this->setDbName($dbName);
            //Reset the relevant fields
            $this->resetLastCommand();
            $this->resetResults();
            $this->resetErrors();
            $this->resetInsertID();
            $this->resetRowsAffected();
            $this->resetCommandsReport();
        } else {
            $this->addError("The arguments passed to setConnectionSettings must be of type string.");
        }
    }

    /**
     * Connects to the database and runs the specified single command. Only a single command can be run per call.
     * Commands should not be terminated with ';'. When a command needs variables inserted into the string, '?' should
     * be used as a placeholder for the relevant variable, and the variable(s) should be passed as additional parameters
     * to the function - this is to avoid SQL injections. If this function returns false, the reason(s) can be obtained
     * by using the getErrors() function, and finding the reason corresponding to the command in the array of errors.
     *
     * Example of use: $result = $dbHandlerVariable->runCommand("INSERT INTO `STUDENT` VALUES (?,?)",'123456789','Bob');
     *
     * @param string $command The command that should be executed by the database server.
     * @param array ...$parameters The extra parameters that need to be inserted into the command.
     * @return bool True if the command executed successfully, False otherwise.
     */
    public function runCommand($command, ...$parameters): bool {
        $this->setLastCommand($command);
        $this->resetResults();
        $this->resetInsertID();
        $this->resetRowsAffected();
        $this->resetErrors();

        //Assume failure, result = false
        $executionSuccess = false;
        if (is_string($command)) {
            //Connect to the MySQL database
            $connection = new mysqli($this->dbHost, $this->dbUser, $this->dbUserPassword, $this->dbName);
            //If the connection fails
            if ($connection->connect_error) {
                //Add the connect error to the errors array
                $this->addError($this->dbName.":".$command."->".$connection->connect_error);
            } else {
                //Clean the command's formatting up
                $command = trim(preg_replace("`[\s]+|[;]+`"," ",$command));
                $commandType = preg_split("`[\s]+`",$command);
                //Check if the command is supported by this module
                if (preg_match("`create|delete|drop|insert|replace|select|update`i", $commandType[0])) {
                    //Prepare the command for execution
                    if ($preparedCommand = $connection->prepare($command)) {
                        //Create a parameter string if parameters passed and they match number of parameters in command
                        $numParamsPassed = count($parameters);
                        $numExpectedParams = self::parameterCount($command);
                        if ($numExpectedParams || $numParamsPassed) {
                            if ($numExpectedParams != $numParamsPassed) {
                                $this->addError($this->dbName . ":" . $command . "->" . $numExpectedParams . " parameters expected, " . $numParamsPassed . " passed.");
                            } else {
                                $parameterString = self::generateParameterString(...$parameters);
                                if (!empty($parameterString)) {
                                    //Bind the parameter string to the prepared command, add error if appropriate
                                    if (!$preparedCommand->bind_param($parameterString, ...$parameters)) {
                                        $this->addError($this->dbName . ":" . $command . "->" . $preparedCommand->error);
                                    }
                                } else {
                                    $this->addError($this->dbName . ":" . $command . "->" . "Could not generate the appropriate parameter string.");
                                }
                            }
                        }

                        //Execute the prepared command, add error if failure to execute
                        if ($preparedCommand->execute()) {
                            $executionSuccess = true;
                            //Set results, rows affected, insert id and errors according to command type
                            switch (strtolower($commandType[0])) {
                                case "create":
                                    break;
                                case "delete":
                                    $this->setRowsAffected($preparedCommand->affected_rows);
                                    break;
                                case "drop":
                                    break;
                                case "insert":
                                    $this->setInsertID($preparedCommand->insert_id);
                                    $this->setRowsAffected($preparedCommand->affected_rows);
                                    break;
                                case "replace":
                                    $this->setRowsAffected($preparedCommand->affected_rows);
                                    break;
                                case "select":
                                    if ($response = $preparedCommand->get_result()) {
                                        //Add all the returned entity instances to results
                                        while ($returnedInstance = $response->fetch_array(MYSQLI_ASSOC)) {
                                            $this->addResult($returnedInstance);
                                        }
                                    } else {
                                        $this->addError($this->dbName.":".$command."->"."No results matched the select criteria.");
                                    }
                                    break;
                                case "update":
                                    //Add the number of rows updated
                                    $this->setInsertID($preparedCommand->insert_id);
                                    $this->setRowsAffected($preparedCommand->affected_rows);
                                    break;
                                default:
                                    $this->addError($this->dbName.":".$command."->"."Results for this type of command not catered for.");
                                    break;
                            }
                        } else {
                            $this->addError($this->dbName.":".$command."->".$preparedCommand->error);
                        }

                        //Close the connection and release the command object
                        $preparedCommand->close();

                    } else {
                        $this->addError($this->dbName.":".$command."->".$connection->error);
                    }
                } elseif (preg_match("`use`i", $commandType[0])) {
                    if ($connection->query($command)) {
                        $executionSuccess = true;
                        $this->setDbName(preg_replace("`[\W]`", "", $commandType[1]));
                    } else {
                        $this->addError("Could not run ".$command.".");
                    }
                } else {
                    $this->addError($this->dbName.":".$command."->"."This type of command is not supported.");
                }
            }
            $connection->close();
        } else {
            $this->addError($this->dbName . ":" . $command . "->" . "The command was not passed as a string.");
        }
        return $executionSuccess;
    }

    /**
     * Runs multiple commands separated by ; through the runCommand() method.
     *
     * @param string $commands A ; separated list of commands to be executed.
     * @param array ...$parameters The parameters that relate to the commands, in order of the ?s.
     * @return bool True if all the commands executed successfully, False otherwise.
     */
    function runCommands($commands, ...$parameters): bool {
        //Clear the previous commands report
        $this->resetCommandsReport();
        //Assume success of execution
        $executionSuccess = true;
        //Validate function argument types
        if (is_string($commands)) {
            //Convert all white space characters (especially new lines) to the single space
            $commands = preg_replace("`\s+`"," ", $commands);
            //Separate the commands by ;
            $commands = preg_split("`;`", $commands);
            //Used to split ...$parameters into slices relating to individual commands
            $parameterIndex = 0;
            $parameterCount = count($parameters);
            foreach ($commands as $command) {
                //Ignore empty commands
                if (!empty($command)) {
                    //If necessary, retrieve part of ...$parameters that is applicable to this command
                    if ($parameterIndex < $parameterCount) {
                        $commandParameterCount = $this->parameterCount($command);
                        $commandParameters = array_slice($parameters,$parameterIndex,$commandParameterCount);
                        $executionSuccess = $executionSuccess && $this->runCommand($command, $commandParameters);
                        $parameterIndex += $commandParameterCount;
                    } else {
                        $executionSuccess = $executionSuccess && $this->runCommand($command);
                    }
                    //Add the entry relating to this command to the commands report
                    $this->addCommandsReportEntry();
                }
            }
        }
        return $executionSuccess;
    }

    /**
     * Uses the runCommands() method to execute a sql script from a file.
     *
     * @param string $pathAndName The path and name of the sql file to be executed.
     * @return bool True if all the commands executed successfully, False otherwise.
     */
    public function executeSQLScriptFile($pathAndName): bool {
        //Validate function argument and that file exists
        $pathAndName = $_SERVER['DOCUMENT_ROOT']."/".$pathAndName;
        if (is_string($pathAndName) && file_exists($pathAndName)) {
            $executionSuccess = $this->runCommands(file_get_contents($pathAndName));
        } else {
            $executionSuccess = false;
            $this->addError("Specified script file '".$pathAndName."' not found.");
        }
        return $executionSuccess;
    }

    /**
     * Generates the string used in SQL commands to determine the type of '?' placeholders. Dates are strings in php.
     * If an element in the set of parameters is not supported or recognised, the function will return the empty string.
     *
     * @param array ...$parameterSet The set of parameters to convert into the parameter string.
     * @return string The parameter string for use with the bind_param() function.
     */
    private static function generateParameterString(...$parameterSet): string {
        //Start with the empty string, assume generating will not fail
        $parameterString = "";
        $failed = false;
        //Assure that $parameterSet is not null and not empty
        if (isset($parameterSet) && !empty($parameterSet)) {
            //Build the command string
            foreach ($parameterSet as $parameter) {
                //Depending on the type in the set, add 'd','i' or 's' respectively
                switch (gettype($parameter)) {
                    case "double":
                        $parameterString .= "d";
                        break;
                    case "integer":
                        $parameterString .= "i";
                        break;
                    case "string":
                        //Dates default to strings in this implementation and according to php's requirements
                        $parameterString .= "s";
                        break;
                    default:
                        //If a type is not one of these, generation failed
                        $failed = true;
                        break;
                }
            }
            if ($failed) {
                //Reset the string to empty, for use with the runCommand function
                $parameterString = "";
            }
        }
        return $parameterString;
    }

    /**
     * After stripping a command of sub-strings with might contain ?s, it then counts the number of ?s left to determine
     * how many parameters the command would require.
     *
     * @param string $command The command to check for the number of parameters required.
     * @return int The number of parameters that are required for a given command.
     */
    private static function parameterCount($command): int {
        //Assume no ?s in command
        $numParameters = 0;
        //Validate the function argument type
        if (is_string($command)) {
            //Remove sub-strings in the command
            $commandSansNestedStrings = preg_replace("`(\"[\s\S]*\")|('[\s\S]*')`","",$command);
            //Count the number of ?s and store in return variable
            $numParameters = substr_count($commandSansNestedStrings,"?");
        }
        return $numParameters;
    }
}
