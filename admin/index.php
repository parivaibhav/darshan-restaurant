<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Gallery Management</title>
    <link href="../assets/img/logo.png" rel="icon" />
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet" />
    <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />
    <link href="../assets/css/main.css" rel="stylesheet" />

    <script src="../assets/js/modetoggle.js" defer></script>

    <style>
        /* Modern card styling */
        .gallery .card {
            border-radius: 0.75rem;
            overflow: hidden;
            transition: box-shadow 0.3s ease;
            cursor: pointer;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .gallery .card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .gallery .card-img-top {
            object-fit: cover;
            height: 220px;
            width: 100%;
            transition: transform 0.3s ease;
        }

        .gallery .card:hover .card-img-top {
            transform: scale(1.05);
        }

        .gallery .card-body {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .btn-upload {
            border-radius: 50px;
            padding: 0.6rem 2.2rem;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-upload:hover {
            background-color: #0a58ca;
            box-shadow: 0 6px 20px rgba(10, 88, 202, 0.5);
        }

        /* Modal image preview */
        #deleteImagePreview {
            max-width: 100%;
            max-height: 250px;
            border-radius: 0.5rem;
            object-fit: contain;
            margin-bottom: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Responsive fixes */
        @media (max-width: 575.98px) {
            .gallery .card-img-top {
                height: 180px;
            }
        }
    </style>

</head>

<body class="index-page">
    <?php include 'header.php'; ?>

    <section class="section gallery py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <h1 class="h3 fw-bold mb-0">Gallery Management</h1>
                <button class="btn btn-primary btn-upload shadow-lg" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="bi bi-upload me-2"></i> Upload Image
                </button>
            </div>

            <!-- Upload Modal -->
            <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="../includes/gallery_image_upload.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="modal-content rounded-4 shadow">
                            <div class="modal-header border-0">
                                <h5 class="modal-title fw-semibold" id="uploadModalLabel">Upload New Image</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="file" name="image" class="form-control form-control-lg" accept="image/*" required />
                                <div class="invalid-feedback">Please select an image file to upload.</div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="submit" name="upload" class="btn btn-primary px-4 fw-semibold">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Gallery Grid -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php

                include __DIR__ . '/../includes/db.php';
                $result = $conn->query("SELECT * FROM gallery ORDER BY id DESC");

                if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                        $imgId = (int)$row['id'];
                        $imgPath = htmlspecialchars($row['file_path']);
                ?>
                        <div class="col">
                            <div class="card h-100 shadow-sm" role="group" aria-label="Gallery image">
                                <img src="<?= $imgPath ?>" alt="Gallery Image" class="card-img-top" loading="lazy" />
                                <div class="card-body text-center">
                                    <button
                                        class="btn btn-danger w-100 fw-semibold"
                                        onclick="confirmDelete(<?= $imgId ?>, '<?= $imgPath ?>')"
                                        aria-label="Delete image <?= $imgId ?>">
                                        <i class="bi bi-trash-fill me-2"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                else: ?>
                    <div class="text-center w-100 py-5 text-muted">
                        <i class="bi bi-image" style="font-size: 4rem;"></i>
                        <p class="mt-3 fs-5">No images found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="../includes/delete_gallery_image.php" method="POST" id="deleteForm" class="needs-validation" novalidate>
                    <input type="hidden" name="id" id="deleteImageId" />
                    <input type="hidden" name="imgpath" id="deleteImagePath" />
                    <div class="modal-content rounded-4 shadow">
                        <div class="modal-header border-0">
                            <h5 class="modal-title fw-semibold" id="confirmDeleteLabel">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <p class="mb-3 fs-5">Are you sure you want to delete this image?</p>
                            <img src="" id="deleteImagePreview" alt="Image to delete preview" class="img-fluid rounded" />
                        </div>
                        <div class="modal-footer border-0 d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary fw-semibold px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger fw-semibold px-4">Yes, Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center shadow-sm rounded-circle">
        <i class="bi bi-arrow-up-short fs-3"></i>
    </a>



    <!-- JS -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <script src="../assets/vendor/aos/aos.js"></script>
    <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>




    <script src="../assets/js/formvalidation.js"></script>

    <!-- Delete Logic -->
    <script>
        function confirmDelete(id, imgPath) {
            document.getElementById('deleteImageId').value = id;
            document.getElementById('deleteImagePath').value = imgPath;
            document.getElementById('deleteImagePreview').src = imgPath;
            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   
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
</body>

</html>