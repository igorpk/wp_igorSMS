<?php
/**
 * Process the SMS queue and send any unsent SMSes.
 */
include_once('IgorSmsQueue.php');

class IgorSms {
    
    private $_messages = array();
    
    /**
     * Get an IgorSmsQueue instance and all unsent messages.
     */
    public function __construct() {
        $this->_queue = new IgorSmsQueue();
        $this->_messages = $this->_queue->loadQueue();
    }
    
    /**
     * Process all unsent SMS messages from the DB and send, with a DB update.
     */
    public function processAndSend() {
        if(! empty($this->_messages)) {
            foreach($this->_messages as $message) {
                
                $destinations = unserialize($message->destinations);
                
                foreach($destinations as $destination) {
                    $this->sendSMS($destination, $message->message);
                }
                
                $this->_queue->_db->update($this->_queue->_tableName, array('sent' => current_time('mysql')), array('id' => $message->id));
            }
            
            return true;
        }
    }
    
    /**
     * Fire the API call to the SMS Provider API
     * 
     * @param string $msisdn
     * @param string $message
     */
    public function sendSMS($msisdn, $message) {
        /**
         * Implement cUrl calls to relevant SMS provider API
         */
        echo "Sent SMS to ".$msisdn.", message: ".$message."<br />";
    }
}
?>
