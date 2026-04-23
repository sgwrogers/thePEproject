<?php

/*-------------------------------------------------
    PHPMailer Initialization
---------------------------------------------------*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

/*-------------------------------------------------
    Receiver's Email
---------------------------------------------------*/

$toemails = array();

$toemails[] = array(
    'email' => 'info@thepeproject.com', // Your Email Address
    'name' => 'The PE Project' // Your Name or Company Name
);

/*-------------------------------------------------
    Sender's Email
---------------------------------------------------*/

$fromemail = array(
    'email' => 'no-reply@thepeproject.com', // Company's Email Address
    'name' => 'The PE Project' // Company Name
);

/*-------------------------------------------------
    Form Messages
---------------------------------------------------*/

$message = array(
    'success' => 'We have <strong>successfully</strong> received your message and will get back to you as soon as possible.',
    'error' => 'Email <strong>could not</strong> be sent due to some unexpected error. Please try again later.',
    'error_bot' => 'Bot detected! Form could not be processed!',
    'error_unexpected' => 'An <strong>unexpected error</strong> occurred. Please try again later.',
);

/*-------------------------------------------------
    Form Processor
---------------------------------------------------*/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mail = new PHPMailer();
    $mail->SetFrom($fromemail['email'], $fromemail['name']);
    $mail->Subject = 'Form Submission from The PE Project Website';

    // Add recipient
    foreach ($toemails as $toemail) {
        $mail->AddAddress($toemail['email'], $toemail['name']);
    }

    // Collect form data
    $fields = array();
    foreach ($_POST as $key => $value) {
        $name = ucwords(str_replace('_', ' ', $key));
        $fields[$name] = nl2br(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
    }

    // Build email body
    $body = "<h3>Form Submission Details:</h3><ul>";
    foreach ($fields as $field => $value) {
        $body .= "<li><strong>$field:</strong> $value</li>";
    }
    $body .= "</ul>";

    $mail->isHTML(true);
    $mail->Body = $body;

    // Send the email
    if ($mail->Send()) {
        echo json_encode(array('alert' => 'success', 'message' => $message['success']));
    } else {
        echo json_encode(array('alert' => 'error', 'message' => $message['error'] . '<br><br><strong>Reason:</strong> ' . $mail->ErrorInfo));
    }
} else {
    echo json_encode(array('alert' => 'error', 'message' => $message['error_unexpected']));
}

?>