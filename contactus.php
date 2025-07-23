<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Darshan Restaurant | Contact</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="assets/img/logo.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <style>
        .feedback-form {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: 500;
        }

        .rating input[type="radio"] {
            display: none;
        }

        .rating label {
            font-size: 1.5rem;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
        }

        .rating input:checked~label,
        .rating label:hover,
        .rating label:hover~label {
            color: #ffc107;
        }
    </style>
    <script src="assets/js/modetoggle.js" defer></script>
    <script src="assets/vendor/sweetalert/sweetalert.js"></script>

</head>





<body>
    <?php include 'header.php'; ?>


    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Contact</h2>
            <p><span>Need Help?</span> <span class="description-title">Contact Us</span></p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="mb-5">
                <iframe style="width: 100%; height: 400px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3717.4970875329645!2d70.2514992!3d21.2913659!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bfd510d607be87d%3A0x83cbcbca8d4572b1!2sDarshan%20Restaurant!5e0!3m2!1sen!2sin!4v1746158733065!5m2!1sen!2sin" frameborder="0" allowfullscreen=""></iframe>
            </div><!-- End Google Maps -->

            <div class="row gy-4">

                <div class="col-md-6">
                    <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="200">
                        <i class="icon bi bi-geo-alt flex-shrink-0"></i>
                        <div>
                            <h3>Address</h3>
                            <p>Veraval road , somnath Highway , keshod</p>
                        </div>
                    </div>
                </div><!-- End Info Item -->

                <div class="col-md-6">
                    <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="300">
                        <i class="icon bi bi-telephone flex-shrink-0"></i>
                        <div>
                            <h3>Call Us</h3>
                            <p>+91 8799064890</p>
                        </div>
                    </div>
                </div><!-- End Info Item -->

                <div class="col-md-6">
                    <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="400">
                        <i class="icon bi bi-envelope flex-shrink-0"></i>
                        <div>
                            <h3>Email Us</h3>
                            <p>darshanhotel@gmail.com</p>
                        </div>
                    </div>
                </div><!-- End Info Item -->

                <div class="col-md-6">
                    <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="500">
                        <i class="icon bi bi-clock flex-shrink-0"></i>
                        <div>
                            <h3>Opening Hours<br></h3>
                            <p><strong>Mon-Sat:</strong> 11AM - 23PM; <strong>Sunday:</strong> Closed</p>
                        </div>
                    </div>
                </div><!-- End Info Item -->

            </div>

            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <form action="./includes/feedback_form.php" method="post" class="needs-validation feedback-form" novalidate>
                            <h2 class="mb-4 text-center">We Value Your Feedback</h2>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="John Doe" required />
                                    <div class="invalid-feedback">Please enter your name.</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Your Email</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com" required />
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Rate Your Experience</label>

                                    <!-- Align rating to the left -->
                                    <div class="rating d-flex justify-content-end flex-row-reverse">
                                        <input type="radio" name="rating" id="star5" value="5" />
                                        <label for="star5" title="5 stars">★</label>
                                        <input type="radio" name="rating" id="star4" value="4" />
                                        <label for="star4" title="4 stars">★</label>
                                        <input type="radio" name="rating" id="star3" value="3" />
                                        <label for="star3" title="3 stars">★</label>
                                        <input type="radio" name="rating" id="star2" value="2" />
                                        <label for="star2" title="2 stars">★</label>
                                        <input type="radio" name="rating" id="star1" value="1" />
                                        <label for="star1" title="1 star">★</label>
                                    </div>

                                    <!-- Align this message to the left too -->

                                </div>


                                <div class="col-md-12">
                                    <label for="comments" class="form-label">Your Feedback</label>
                                    <textarea name="comments" id="comments" class="form-control" rows="5" placeholder="What did you love? What can we improve?" required></textarea>
                                    <div class="invalid-feedback">Please share your feedback.</div>
                                </div>

                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-danger px-5">Submit </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- End Contact Form -->

        </div>

    </section><!-- /Contact Section -->
    <?php include 'footer.php'; ?>


    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/formvalidation.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert CDN -->

    <?php if (isset($_SESSION['alert'])): ?>
        <script>
            Swal.fire({
                icon: '<?= $_SESSION['alert']['status'] ?>', // 'success' or 'error'
                title: '<?= $_SESSION['alert']['msg'] ?>',
                confirmButtonColor: '#3085d6'
            });
        </script>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>
      
</body>

</html>