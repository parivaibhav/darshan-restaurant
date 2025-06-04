<?php

include __DIR__ . '/../includes/db.php';



$email = $_SESSION['email'];

// Fetch user's orders with date
$sql = "SELECT menu_name, quantity, total_price, status, address, mobile, order_date 
        FROM orders 
        WHERE email = ? 
        ORDER BY order_date DESC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>My Orders</title>
    <link href="../assets/img/logo.png" rel="icon" />
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="../assets/css/main.css" rel="stylesheet" />
</head>

<body>

    <?php include 'header.php'; ?>

    <section class="container mt-5 mb-5">
        <div class="section-title text-center mb-4">
            <h2>Your Orders</h2>
            <p class="text-muted">Review your recent food orders</p>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-danger text-center">
                    <tr>
                        <th>Menu Name</th>
                        <th>Quantity</th>
                        <th>Total Price (₹)</th>
                        <th>Status</th>
                        <th>Address</th>
                        <th>Mobile</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['menu_name']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($row['quantity']) ?></td>
                                <td class="text-end">₹<?= number_format($row['total_price'], 2) ?></td>
                                <td class="text-center"><?= htmlspecialchars($row['status']) ?></td>
                                <td><?= htmlspecialchars($row['address']) ?></td>
                                <td><?= htmlspecialchars($row['mobile']) ?></td>
                                <td class="text-center"><?= date("d M Y", strtotime($row['order_date'])) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <?php include 'footer.php'; ?>
    <!-- Add this inside <body> -->
    <div id="custom-cursor"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
            <path fill="#000" d="M4.5.79v22.42l6.56-6.57h9.29L4.5.79z"></path>
        </svg></div>

    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/cursoranimation.js"></script>
</body>

</html>