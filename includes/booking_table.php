<?php
session_start();
include_once "db.php"; // defines $host, $username, $password, $db

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $date    = trim($_POST['date'] ?? '');
    $time    = trim($_POST['time'] ?? '');
    $people  = trim($_POST['people'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Basic required fields validation
    if (empty($name) || empty($email)) {
        $_SESSION['msg'] = ['type' => 'error', 'text' => 'Name and Email are required'];
        redirect_user();
    }

    // Use prepared statements for security
    $stmt = $conn->prepare("INSERT INTO bookings (name, email, phone, booking_date, booking_time, people, message)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssis", $name, $email, $phone, $date, $time, $people, $message);

    if ($stmt->execute()) {
        $_SESSION['msg'] = ['type' => 'success', 'text' => 'Your table has been booked!'];
    } else {
        $_SESSION['msg'] = ['type' => 'error', 'text' => 'Booking failed: ' . $stmt->error];
    }

    $stmt->close();
} else {
    $_SESSION['msg'] = ['type' => 'error', 'text' => 'Invalid request method'];
}

$conn->close();
redirect_user();

// Function to redirect user
function redirect_user()
{
    if (isset($_SESSION['email'])) {
        header("Location: /college/users/index");
    } else {
        header("Location: /college/index");
    }
    exit;
}
