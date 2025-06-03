<?php
session_start();
include_once "db.php"; // Adjust path to your DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $menu_id = isset($_POST['menu_id']) ? intval($_POST['menu_id']) : 0;
    $menu_name = isset($_POST['menu_name']) ? trim($_POST['menu_name']) : '';
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0.0;
    $total_price = isset($_POST['total_price']) ? floatval($_POST['total_price']) : 0.0;
    $mobile = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $email = isset($_SESSION['email']) ? trim($_SESSION['email']) : '';

    // Basic validation
    if ($menu_id <= 0 || empty($menu_name) || $quantity <= 0 || $price <= 0 || $total_price <= 0 || !preg_match('/^[0-9]{10}$/', $mobile) || empty($address) || empty($email)) {
        $_SESSION['order_status'] = ['status' => 'error', 'message' => 'Invalid form data. Please fill in all fields correctly.'];
        header('Location: ../client/menu.php');
        exit;
    }

    // Insert into DB with email
    $stmt = $conn->prepare("INSERT INTO orders (email, menu_id, menu_name, quantity, price, total_price, mobile, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisisdss", $email, $menu_id, $menu_name, $quantity, $price, $total_price, $mobile, $address);

    if ($stmt->execute()) {
        $_SESSION['order_status'] = ['status' => 'success', 'message' => 'Your order has been placed successfully!'];
    } else {
        $_SESSION['order_status'] = ['status' => 'error', 'message' => 'Failed to place order. Please try again later.'];
    }

    $stmt->close();
    $conn->close();

    header('Location: ../client/menu.php');
    exit;
} else {
    // Invalid access
    header('Location: ../client/menu.php');
    exit;
}
