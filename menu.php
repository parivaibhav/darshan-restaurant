<?php

include_once "./includes/db.php";

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);

// Define preferred category order
$preferred_order = ['Starter', 'Breakfast', 'Lunch', 'Dinner'];

// Fetch all unique categories from the menu
$catSql = "SELECT DISTINCT menu_category FROM menu";
$catResult = $conn->query($catSql);

$foundCategories = [];
if ($catResult->num_rows > 0) {
    while ($cat = $catResult->fetch_assoc()) {
        $foundCategories[] = $cat['menu_category'];
    }
}

// Sort categories by preferred order, append any remaining ones
$categories = [];
foreach ($preferred_order as $prefCat) {
    if (in_array($prefCat, $foundCategories)) {
        $categories[] = $prefCat;
    }
}
foreach ($foundCategories as $cat) {
    if (!in_array($cat, $categories)) {
        $categories[] = $cat;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Our Menu</title>

    <!-- Favicons -->
    <link href="assets/img/logo.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts & Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body style="cursor:none;">
    <?php include 'header.php'; ?>

    <section id="menu" class="menu section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Our Menu</h2>
            <p><span>Check Our</span> <span class="description-title">Darshan Menu</span></p>
        </div>

        <!-- Category Tabs -->
        <ul class="nav nav-tabs d-flex justify-content-center" id="menuTab" role="tablist">
            <?php foreach ($categories as $index => $cat): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= $index === 0 ? 'active' : '' ?>"
                        id="tab-<?= md5($cat) ?>"
                        data-bs-toggle="tab"
                        data-bs-target="#content-<?= md5($cat) ?>"
                        type="button"
                        role="tab"
                        aria-controls="content-<?= md5($cat) ?>"
                        aria-selected="<?= $index === 0 ? 'true' : 'false' ?>">
                        <?= htmlspecialchars($cat) ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Menu Items -->
        <div class="tab-content mt-5" id="menuTabContent">
            <?php foreach ($categories as $index => $cat): ?>
                <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>"
                    id="content-<?= md5($cat) ?>" role="tabpanel">
                    <div class="container">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM menu WHERE menu_category = ?");
                            $stmt->bind_param("s", $cat);
                            $stmt->execute();
                            $itemsResult = $stmt->get_result();

                            if ($itemsResult->num_rows > 0):
                                while ($item = $itemsResult->fetch_assoc()):
                            ?>
                                    <div class="col">
                                        <div class="card h-100 shadow-sm border-0 p-2 ">
                                            <img src="<?= htmlspecialchars($item['menu_image']) ?>"
                                                class="card-img-top"
                                                alt="<?= htmlspecialchars($item['menu_name']) ?>"
                                                style="object-fit: cover; height: 200px;">
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title text-primary"><?= htmlspecialchars($item['menu_name']) ?></h5>
                                                <p class="card-text flex-grow-1"><?= htmlspecialchars($item['menu_description']) ?></p>
                                                <div class="mt-3">
                                                    <p class="mb-2"><strong>₹<?= number_format($item['menu_price'], 2) ?></strong></p>
                                                    <button type="button"
                                                        class="btn btn-outline-primary w-100 buy-now-btn"
                                                        data-id="<?= $item['menu_id'] ?>"
                                                        data-name="<?= htmlspecialchars($item['menu_name']) ?>"
                                                        data-description="<?= htmlspecialchars($item['menu_description']) ?>"
                                                        data-price="<?= $item['menu_price'] ?>"
                                                        data-image="<?= htmlspecialchars($item['menu_image']) ?>">
                                                        Buy Now
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile;
                            else: ?>
                                <div class="col">
                                    <div class="alert alert-warning text-center w-100">No items in this category.</div>
                                </div>
                            <?php endif;
                            $stmt->close(); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <!-- Scroll Top & Preloader -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/js/main.js"></script>

    <!-- Buy Now Button Script -->
    <script>
        document.querySelectorAll('.buy-now-btn').forEach(button => {
            button.addEventListener('click', function() {
                <?php if (!$is_logged_in): ?>
                    // Not logged in - show login prompt
                    Swal.fire({
                        title: 'Login Required',
                        text: 'You must be logged in to purchase this item.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Login',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/college/login';
                        }
                    });
                <?php else: ?>
                    // Logged in - show placeholder success alert
                    Swal.fire({
                        title: 'Ready to Order',
                        text: 'You are logged in. Proceed to order or show modal here.',
                        icon: 'success'
                    });
                <?php endif; ?>
            });
        });
    </script>
        <div id="custom-cursor"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
            <path fill="#000" d="M4.5.79v22.42l6.56-6.57h9.29L4.5.79z"></path>
        </svg></div>
    <script src="./assets/js/cursoranimation.js"></script>
</body>

</html>