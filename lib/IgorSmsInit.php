<?php

/**
 * Initialise global requirements for IgorSMS.
 */
class IgorSmsInit {

    public $_db;
    public $_tableName;

    public function __construct() {
        global $wpdb;
        $this->_db = $wpdb;
        $this->_tableName = $wpdb->prefix . "igorSMS";

        $this->dbSetup();
        
        return $this;
    }

    public function dbSetup() {
        $sql = "CREATE TABLE IF NOT EXISTS `{$this->_tableName}` (
                `id` mediumint(9) NOT NULL AUTO_INCREMENT,
                `message` varchar(140) NOT NULL,
                `destinations` text NOT NULL,
                `sent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                PRIMARY KEY (`id`)
            ) {$this->_db->get_charset_collate()};";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql);
    }

}

?>
