<?php

include __DIR__ . '/../includes/db.php';

// Handle success/error messages from session (for SweetAlert)


// Fetch orders
$sql = "SELECT order_id, email, menu_name, quantity, mobile, address, status FROM orders ORDER BY order_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Project</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <!-- Favicons -->
    <link href="../assets/img/logo.png" rel="icon" />
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Amatic+SC:wght@400;700&display=swap"
        rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet" />
    <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

    <!-- Main CSS File -->
    <link href="../assets/css/main.css" rel="stylesheet" />
    <script src="../assets/js/modetoggle.js" defer></script>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container py-4">
        <h2 class="mb-4 text-center">Order Management</h2>



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
            return false;
        }
    </script>
      <div id="custom-cursor"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
            <path fill="#000" d="M4.5.79v22.42l6.56-6.57h9.29L4.5.79z"></path>
        </svg></div>
    <script src="../assets/js/cursoranimation.js"></script>
</body>

</html>