<?php

/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 2017-02-15
 * Time: 01:22 PM
 * Author: Nicholas Rader
 */
class Session
{

    private $idUseCount = 0;
    const REGEN_THRESHOLD = 15; // max number of ID  increments

    /**
     * Session constructor. If a session is still active when the constructor is called, the old id is preserved.
     * Only endSession() and a timeout can clear and destroy a session.
     * @param array ...$session_Key_Values The key value pairs that should be associated with the session.
     */
    function __construct(...$session_Key_Values){
        $this->startSession();
        if(isset($session_Key_Values)){
             $this->setSessionVars(...$session_Key_Values);
        }
    }

    /**
     * Starts a new session if one is not already active and presents a new session ID.
     */
    public function startSession(){
        if (!$this->isActive()) {
            session_start();
            //Give the session a new ID
            $this->regenSessionID();
        }
    }

    /**
     * Clears all the variables associated with the current session,
     * as well as destroys the session and removing all data.
     * @return bool
     */
    public function endSession():bool {
        $this->clearVariables();
        return session_destroy();
    }

    /**
     * Clears all the variables associated with the current session.
     */
    public function clearVariables() {
        session_unset();
    }
    /**
     * Checks to see if a session is currently in use.
     * @return bool
     */
    public function isActive():bool {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    /**
     * Sets the session variables
     * @param array ...$session_Key_Values The key value pairs that should be associated with the session
     * @return bool
     */
    public function setSessionVars(...$session_Key_Values):bool{
        $VariablesSet = false ;
        if(isset($session_Key_Values) && !empty($session_Key_Values)){
            foreach($session_Key_Values as $pair){
                if (is_array($pair) && count($pair) == 2) {
                    $VariablesSet = $VariablesSet && $this->setSessionVar($pair[0],$pair[1]);
                }
            }
        }
        return $VariablesSet;
    }

    /**
     * Assigns a single key to a value provided
     * @param $key Session key
     * @param $value Session Value assigned to the given key
     * @return bool
     */
    public function setSessionVar($key,$value):bool{
        $sessionSet = false;
        if($this->isActive()) {
            if (is_string($key) && isset($value)){
                $_SESSION[$key]= $value;
                // session has been set to true and update the ID
                $sessionSet= true ;
                $this->updateSessionID();
            }
        }
        return $sessionSet ;
    }

    /**
     * Fethces the current session ID
     * @return string The ID of the current session.
     */
    public function getSessionID():string {
        return session_id();
    }

    /**
     * Updates the current session ID
     */
    private function updateSessionID() {
        $this->idUseCount++;
        if ($this->idUseCount == self::REGEN_THRESHOLD) {
            $this->regenSessionID();
        }
    }

    /**
     * Regenerate the ID associated with this session.
     * @return bool
     */
    private function regenSessionID():bool{
        $this->idUseCount = 0;
        return session_regenerate_id();
    }


    public function setSessionVariables(...$keyValuePairs):bool {
        $setVariables = true;
        if (isset($keyValuePairs) && !empty($keyValuePairs)) {
            foreach ($keyValuePairs as $pair) {
                if (is_array($pair) && count($pair) == 2) {
                    $setVariables = $setVariables && $this->setSessionVariable($pair[0],$pair[1]);
                }
            }
        }
        return $setVariables;
    }

    public function setSessionVariable($key, $value):bool {
        $setVariable = false;
        if (is_string($key) && isset($value) && $this->isActive()) {
            $_SESSION[$key] = $value;
            $setVariable = true;
            $this->updateSessionID();
        }
        return $setVariable;
    }

    public function getSessionVariable($key) {
        $variable = null;
        if ($this->exists($key)) {
            $variable = $_SESSION[$key];
        }
        $this->updateSessionID();
        return $variable;
    }

    public function exists($key):bool {
        return is_string($key) && isset($_SESSION[$key]);
    }

    /**
     * @return int The number of variables stored in the current session.
     */
    public function variableCount():int {
        return count($_SESSION);
    }

    public function isEmpty():bool {
        return $this->variableCount() === 0;
    }

    /**
     * Regenerate the ID associated with this session.
     * @return bool
     */
    private function regenerateSessionID():bool {
        $this->idUseCount = 0;
        return session_regenerate_id();
    }



}