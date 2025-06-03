<?php
session_start();
include_once "db.php"; // defines $host, $username, $password, $db

$conn = mysqli_connect($host, $username, $password, $db);

if (!$conn) {
    $_SESSION['msg'] = ['type' => 'error', 'text' => 'Database connection failed'];
    redirect_user();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = $_POST['name'] ?? '';
    $email   = $_POST['email'] ?? '';
    $phone   = $_POST['phone'] ?? '';
    $date    = $_POST['date'] ?? '';
    $time    = $_POST['time'] ?? '';
    $people  = $_POST['people'] ?? '';
    $message = $_POST['message'] ?? '';

    $sql = "INSERT INTO bookings (name, email, phone, booking_date, booking_time, people, message)
            VALUES ('$name', '$email', '$phone', '$date', '$time', '$people', '$message')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['msg'] = ['type' => 'success', 'text' => 'Your table has been booked!'];
    } else {
        $_SESSION['msg'] = ['type' => 'error', 'text' => 'Error: ' . mysqli_error($conn)];
    }
} else {
    $_SESSION['msg'] = ['type' => 'error', 'text' => 'Invalid request'];
}

mysqli_close($conn);
redirect_user();

// Function to redirect user
function redirect_user()
{
    if (isset($_SESSION['email'])) {
        header("Location: ../client/index.php");
    } else {
        header("Location: ../index.php");
    }
    exit;
}
