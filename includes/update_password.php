<?php
session_start();
include __DIR__ . '/db.php';

// Check if required fields are submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
    $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';

    // Basic validation
    if ($user_id <= 0 || empty($new_password)) {
        $_SESSION['msg'] = [
            'type' => 'error',
            'text' => 'Invalid user ID or password.'
        ];
        header('Location: /college/admin/users');
        exit;
    }

    // Optional: You can add server-side strength validation here as well
    if (strlen($new_password) < 3 || !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $new_password) || !preg_match('/\d/', $new_password)) {
        $_SESSION['msg'] = [
            'type' => 'error',
            'text' => 'Password must be at least 3 characters, include one symbol, and one number.'
        ];
        header('Location: /college/admin/users');
        exit;
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the database
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashed_password, $user_id);

    if ($stmt->execute()) {
        $_SESSION['msg'] = [
            'type' => 'success',
            'text' => 'Password updated successfully.'
        ];
    } else {
        $_SESSION['msg'] = [
            'type' => 'error',
            'text' => 'Failed to update password. Please try again.'
        ];
    }

    $stmt->close();
    $conn->close();
    header('Location: /college/admin/users');
    exit;
} else {
    // If not POST request
    $_SESSION['msg'] = [
        'type' => 'error',
        'text' => 'Invalid request method.'
    ];
    header('Location: /college/admin/users');
    exit;
}
