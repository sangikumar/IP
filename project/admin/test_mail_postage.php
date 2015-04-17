<?php
/**
 * Created by PhpStorm.
 * User: Shilpi
 * Date: 1/15/2015
 * Time: 11:30 AM
 */

require_once('../postageapp_class.inc');

$to = 'shilpi@innova-path.com';

$recipient = array('shilpisondhi@gmail.com','shilpi@innova-path.com');

// The subject of the message
$subject = 'Shilpi Testing1';

// Setup some headers
$header = array(
    'From'      => 'shilpi@ip.com',
    'Reply-to'  => 'do-not-reply@example.org'
);

// The body of the message
$mail_body = array(
    'text/plain' => 'Sherlyll Testing1',
    'text/html' => 'Testing BCC'
);

// Send it all
$ret = PostageApp::mail($to, $recipient, $subject, $mail_body, $header);

// Checkout the response
if ($ret->response->status == 'ok') {
    echo '<br/><b>SUCCESS:</b>, An email was sent and the following response was received:';
} else {
    echo '<br/><b>Error sending your email:</b> '.$ret->response->message;
}


?>