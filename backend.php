<?php
ob_start(); // Start output buffering

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include SwiftMailer autoload file
require 'swiftmailer/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Details of Complainant
    $data = '<table border="1" bordercolor="#ccc" align="center" width="650" style="width:650px;" cellpadding="10" cellspacing="0">';
    $data .= '<tr><td colspan="2" align="center" style="font-size:15px; font-weight:600;">Enquiry Details :-</td></tr>';
    $data .= '<tr><td>Name </td><td>' . htmlspecialchars($_POST['name']) . '</td></tr>';
    $data .= '<tr><td>Email </td><td>' . htmlspecialchars($_POST['email']) . '</td></tr>';
    $data .= '<tr><td>Phone No </td><td>' . htmlspecialchars($_POST['phone']) . '</td></tr>';
    $data .= '<tr><td>Service For Language </td><td>' . htmlspecialchars($_POST['language']) . '</td></tr>';
    $data .= '<tr><td>Message  </td><td>' . htmlspecialchars($_POST['message']) . '</td></tr>';
    $data .= '<tr><td>IP Address  </td><td>' . $_SERVER['REMOTE_ADDR'] . '</td></tr>';
    $data .= '</table>';

    
    // Create the Transport
    $transport = (new Swift_SmtpTransport('mail.tasktranslate.com', 587))
        ->setUsername('noreply@tasktranslate.com')
        ->setPassword('cwGY,Yv^5oQa');

    // Create the Mailer using the created Transport
    $mailer = new Swift_Mailer($transport);

    // Create a message
    $message = (new Swift_Message('Contact Form Query'))
        ->setFrom(['noreply@tasktranslate.com' => 'Contact Form Query'])
        ->setTo(['tasktranslate@gmail.com' => 'Contact Form Query'])
        ->setBody($data, 'text/html');

    // Send the message
    try {
        $result = $mailer->send($message);

        // Check if email sent successfully
        if ($result) {
            header('Location: success.php');
            exit; // Ensure script stops executing after redirection
        } else {
            header('Location: failed.php');
            exit; // Ensure script stops executing after redirection
        }
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ' . $e->getMessage();
        header('Location: failed.php');
        exit; // Ensure script stops executing after redirection
    }
} else {
    exit('Invalid Request!');
}

ob_end_flush(); // Flush output buffer and send it to the browser
?>