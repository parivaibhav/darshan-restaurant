<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['msg'] = ['type' => 'error', 'text' => 'Invalid email.'];
        header("Location: /college/admin/users");
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO users (email, password, user_type) VALUES (?, ?, 'admin')");
    $stmt->bind_param("ss", $email, $password);
    
    if ($stmt->execute()) {
        $_SESSION['msg'] = ['type' => 'success', 'text' => 'Admin added successfully!'];
    } else {
        $_SESSION['msg'] = ['type' => 'error', 'text' => 'Failed to add admin.'];
    }

    $stmt->close();
    $conn->close();

         header("Location: /college/admin/users");
    exit;
}
?>
