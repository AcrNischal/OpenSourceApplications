<?php
// ===============================
// CONTACT FORM HANDLER
// ===============================

require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$name  = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$msg   = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $msg === '') {
    http_response_code(400);
    exit('All fields are required.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    exit('Invalid email address.');
}

$subject = SITE_NAME . ' – New Contact Message';

$body = <<<EOT
Name: $name
Email: $email

Message:
$msg
EOT;

$headers = [
    'From' => $email,
    'Reply-To' => $email,
    'Content-Type' => 'text/plain; charset=UTF-8'
];

mail(CONTACT_EMAIL, $subject, $body, $headers);

echo 'Message sent successfully.';
