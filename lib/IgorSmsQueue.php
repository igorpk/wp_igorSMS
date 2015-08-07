<?php
/**
 * Manage database-based sms queue.
 */
include_once('IgorSmsInit.php');

class IgorSmsQueue extends IgorSmsInit {
    
    private $_destinations = array();
    private $_message;
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Set the message to be sent.
     * 
     * @param string $message
     */
    public function setMessage($message) {
        $this->_message = $this->validateMessage($message);
    }

    /**
     * Add a telephone number to be sent to.
     * 
     * @param string $destination [mobile number]
     */
    public function addDestination($destination) {
        $this->_destinations []= $destination;
    }
    
    /**
     * Inserts the message into the database.
     * 
     * @throws Exception
     */
    public function add() {
        if(! empty($this->_destinations) && ! empty($this->_message)){
            $this->_db->insert($this->_tableName, array(
                                                    "message" => $this->_message,
                                                    "destinations" => serialize($this->_destinations)
            ));
        } else {
            throw new Exception("Message empty or no destination to send to.");
        }
    }

    /**
     * Returns all unsent messages
     * 
     * @return array(id, message, destinations)
     */
    public function loadQueue() {
        return($this->_db->get_results("SELECT `id`, `message`, `destinations` FROM {$this->_tableName} WHERE `sent` = '0000-00-00 00:00:00';"));
    }

    /**
     * Returns the last sms sent
     * 
     * @return array(message)
     */
    public function loadLast() {
        return($this->_db->get_row("SELECT `message`, `sent` FROM {$this->_tableName} WHERE `sent` <> '0000-00-00 00:00:00' ORDER BY `sent` DESC LIMIT 1"));
    }
    
    /**
     * Validate the SMS text - currently limited to a length check.
     * If message is validated, return a strip_tags() filtered message,
     * as we don't want markup in the database.
     * 
     * @param string $message
     * @return string
     * @throws Exception
     */
    private function validateMessage($message) {       
        if(strlen($message) > 140) {
            throw new Exception("Message string too long");
        } else {
            return strip_tags($message);
        }
    }
}
?>
