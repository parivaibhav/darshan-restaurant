<?php


include __DIR__ . '/../includes/db.php';

$imageBasePath = '../'; // This path already starts with ../

// Fetch distinct categories
$catSql = "SELECT DISTINCT menu_category FROM menu";
$catResult = $conn->query($catSql);

$categories = [];
if ($catResult && $catResult->num_rows > 0) {
    while ($cat = $catResult->fetch_assoc()) {
        $categories[] = $cat['menu_category'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Darshan Restaurant | Menu Management</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Main CSS File -->
    <link href="../assets/css/main.css" rel="stylesheet" />
    <script src="../assets/js/modetoggle.js" defer></script>
    <style>
    .add-btn {
  border: 2px solid #24b4fb;
  background-color: #24b4fb;
  border-radius: 0.9em;
  cursor: pointer;
  padding: 0.8em 1.2em 0.8em 1em;
  transition: all ease-in-out 0.2s;
  font-size: 16px;
  margin-left:50px;
  margin-bottom:30px;
}

 .add-btn span {
  display: flex;
  justify-content: center;
  align-items: center;
  color: #fff;
  font-weight: 600;
}

 .add-btn:hover {
  background-color: #0071e2;
}
    </style>
</head>

<body>
  
 <?php include  __DIR__ .  '/header.php'; ?>


    <section class='menu'>
      <button data-bs-toggle="modal" data-bs-target="#addMenuModal" class="add-btn">
            <span>
                <svg
                   height="24"
                   width="24"
                     viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                 >
                     <path d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor"></path>
              </svg>
              Add Menu Item
            </span>
        </button>

        <!-- Add Menu Item Modal -->
        <div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <form action="../includes/menu_add.php" method="POST" enctype="multipart/form-data"
                    class="modal-content needs-validation" novalidate>
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMenuModalLabel">Add New Menu Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="menu_name" class="form-label">Name</label>
                            <input type="text" name="menu_name" id="menu_name" class="form-control" required />
                            <div class="invalid-feedback">Please enter the menu item name.</div>
                        </div>

                        <div class="mb-3">
                            <label for="menu_description" class="form-label">Description</label>
                            <textarea name="menu_description" id="menu_description" class="form-control" rows="3"
                                required></textarea>
                            <div class="invalid-feedback">Please enter a description.</div>
                        </div>

                        <div class="mb-3">
                            <label for="menu_price" class="form-label">Price (₹)</label>
                            <input type="text" name="menu_price" id="menu_price" class="form-control" required
                                pattern="^\d+(\.\d{1,2})?$" />
                            <div class="invalid-feedback">Please enter a valid numeric price.</div>
                        </div>

                        <div class="mb-3">
                            <label for="menu_category" class="form-label">Category</label>
                            <select name="menu_category" id="menu_category" class="form-select" required>
                                <option value="" disabled selected>Select category</option>
                                <?php foreach ($categories as $catOption): ?>
                                    <option value="<?= htmlspecialchars($catOption) ?>">
                                        <?= htmlspecialchars($catOption) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Please select a category.</div>
                        </div>

                        <div class="mb-3">
                            <label for="menu_image" class="form-label">Image</label>
                            <input type="file" name="menu_image" id="menu_image" class="form-control" accept="image/*"
                                required />
                            <div class="invalid-feedback">Please upload an image.</div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add Item</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Categories Tabs -->
        <ul class="nav nav-tabs d-flex align-content-center justify-content-center" id="menuTab" role="tablist">
            <?php foreach ($categories as $index => $cat): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= $index === 0 ? 'active' : '' ?>" id="tab-<?= md5($cat) ?>"
                        data-bs-toggle="tab" data-bs-target="#content-<?= md5($cat) ?>" type="button" role="tab"
                        aria-controls="content-<?= md5($cat) ?>" aria-selected="<?= $index === 0 ? 'true' : 'false' ?>">
                        <?= htmlspecialchars($cat) ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Tab contents -->
        <div class="tab-content " id="menuTabContent">
            <?php foreach ($categories as $index => $cat): ?>
                <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?> mt-5" id="content-<?= md5($cat) ?>" role="tabpanel"
                    aria-labelledby="tab-<?= md5($cat) ?>">
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
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                        <div class="card h-100 shadow-sm border-0 p-3 m-2">
                                            <img src="<?= htmlspecialchars($imageBasePath . $item['menu_image']) ?>" class="card-img-top"
                                                alt="<?= htmlspecialchars($item['menu_name']) ?>"
                                                style="object-fit: cover; height: 200px; width: 100%;" loading="lazy" />
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title text-primary"><?= htmlspecialchars($item['menu_name']) ?></h5>
                                                <p class="card-text flex-grow-1 text-truncate" style="max-height: 4.5em; overflow: hidden;">
                                                    <?= htmlspecialchars($item['menu_description']) ?>
                                                </p>
                                                <div class="mt-auto">
                                                    <p class="mb-3 fs-5 fw-bold">₹<?= number_format($item['menu_price']) ?></p>
                                                    <div class="d-flex w-100 flex-column">
                                                        <!-- Edit button -->
                                                        <button type="button" class="btn  btn-warning flex-fill mb-3" data-bs-toggle="modal"
                                                            data-bs-target="#editModal" data-id="<?= $item['menu_id'] ?>"
                                                            data-name="<?= htmlspecialchars($item['menu_name']) ?>"
                                                            data-description="<?= htmlspecialchars($item['menu_description']) ?>"
                                                            data-price="<?= $item['menu_price'] ?>"
                                                            data-category="<?= htmlspecialchars($item['menu_category']) ?>"
                                                            data-image="<?= htmlspecialchars($item['menu_image']) ?>">
                                                            Edit
                                                        </button>

                                                        <!-- Delete button -->
                                                        <button type="button" class="btn  btn-danger flex-fill" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal" data-id="<?= $item['menu_id'] ?>"
                                                            data-name="<?= htmlspecialchars($item['menu_name']) ?>">
                                                            Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                endwhile;
                            else:
                                ?>
                                <p>No menu items found in this category.</p>
                            <?php
                            endif;
                            $stmt->close();
                            ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php include  __DIR__ .  '/../footer.php'; ?>
        <!-- Edit Menu Item Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <form action="../includes/menu_edit.php" method="POST" enctype="multipart/form-data"
                    class="modal-content needs-validation" novalidate>
                    <input type="hidden" name="menu_id" id="edit-menu-id" />
                    <!-- Hidden input for existing image filename -->
                    <input type="hidden" name="existing_image" id="existing_image" />

                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Menu Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-menu-name" class="form-label">Name</label>
                            <input type="text" name="menu_name" id="edit-menu-name" class="form-control" required />
                            <div class="invalid-feedback">Please enter the menu item name.</div>
                        </div>

                        <div class="mb-3">
                            <label for="edit-menu-description" class="form-label">Description</label>
                            <textarea name="menu_description" id="edit-menu-description" class="form-control" rows="3"
                                required></textarea>
                            <div class="invalid-feedback">Please enter a description.</div>
                        </div>

                        <div class="mb-3">
                            <label for="edit-menu-price" class="form-label">Price (₹)</label>
                            <input type="text" name="menu_price" id="edit-menu-price" class="form-control" required
                                pattern="^\d+(\.\d{1,2})?$" />
                            <div class="invalid-feedback">Please enter a valid numeric price.</div>
                        </div>

                        <div class="mb-3">
                            <label for="edit-menu-category" class="form-label">Category</label>
                            <select name="menu_category" id="edit-menu-category" class="form-select" required>
                                <option value="" disabled>Select category</option>
                                <?php foreach ($categories as $catOption): ?>
                                    <option value="<?= htmlspecialchars($catOption) ?>">
                                        <?= htmlspecialchars($catOption) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Please select a category.</div>
                        </div>

                        <div class="mb-3">
                            <label for="edit-menu-image" class="form-label">Image</label>
                            <div class="mt-3">
                                <img id="current-image" src="" alt="Current Image" class="img-thumbnail" style="max-height: 150px;" />
                            </div>
                            <small class="form-text text-muted d-block mb-2">
                                Upload a new image to replace the current one (optional).
                            </small>
                            <input type="file" class="form-control" id="edit-menu-image" name="menu_image" />


                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="../includes/menu_delete.php" method="POST" class="modal-content">
                    <input type="hidden" name="menu_id" id="delete-menu-id" />
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p>Are you sure you want to delete the menu item: <strong id="delete-menu-name"></strong>?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </section>


    <!-- Bootstrap JS and dependencies -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <script src="../assets/js/formvalidation.js"></script>


    <script>
        // Edit Modal population
        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var description = button.getAttribute('data-description');
            var price = button.getAttribute('data-price');
            var category = button.getAttribute('data-category');
            var image = button.getAttribute('data-image');

            // Set form values
            document.getElementById('edit-menu-id').value = id;
            document.getElementById('edit-menu-name').value = name;
            document.getElementById('edit-menu-description').value = description;
            document.getElementById('edit-menu-price').value = price;
            document.getElementById('edit-menu-category').value = category;
            document.getElementById('existing_image').value = image;

            // Show current image
            var currentImage = document.getElementById('current-image');
            currentImage.src = "<?= $imageBasePath ?>" + image;
            currentImage.alt = name;
        });

        // Delete Modal population
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');

            document.getElementById('delete-menu-id').value = id;
            document.getElementById('delete-menu-name').textContent = name;
        });
    </script>
            <script src="../assets/vendor/sweetalert/sweetalert.js"></script>
    <?php if (isset($_SESSION['msg'])): ?>
        <script>
            Swal.fire({
                icon: '<?= $_SESSION['msg']['type'] ?>', // 'success', 'error', etc.
                title: '<?= $_SESSION['msg']['text'] ?>',
                showConfirmButton: false,
                timer: 2500
            });
        </script>
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>
 <script src="../assets/js/main.js"></script>
</body>

</html>