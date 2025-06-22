<?php

include __DIR__ . '/../includes/db.php';

// Time filter logic
$filter = $_GET['filter'] ?? '';
$whereClause = '';

switch ($filter) {
    case 'today':
        $whereClause = "WHERE DATE(created_at) = CURDATE()";
        break;
    case 'last_week':
        $whereClause = "WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
        break;
    case 'last_month':
        $whereClause = "WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
        break;
    case 'last_year':
        $whereClause = "WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
        break;
}

$sql = "SELECT order_id, email, menu_name, quantity, mobile, address, status FROM orders $whereClause ORDER BY order_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Orders Management</title>

    <link href="../assets/img/logo.png" rel="icon" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />

    <!-- Vendor CSS -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet" />
    <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

    <!-- Main CSS -->
    <link href="../assets/css/main.css" rel="stylesheet" />
    <script src="../assets/js/modetoggle.js" defer></script>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container py-4">
        <h2 class="mb-4 text-center">Order Management</h2>

        <!-- Filter Dropdown -->
        <div class="row mb-3">
            <div class="col-md-4 offset-md-8">
                <form method="GET" class="d-flex align-items-center justify-content-end">
                    <label for="filter" class="me-2 fw-semibold flex-wrap">Filter by:</label>
                    <select name="filter" id="filter" class="form-select form-select-sm shadow-sm border-primary" onchange="this.form.submit()">
                        <option value="">All Orders</option>
                        <option value="today" <?= ($filter === 'today') ? 'selected' : '' ?>>Today</option>
                        <option value="last_week" <?= ($filter === 'last_week') ? 'selected' : '' ?>>Last Week</option>
                        <option value="last_month" <?= ($filter === 'last_month') ? 'selected' : '' ?>>Last Month</option>
                        <option value="last_year" <?= ($filter === 'last_year') ? 'selected' : '' ?>>Last Year</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Email</th>
                        <th>Menu Name</th>
                        <th>Quantity</th>
                        <th>Mobile</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['menu_name']) ?></td>
                                <td><?= (int)$row['quantity'] ?></td>
                                <td><?= htmlspecialchars($row['mobile']) ?></td>
                                <td><?= htmlspecialchars($row['address']) ?></td>
                                <td>
                                    <form action="../includes/order_status_update.php" method="POST" class="d-flex gap-2 justify-content-center align-items-center">
                                        <input type="hidden" name="order_id" value="<?= (int)$row['order_id'] ?>">
                                        <select name="status" class="form-select form-select-sm" style="width: 140px;">
                                            <?php
                                            $statuses = ['Confirmed', 'Shipping', 'Ongoing', 'Delivering'];
                                            foreach ($statuses as $statusOption) {
                                                $selected = ($row['status'] === $statusOption) ? 'selected' : '';
                                                echo "<option value=\"$statusOption\" $selected>$statusOption</option>";
                                            }
                                            ?>
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="../includes/delete_order.php" method="POST" onsubmit="return confirmDelete(event, this);">
                                        <input type="hidden" name="order_id" value="<?= (int)$row['order_id'] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <!-- SweetAlert and JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(event, form) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the order.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>

    <?php if (isset($_SESSION['msg'])): ?>
        <script>
            Swal.fire({
                icon: '<?= $_SESSION['msg']['type'] ?>',
                title: '<?= $_SESSION['msg']['text'] ?>',
                showConfirmButton: false,
                timer: 2500
            });
        </script>
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>
</body>

</html>