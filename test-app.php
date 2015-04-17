<?php
 require_once('postageapp_class.inc');

 $to = 'sampath.velupula@gmail.com';

 // The subject of the message
 $subject = 'Postage App test email';

 // Setup some headers
 $header = array(
    'From'      => 'marketing@innova-path.com',
    'Reply-to'  => 'marketing@innova-path.com'
 );

 // The body of the message
 $mail_body = array(
    'text/plain' => 'Hello world in plain text',
    'text/html' => '<h1>Hello world</h1><p>in <b>HTML</b></p>'
 );

 // Send it all
 $ret = PostageApp::mail($to, $subject, $mail_body, $header);

 // Checkout the response
 if ($ret->response->status == 'ok') {
    echo '<br/><b>SUCCESS:</b>, An email was sent and the following response was received:';
 } else {
    echo '<br/><b>Error sending your email:</b> '.$ret->response->message;
 }

 echo '<pre style="text-align:left;">';
 print_r ($ret);
 echo '</pre>';
?>