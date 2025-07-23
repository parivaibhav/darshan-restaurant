<?php

include __DIR__ . '/../includes/db.php';

// Default filter: no restriction
$filter = $_GET['filter'] ?? '';
$whereClause = '';

$dateToday = date('Y-m-d');
switch ($filter) {
    case 'today':
        $whereClause = "WHERE booking_date = '$dateToday'";
        break;
    case 'last_week':
        $lastWeek = date('Y-m-d', strtotime('-7 days'));
        $whereClause = "WHERE booking_date BETWEEN '$lastWeek' AND '$dateToday'";
        break;
    case 'last_month':
        $lastMonth = date('Y-m-d', strtotime('-1 month'));
        $whereClause = "WHERE booking_date BETWEEN '$lastMonth' AND '$dateToday'";
        break;
    case 'last_year':
        $lastYear = date('Y-m-d', strtotime('-1 year'));
        $whereClause = "WHERE booking_date BETWEEN '$lastYear' AND '$dateToday'";
        break;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Darshan Restaurant | Bookings</title>

    <!-- Favicons -->
    <link href="../assets/img/logo.png" rel="icon" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />

    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet" />
    <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet" />
    <link href="../assets/css/main.css" rel="stylesheet" />
</head>

<body>
    <?php include 'header.php'; ?>

    <section id="menu" class="menu section">
        <div class="container">
            <h2 class="mb-4">All Bookings</h2>

            <!-- Filter Dropdown -->
            <form method="get" class="mb-4" style="max-width: 300px;">
                <div class="input-group">
                    <select name="filter" class="form-select" onchange="this.form.submit()">
                        <option value="">All Time</option>
                        <option value="today" <?= $filter == 'today' ? 'selected' : '' ?>>Today</option>
                        <option value="last_week" <?= $filter == 'last_week' ? 'selected' : '' ?>>Last Week</option>
                        <option value="last_month" <?= $filter == 'last_month' ? 'selected' : '' ?>>Last Month</option>
                        <option value="last_year" <?= $filter == 'last_year' ? 'selected' : '' ?>>Last Year</option>
                    </select>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Booking Time</th>
                            <th>Booking Date</th>
                            <th>People</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT id, name, email, phone, booking_time, booking_date, people, message FROM bookings $whereClause ORDER BY booking_date DESC, booking_time DESC";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0):
                            while ($row = $result->fetch_assoc()):
                        ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td><?= htmlspecialchars($row['phone']) ?></td>
                                    <td><?= htmlspecialchars($row['booking_time']) ?></td>
                                    <td><?= htmlspecialchars($row['booking_date']) ?></td>
                                    <td><?= htmlspecialchars($row['people']) ?></td>
                                    <td><?= htmlspecialchars($row['message']) ?></td>
                                </tr>
                            <?php
                            endwhile;
                        else:
                            ?>
                            <tr>
                                <td colspan="7" class="text-center">No bookings found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/formvalidation.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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