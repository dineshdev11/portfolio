<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Honeypot check
    if (!empty($_POST["honeypot"])) {
        die("Spam detected.");
    }

    // Get form data safely
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST["message"]));

    // Main recipient
    $to = "dinesh.developer.us@gmail.com";

    // CC recipient
    $cc = "contact.in.dinesh@gmail.com";

    // Email subject & content
    $subject = "New Contact Form Message from $name";
    $body = "You received a message from:\n\n"
          . "Name: $name\n"
          . "Email: $email\n\n"
          . "Message:\n$message\n";

    // Headers
    $headers  = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Cc: $cc\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send to you + CC
    $mailSent = mail($to, $subject, $body, $headers);

    // Confirmation mail to user
    $userSubject = "Thanks for contacting Dinesh";
    $userBody = "Hi $name,\n\nThank you for reaching out! I’ve received your message and will get back to you soon.\n\nRegards,\nDinesh";
    $userHeaders = "From: Dinesh <dinesh.developer.us@gmail.com>\r\n";
    $userHeaders .= "Content-Type: text/plain; charset=UTF-8\r\n";

    mail($email, $userSubject, $userBody, $userHeaders);

    if ($mailSent) {
        echo "Message sent successfully!";
    } else {
        echo "Failed to send message. Please try again.";
    }
} else {
    http_response_code(403);
    echo "Forbidden";
}
?>
