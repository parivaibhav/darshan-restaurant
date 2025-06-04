<?php


include __DIR__ . '/../includes/db.php';

// Fetch distinct categories
$catSql = "SELECT DISTINCT menu_category FROM menu";
$catResult = $conn->query($catSql);

$categories = [];
if ($catResult->num_rows > 0) {
    while ($cat = $catResult->fetch_assoc()) {
        $categories[] = $cat['menu_category'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Project</title>

    <!-- Favicons -->
    <link href="../assets/img/logo.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Inter&family=Amatic+SC&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="../assets/css/main.css" rel="stylesheet">
    <script src="../assets/js/modetoggle.js" defer></script>
</head>

<body>
    <?php include 'header.php'; ?>

    <section id="menu" class="menu section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Our Menu</h2>
            <p><span>Check Our</span> <span class="description-title">Yummy Menu</span></p>
        </div>

        <ul class="nav nav-tabs d-flex align-content-center justify-content-center" id="menuTab" role="tablist">
            <?php foreach ($categories as $index => $cat): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= $index === 0 ? 'active' : '' ?>" id="tab-<?= md5($cat) ?>" data-bs-toggle="tab" data-bs-target="#content-<?= md5($cat) ?>" type="button" role="tab" aria-controls="content-<?= md5($cat) ?>" aria-selected="<?= $index === 0 ? 'true' : 'false' ?>">
                        <?= htmlspecialchars($cat) ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="tab-content mt-5" id="menuTabContent">
            <?php foreach ($categories as $index => $cat): ?>
                <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="content-<?= md5($cat) ?>" role="tabpanel" aria-labelledby="tab-<?= md5($cat) ?>">
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
                                        <div class="card h-100 shadow-sm border-0 px-2 py-2">
                                            <img src="../<?= htmlspecialchars($item['menu_image']) ?>"
                                                class="card-img-top"
                                                alt="<?= htmlspecialchars($item['menu_name']) ?>"
                                                style="object-fit: cover; height: 200px;">

                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title text-primary"><?= htmlspecialchars($item['menu_name']) ?></h5>
                                                <p class="card-text flex-grow-1"><?= htmlspecialchars($item['menu_description']) ?></p>
                                                <div class="mt-3">
                                                    <p class="mb-2"><strong>₹<?= number_format($item['menu_price'], 2) ?></strong></p>
                                                    <button type="button"
                                                        class="btn btn-outline-primary w-100"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#buyModal"
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
                                <?php endwhile; ?>
                            <?php else: ?>
                                <div class="col">
                                    <div class="alert alert-warning text-center w-100">No items in this category.</div>
                                </div>
                            <?php endif;
                            $stmt->close();
                            ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="buyModal" tabindex="-1" aria-labelledby="buyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow">
                <form action="../includes/menu_order.php" method="post" class="needs-validation" novalidate>
                    <div class="modal-header">
                        <h5 class="modal-title" id="buyModalLabel">Item Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-4">
                            <div class="col-md-5 text-center">
                                <img id="modal-image" src="" alt="" class="img-fluid rounded shadow-sm" />
                            </div>
                            <div class="col-md-7">
                                <h4 id="modal-name" class="text-primary fw-bold"></h4>
                                <p id="modal-description" class="text-muted"></p>
                                <p><strong>Price: ₹<span id="modal-price"></span></strong></p>
                                <p><strong>Total: ₹<span id="modal-total-price"></span></strong></p>

                                <!-- Hidden inputs -->
                                <input type="hidden" name="menu_id" id="input-menu-id" />
                                <input type="hidden" name="menu_name" id="input-menu-name" />
                                <input type="hidden" name="price" id="input-price" />
                                <input type="hidden" name="total_price" id="input-total-price" />
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        class="form-control"
                                        value="<?php echo $_SESSION['email'] ?>"
                                        readonly
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" id="quantity" name="quantity" class="form-control" min="1" value="1" required>
                                    <div class="invalid-feedback">Please enter valid quantity</div>
                                </div>
                                <div class="mb-3">
                                    <label for="mobile" class="form-label">Mobile Number</label>
                                    <input type="tel" id="mobile" name="mobile" class="form-control" pattern="[0-9]{10}" maxlength="10" required>
                                    <div class="invalid-feedback">Please enter valid number.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Delivery Address</label>
                                    <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
                                    <div class="invalid-feedback">Please enter valid address</div>
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-success" id="confirm-buy">Confirm Purchase</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php include 'footer.php'; ?>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Add this inside <body> -->
    <div id="custom-cursor"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
            <path fill="#000" d="M4.5.79v22.42l6.56-6.57h9.29L4.5.79z"></path>
        </svg></div>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>
    <script src="../assets/vendor/aos/aos.js"></script>
    <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/formvalidation.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buyModal = document.getElementById('buyModal');

            const modalName = document.getElementById('modal-name');
            const modalPrice = document.getElementById('modal-price');
            const modalTotalPrice = document.getElementById('modal-total-price');

            const inputMenuId = document.getElementById('input-menu-id');
            const inputMenuName = document.getElementById('input-menu-name');
            const inputPrice = document.getElementById('input-price');
            const inputTotalPrice = document.getElementById('input-total-price');
            const quantityInput = document.getElementById('quantity');

            function updateTotalPrice() {
                const price = parseFloat(modalPrice.textContent) || 0;
                const quantity = parseInt(quantityInput.value) || 1;
                const total = price * quantity;
                modalTotalPrice.textContent = total.toFixed(2);

                inputPrice.value = price.toFixed(2);
                inputTotalPrice.value = total.toFixed(2);
            }

            quantityInput.addEventListener('input', updateTotalPrice);

            function setModalData(id, name, price, description, imageUrl) {
                inputMenuId.value = id;
                modalName.textContent = name;
                modalPrice.textContent = price.toFixed(2);
                modalTotalPrice.textContent = price.toFixed(2);

                inputMenuName.value = name;
                inputPrice.value = price.toFixed(2);
                inputTotalPrice.value = price.toFixed(2);

                document.getElementById('modal-description').textContent = description;
                document.getElementById('modal-image').src = imageUrl;

                quantityInput.value = 1;
            }

            buyModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const description = button.getAttribute('data-description');
                const price = parseFloat(button.getAttribute('data-price'));
                const imageUrl = "../" + button.getAttribute('data-image');


                setModalData(id, name, price, description, imageUrl);
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if (isset($_SESSION['order_status'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: '<?= $_SESSION['order_status']['status'] ?>',
                    title: '<?= $_SESSION['order_status']['status'] === 'success' ? 'Success!' : 'Oops!' ?>',
                    text: '<?= $_SESSION['order_status']['message'] ?>',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    <?php unset($_SESSION['order_status']);
    endif; ?>
    <script src="../assets/js/cursoranimation.js"></script>

</body>

</html>