<?php
/**
 * @package IgorSMS
 * @version 0.1
 */
/*
Plugin Name: IgorSMS
Plugin URI: none
Description: Demonstration plugin
Author: Igor Kolodziejczyk
Version: 0.1
Author Email: ip.kolodziejczyk@gmail.com
*/
function onAdminLoginSMS() {
    require_once('lib/IgorSmsQueue.php');
    require_once('lib/IgorSms.php');

    $remote_ip = $_SERVER['REMOTE_ADDR'];
    
    $smsQueue = new IgorSmsQueue();
    $smsQueue->setMessage("Admin login detected from IP:". $remote_ip);
    $smsQueue->addDestination('0714917499');
    try {    
        $smsQueue->add();
    } catch (Exception $e) {
        echo($e->getMessage());
    }
    
    $sms = new IgorSms();
    $sms->processAndSend();
}

function smsSent(){
    require_once('lib/IgorSmsQueue.php');
    $queue = new IgorSmsQueue();
    
    $lastMessage = $queue->loadLast();
    echo "Last SMS Sent: ".$lastMessage->message." at ".$lastMessage->sent;
}

add_action('wp_login', 'onAdminLoginSMS');
add_action('admin_notices', 'smsSent');
?>