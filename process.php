<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

header('Content-Type: application/json');

$response = array('success' => false);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    if (empty($name) || empty($email) || empty($message)) {
        $response['message'] = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Invalid email address.';
    } else {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 0; // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = 'smtp.example.com'; // Specify main and backup SMTP servers
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'your_email@example.com'; // SMTP username
            $mail->Password = 'your_password'; // SMTP password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587; // TCP port to connect to

            //Recipients
            $mail->setFrom($email, $name);
            $mail->addAddress('info@madeccltd.online'); // Add a recipient

            // Content
            $mail->isHTML(false); // Set email format to HTML
            $mail->Subject = 'New Contact Form Submission';
            $mail->Body    = "Name: $name\nEmail: $email\nMessage:\n$message";

            $mail->send();
            $response['success'] = true;
        } catch (Exception $e) {
            error_log('Mail error: ' . $mail->ErrorInfo);
            $response['message'] = 'Unable to send email. Please try again later.';
        }
    }
} else {
    $response['message'] = 'Invalid request method.';
}

// Log the response for debugging
error_log(json_encode($response));

echo json_encode($response);
?>
<?php
header('Content-Type: application/json');

$response = array('success' => false);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    if (empty($name) || empty($email) || empty($message)) {
        $response['message'] = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Invalid email address.';
    } else {
        $to = 'madeccco@gmail.com'; // Change this to your email address
        $subject = 'New Contact Form Submission';
        $email_message = "Name: $name\nEmail: $email\nMessage:\n$message";
        $headers = 'From: ' . $email . "\r\n" .
                   'Reply-To: ' . $email . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        if (mail($to, $subject, $email_message, $headers)) {
            $response['success'] = true;
        } else {
            error_log('Mail function failed');
            $response['message'] = 'Unable to send email. Please try again later.';
        }
    }
} else {
    $response['message'] = 'Invalid request method.';
}

// Log the response for debugging
error_log(json_encode($response));

echo json_encode($response);
?>
