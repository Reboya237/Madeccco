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
    $to = 'madecccons@gmail.com'; // Change this to your email address
    $subject = 'New Contact Form Submission';
    $email_message = "Name: $name\nEmail: $email\nMessage:\n$message";
    $headers = 'From: ' . $email . "\r\n" .
               'Reply-To: ' . $email . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    if (mail($to, $subject, $email_message, $headers)) {
      $response['success'] = true;
    } else {
      $response['message'] = 'Message sent successfully';
    }
  }
} else {
  $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>
