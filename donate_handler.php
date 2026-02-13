<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Collect & sanitize form data
$name     = isset($_POST['donor_name'])  ? trim(htmlspecialchars($_POST['donor_name']))  : '';
$email    = isset($_POST['donor_email']) ? trim(htmlspecialchars($_POST['donor_email'])) : '';
$phone    = isset($_POST['donor_phone']) ? trim(htmlspecialchars($_POST['donor_phone'])) : '';
$location = isset($_POST['donor_location']) ? trim(htmlspecialchars($_POST['donor_location'])) : '';
$amount   = isset($_POST['donor_amount']) ? trim(htmlspecialchars($_POST['donor_amount'])) : '';
$consent  = isset($_POST['donor_consent']) ? true : false;

// Validation
if (empty($name) || empty($email) || empty($phone) || empty($location) || empty($amount)) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

if (!$consent) {
    echo json_encode(['success' => false, 'message' => 'You must agree to allow TTCRHF to contact you.']);
    exit;
}

// Compose email
$to      = 'ttcrhf@mail.com';
$subject = 'New Donation Inquiry from ' . $name;

$body  = "=== NEW DONATION INQUIRY ===\n\n";
$body .= "Full Name:       $name\n";
$body .= "Email:           $email\n";
$body .= "Phone:           $phone\n";
$body .= "Location:        $location\n";
$body .= "Amount to Donate: $amount\n";
$body .= "Contact Consent: Yes\n\n";
$body .= "---\n";
$body .= "This donor has agreed to be contacted by TTCRHF via call or email regarding how to complete their donation.\n";
$body .= "Submitted on: " . date('Y-m-d H:i:s') . "\n";

$headers  = "From: TTCRHF Website <noreply@ttcrhf.org>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Attempt to send the email
$mailSent = @mail($to, $subject, $body, $headers);

if ($mailSent) {
    echo json_encode(['success' => true, 'message' => 'Thank you! Your donation request has been submitted. We will contact you shortly with instructions on how to complete your donation.']);
} else {
    // Fallback: save to file if mail() fails (e.g. local XAMPP without mail config)
    $logFile = __DIR__ . '/donation_inquiries.log';
    $logEntry = "---\n" . date('Y-m-d H:i:s') . "\n" . $body . "\n";
    file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);

    echo json_encode(['success' => true, 'message' => 'Thank you! Your donation request has been recorded. Our team will reach out to you shortly.']);
}
