<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $useremail = $_POST['useremail'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$useremail || !$password) {
        $_SESSION['msg'] = ['type' => 'error', 'text' => 'Email and Password are required'];
        header("Location: /college/login");
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if (!$stmt) {
        $_SESSION['msg'] = ['type' => 'error', 'text' => 'Database error: ' . $conn->error];
        header("Location: ../login");
        exit;
    }

    $stmt->bind_param("s", $useremail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['login_time'] = time();

            $_SESSION['msg'] = ['type' => 'success', 'text' => 'Login successful!'];

            if ($user['user_type'] === 'admin') {
                header("Location: /college/admin/index");
            } else {
                header("Location:/college/users/index");
            }
            exit;
        } else {
            $_SESSION['msg'] = ['type' => 'error', 'text' => 'Incorrect password'];
        }
    } else {
        $_SESSION['msg'] = ['type' => 'error', 'text' => 'User not found'];
    }

    $stmt->close();
    $conn->close();

    header("Location: /college/login");
    exit;
} else {
    header("Location:/college/login");
    exit;
}
