<?php
session_start();
include('db.php');  // Your DB connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password_plain = $_POST['password'];
    $user_type = "user";

    // Basic validation (optional, add more as needed)
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Invalid email format.'];
        header('Location: ../register.php');
        exit();
    }

    if (strlen($password_plain) < 6) {
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Password must be at least 6 characters.'];
        header('Location: ../register.php');
        exit();
    }

    // Check if email already exists
    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Email already registered.'];
        header('Location: ../register.php');
        exit();
    }

    // Hash the password
    $password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (email, password, user_type) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $password_hashed, $user_type);

    if ($stmt->execute()) {
        $_SESSION['msg'] = ['type' => 'success', 'text' => 'Registration successful!'];
        $_SESSION['email'] = $email; // Set session email for logged-in user
        header('Location: ../client/index.php'); // Redirect to client homepage or dashboard
        exit();
    } else {
        $_SESSION['msg'] = ['type' => 'error', 'text' => 'Registration failed, please try again.'];
        header('Location: ../register.php');
        exit();
    }

    $stmt->close();
    $check->close();
    $conn->close();
} else {
    // If not POST request, redirect to register page
    header('Location: ../register.php');
    exit();
}
