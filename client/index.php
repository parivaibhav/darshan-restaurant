<?php


include __DIR__ . '/../includes/db.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch all feedback from DB
$stmt = $pdo->query("SELECT feedback_name, feedback_rating, feedback_message FROM feedback");
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Shuffle to randomize order
shuffle($feedbacks);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Project</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="../assets/img/logo.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="../assets/css/main.css" rel="stylesheet">
    <style>
        #animated-heading .line {
            display: block;
            overflow: hidden;
        }

        .hero-img {
            perspective: 1000px;
        }

        .hero-img img {
            transform-origin: center;
        }

        .testimonial-scroll-wrapper {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            scroll-behavior: auto;
            /* not smooth, animation handles smoothness */
            scrollbar-width: none;
        }

        .testimonial-scroll-wrapper::-webkit-scrollbar {
            display: none;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="../assets/js/modetoggle.js" defer></script>


</head>

<body class="index-page">

    <?php include 'header.php'; ?>
    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section light-background">

            <div class="container">
                <div class="row gy-4 justify-content-center justify-content-lg-between">
                    <div class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center">
                        <h1 id="animated-heading">
                            <span class="line">Enjoy Your Healthy</span>
                            <span class="line">Delicious Food</span>
                        </h1>

                        <!---->
                        <p id="animated-text">
                            Savor authentic flavors at Darshan Restaurant, where every dish is crafted with fresh ingredients, bold spices, and timeless recipes.
                        </p>
                        <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
                            <a href="#book-a-table" class="btn-get-started">Booka a Table</a>
                            <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>
                        </div>
                    </div>
                    <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
                        <img src="../assets/img/hero-img.png" class="img-fluid animated rounded" alt="">
                    </div>

                </div>
            </div>

        </section><!-- /Hero Section -->



        <!-- Why Us Section -->
        <section id="why-us" class="why-us section light-background">
            <div class="container">
                <div class="row gy-4">

                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="why-box">
                            <h3>Why Choose Darshan Restaurant</h3>
                            <p>
                                At Yummy, we’re passionate about delivering delicious food made with fresh, high-quality ingredients.
                                Our team is committed to exceptional service, ensuring every meal is a memorable experience.
                                With a wide variety of dishes and a welcoming atmosphere, we’re your go-to spot for tasty satisfaction.
                            </p>
                            <div class="text-center">
                                <a href="#" class="more-btn"><span>Learn More</span> <i class="bi bi-chevron-right"></i></a>
                            </div>
                        </div>
                    </div><!-- End Why Box -->

                    <div class="col-lg-8 d-flex align-items-stretch">
                        <div class="row gy-4" data-aos="fade-up" data-aos-delay="200">

                            <div class="col-xl-4">
                                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                    <i class="bi bi-clipboard-data"></i>
                                    <h4>Fresh Ingredients</h4>
                                    <p>We use only the freshest, locally sourced ingredients to ensure every bite is full of flavor.</p>
                                </div>
                            </div><!-- End Icon Box -->

                            <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
                                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                    <i class="bi bi-gem"></i>
                                    <h4>Exceptional Quality</h4>
                                    <p>Our chefs are dedicated to crafting meals that exceed your expectations in taste and presentation.</p>
                                </div>
                            </div><!-- End Icon Box -->

                            <div class="col-xl-4" data-aos="fade-up" data-aos-delay="400">
                                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                    <i class="bi bi-inboxes"></i>
                                    <h4>Fast & Friendly Service</h4>
                                    <p>Enjoy quick, courteous service from our friendly staff every time you visit.</p>
                                </div>
                            </div><!-- End Icon Box -->

                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- /Why Us Section -->

        <!-- Stats Section -->
        <section id="stats" class="stats section dark-background">

            <img src="../assets/img/stats-bg.jpg" alt="" data-aos="fade-in">

            <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1" class="purecounter"></span>
                            <p>Clients</p>
                        </div>
                    </div><!-- End Stats Item -->
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1" class="purecounter"></span>
                            <p>Projects</p>
                        </div>
                    </div><!-- End Stats Item -->
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="1453" data-purecounter-duration="1" class="purecounter"></span>
                            <p>Hours Of Support</p>
                        </div>
                    </div><!-- End Stats Item -->
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="32" data-purecounter-duration="1" class="purecounter"></span>
                            <p>Workers</p>
                        </div>
                    </div><!-- End Stats Item -->
                </div>
            </div>
        </section><!-- /Stats Section -->



        <!-- Testimonials Section -->

        <section id="testimonials" class="testimonials section container-fluid my-5">
            <div class="section-title mb-4 text-center">
                <h2>TESTIMONIALS</h2>
                <p>What Are They <span class="description-title">Saying About Us</span></p>
            </div>

            <div
                class="d-flex overflow-hidden px-3"
                style="gap: 1rem; padding-bottom: 1rem; white-space: nowrap; scroll-behavior: smooth;">
                <div
                    class="testimonial-scroll-wrapper d-flex"
                    style="gap: 1rem; white-space: nowrap; flex-wrap: nowrap;">
                    <?php
                    if (!empty($feedbacks)) {
                        // Filter feedbacks to only 4 and 5 stars
                        $filtered_feedbacks = array_filter($feedbacks, function ($fb) {
                            return isset($fb['feedback_rating']) && ($fb['feedback_rating'] == 4 || $fb['feedback_rating'] == 5);
                        });

                        $selected_feedbacks = array_slice($filtered_feedbacks, 0, 7);
                        $loop_items = array_merge($selected_feedbacks, $selected_feedbacks);

                        foreach ($loop_items as $fb):
                            $username = explode('@', $fb['feedback_name'])[0];
                            $rating = (int)$fb['feedback_rating'];
                            $message = htmlspecialchars($fb['feedback_message']);

                            $gender = rand(0, 1) ? 'men' : 'women';
                            $number = rand(0, 99);
                            $randomImage = "https://randomuser.me/api/portraits/$gender/$number.jpg";
                    ?>
                            <div
                                class="testimonial-item bg-light p-3 rounded d-flex flex-column align-items-center"
                                style="min-width: 300px; height: 220px; flex-shrink: 0;">

                                <img src="<?= $randomImage ?>" alt="User Image"
                                    style="width:60px; height:60px; border-radius:50%; object-fit:cover; margin-bottom: 10px; border: 2px solid #007bff;">

                                <p class="text-center" style="flex-grow: 1; margin-bottom: 10px;">
                                    <i class="bi bi-quote quote-icon-left"></i>
                                    <?= $message ?>
                                    <i class="bi bi-quote quote-icon-right"></i>
                                </p>

                                <h3 class="mb-1">@<?= htmlspecialchars($username) ?></h3>

                                <div class="stars">
                                    <?php for ($i = 0; $i < $rating; $i++): ?>
                                        <i class="bi bi-star-fill text-warning"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>

                    <?php
                        endforeach;
                    } else {
                        echo '<p class="text-center">No testimonials available.</p>';
                    }
                    ?>

                </div>
            </div>
        </section>
        <!-- /Testimonials Section -->

        <!-- Events Section -->
        <section id="events" class="events section py-5">
            <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">
                <div class="position-relative">

                    <!-- Swiper -->
                    <div class="swiper init-swiper">
                        <script type="application/json" class="swiper-config">
                            {
                                "loop": true,
                                "speed": 600,
                                "autoplay": {
                                    "delay": 5000
                                },
                                "navigation": {
                                    "nextEl": ".custom-swiper-next",
                                    "prevEl": ".custom-swiper-prev"
                                },
                                "pagination": {
                                    "el": ".swiper-pagination",
                                    "type": "bullets",
                                    "clickable": true
                                },
                                "breakpoints": {
                                    "320": {
                                        "slidesPerView": 1,
                                        "spaceBetween": 20
                                    },
                                    "768": {
                                        "slidesPerView": 2,
                                        "spaceBetween": 20
                                    },
                                    "1200": {
                                        "slidesPerView": 3,
                                        "spaceBetween": 30
                                    }
                                }
                            }
                        </script>

                        <div class="swiper-wrapper">
                            <!-- Slides -->
                            <div class="swiper-slide event-item d-flex flex-column justify-content-end text-white p-4 rounded shadow-lg"
                                style="background: url('../assets/img/events-1.jpg') center/cover no-repeat;">
                                <h3 class="mb-2">Custom Parties</h3>
                                <p class="description">Celebrate your unique moments with personalized setups and mouth-watering dishes, tailored to your needs.</p>
                            </div>

                            <div class="swiper-slide event-item d-flex flex-column justify-content-end text-white p-4 rounded shadow-lg"
                                style="background: url('../assets/img/events-2.jpg') center/cover no-repeat;">
                                <h3 class="mb-2">Private Gatherings</h3>
                                <p class="description">Enjoy an intimate atmosphere perfect for family dinners, corporate meetings, or friendly reunions.</p>
                            </div>

                            <div class="swiper-slide event-item d-flex flex-column justify-content-end text-white p-4 rounded shadow-lg"
                                style="background: url('../assets/img/events-3.jpg') center/cover no-repeat;">
                                <h3 class="mb-2">Birthday Celebrations</h3>
                                <p class="description">Make birthdays special with delightful decor, delicious food, and cheerful vibes at our restaurant.</p>
                            </div>

                            <div class="swiper-slide event-item d-flex flex-column justify-content-end text-white p-4 rounded shadow-lg"
                                style="background: url('../assets/img/events-4.jpg') center/cover no-repeat;">
                                <h3 class="mb-2">Wedding Moments</h3>
                                <p class="description">Host pre-wedding dinners or wedding receptions in an elegant setting with flavors to remember.</p>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="swiper-pagination mt-4"></div>
                    </div>

                    <!-- Navigation Buttons -->
                    <button type="button" class="custom-swiper-prev btn btn-light shadow-sm d-flex align-items-center justify-content-center 
          position-absolute top-50 start-0 translate-middle-y ms-2 z-3 rounded-circle"
                        style="width: 45px; height: 45px;">
                        <i class="bi bi-chevron-left fs-5"></i>
                    </button>

                    <button type="button" class="custom-swiper-next btn btn-light shadow-sm d-flex align-items-center justify-content-center 
          position-absolute top-50 end-0 translate-middle-y me-2 z-3 rounded-circle"
                        style="width: 45px; height: 45px;">
                        <i class="bi bi-chevron-right fs-5"></i>
                    </button>

                </div>
            </div>
        </section>><!-- /Events Section -->

        <!-- Chefs Section -->
        <section id="chefs" class="chefs section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>chefs</h2>
                <p><span>Our</span> <span class="description-title">Proffesional Chefs<br></span></p>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row gy-4">

                    <div class="col-lg-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                        <div class="team-member">
                            <div class="member-img">
                                <img src="../assets/img/chefs/chefs-1.jpg" class="img-fluid" alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>Walter White</h4>
                                <span>Master Chef</span>
                                <p>Velit aut quia fugit et et. Dolorum ea voluptate vel tempore tenetur ipsa quae aut. Ipsum exercitationem iure minima enim corporis et voluptate.</p>
                            </div>
                        </div>
                    </div><!-- End Chef Team Member -->

                    <div class="col-lg-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                        <div class="team-member">
                            <div class="member-img">
                                <img src="../assets/img/chefs/chefs-2.jpg" class="img-fluid" alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>Sarah Jhonson</h4>
                                <span>Patissier</span>
                                <p>Quo esse repellendus quia id. Est eum et accusantium pariatur fugit nihil minima suscipit corporis. Voluptate sed quas reiciendis animi neque sapiente.</p>
                            </div>
                        </div>
                    </div><!-- End Chef Team Member -->

                    <div class="col-lg-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
                        <div class="team-member">
                            <div class="member-img">
                                <img src="../assets/img/chefs/chefs-3.jpg" class="img-fluid" alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>William Anderson</h4>
                                <span>Cook</span>
                                <p>Vero omnis enim consequatur. Voluptas consectetur unde qui molestiae deserunt. Voluptates enim aut architecto porro aspernatur molestiae modi.</p>
                            </div>
                        </div>
                    </div><!-- End Chef Team Member -->

                </div>

            </div>

        </section><!-- /Chefs Section -->

        <!-- Book A Table Section -->
        <section id="book-a-table" class="book-a-table section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Book A Table</h2>
                <p><span>Book Your</span> <span class="description-title">Stay With Us<br></span></p>
            </div><!-- End Section Title -->

            <div class="container py-5">
                <div class="row g-0 shadow rounded-4 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                    <!-- Image Section -->
                    <div class="col-lg-4 d-none d-lg-block bg-cover" style="background-image: url('../assets/img/reservation.jpg'); background-size: cover; background-position: center;"></div>

                    <!-- Form Section -->
                    <div class="col-lg-8 bg-white p-5">
                        <h2 class="text-center mb-4 fw-bold text-primary">Book a Table</h2>
                        <form action="../includes/booking_table.php" method="post" class="php-email-form needs-validation" novalidate>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input type="text" name="name" class="form-control form-control-lg" placeholder="Your Name" required>
                                    <div class="invalid-feedback">Enter Valid name</div>
                                </div>
                                <div class="col-md-4">
                                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Your Email" required>
                                    <div class="invalid-feedback">Enter Valid email</div>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="phone" class="form-control form-control-lg" placeholder="Your Phone" required>
                                    <div class="invalid-feedback">Enter Valid phone number</div>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" name="date" class="form-control form-control-lg" id="datePicker" required>
                                    <div class="invalid-feedback">Enter Valid date</div>
                                </div>
                                <div class="col-md-4">
                                    <input type="time" name="time" class="form-control form-control-lg" required>
                                    <div class="invalid-feedback">Enter Valid time</div>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" name="people" class="form-control form-control-lg" placeholder="# of people" required>
                                    <div class="invalid-feedback">Enter Valid number</div>
                                </div>
                            </div>

                            <div class="form-floating mt-3">
                                <textarea class="form-control" placeholder="Message" name="message" style="height: 100px" required></textarea>
                                <div class="invalid-feedback">Enter Valid message</div>

                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">Book Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </section><!-- /Book A Table Section -->

        <!-- Gallery Section -->
        <section id="gallery" class="gallery section py-5">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Gallery</h2>
                <p><span>Check</span> <span class="description-title">Our Gallery</span></p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="swiper init-swiper position-relative">

                    <!-- Navigation Buttons -->
                    <button type="button" class="custom-swiper-prev btn btn-light shadow-sm d-flex align-items-center justify-content-center
        position-absolute top-50 start-0 translate-middle-y ms-2 z-3 rounded-circle"
                        style="width: 40px; height: 40px;">
                        <i class="bi bi-chevron-left fs-5"></i>
                    </button>

                    <button type="button" class="custom-swiper-next btn btn-light shadow-sm d-flex align-items-center justify-content-center
        position-absolute top-50 end-0 translate-middle-y me-2 z-3 rounded-circle"
                        style="width: 40px; height: 40px;">
                        <i class="bi bi-chevron-right fs-5"></i>
                    </button>

                    <?php
                    include __DIR__ . '/../includes/db.php'; // Adjust DB path

                    $result = $conn->query("SELECT id, file_path FROM gallery ORDER BY id DESC");
                    if ($result->num_rows > 0) {
                        echo '<div class="swiper-wrapper align-items-center">';
                        while ($row = $result->fetch_assoc()) {
                            $filePath =  htmlspecialchars($row['file_path']);
                            echo '<div class="swiper-slide" style="min-height: 200px;">';
                            echo '<a class="glightbox" data-gallery="images-gallery" href="' . $filePath . '" style="cursor:pointer;">';
                            echo '<img src="' . $filePath . '" class="img-fluid rounded shadow-sm" alt="Gallery Image" style="object-fit: cover; width: 100%; height: 200px;">';
                            echo '</a></div>';
                        }
                        echo '</div>';
                    } else {
                        echo '<p class="text-center">No images found in gallery.</p>';
                    }
                    $conn->close();
                    ?>

                    <!-- Pagination -->
                    <div class="swiper-pagination mt-3"></div>

                    <!-- Swiper config -->
                    <script type="application/json" class="swiper-config">
                        {
                            "loop": true,
                            "speed": 600,
                            "autoplay": {
                                "delay": 5000
                            },
                            "slidesPerView": "auto",
                            "centeredSlides": true,
                            "pagination": {
                                "el": ".swiper-pagination",
                                "type": "bullets",
                                "clickable": true
                            },
                            "navigation": {
                                "nextEl": ".custom-swiper-next",
                                "prevEl": ".custom-swiper-prev"
                            },
                            "breakpoints": {
                                "320": {
                                    "slidesPerView": 1,
                                    "spaceBetween": 0
                                },
                                "768": {
                                    "slidesPerView": 3,
                                    "spaceBetween": 20
                                },
                                "1200": {
                                    "slidesPerView": 3,
                                    "spaceBetween": 60
                                }
                            }
                        }
                    </script>

                </div>
            </div>
        </section><!-- /Gallery Section -->



    </main>

    <?php include 'footer.php'; ?>


    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <script src="./assets/js/cursoranimation.js"></script>
    <!-- Add this inside <body> -->
    <div id="custom-cursor"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
            <path fill="#000" d="M4.5.79v22.42l6.56-6.57h9.29L4.5.79z"></path>
        </svg></div>




    <!-- Vendor JS Files -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>
    <script src="../assets/vendor/aos/aos.js"></script>
    <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>


    <!-- Main JS File -->
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/fromvalidaiton.js"></script>
    <script src="../assets/js/cursoranimation.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert CDN -->
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
    <script>
        // Get today's date in YYYY-MM-DD format
        const today = new Date().toISOString().split('T')[0];

        // Set min attribute to today
        document.getElementById('datePicker').setAttribute('min', today);
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>


    <script src="../assets/js/gsapanimation.js"></script>


    <script>
        window.addEventListener('load', () => {
            const scrollContainer = document.querySelector('.testimonial-scroll-wrapper');

            let scrollSpeed = 2; // 🚀 Increase this number to scroll faster (e.g., 2 = fast, 5 = very fast)

            function autoScroll() {
                if (!scrollContainer) return;

                scrollContainer.scrollLeft += scrollSpeed;

                // Reset scroll when halfway through (since content is duplicated)
                if (scrollContainer.scrollLeft >= scrollContainer.scrollWidth / 2) {
                    scrollContainer.scrollLeft = 0;
                }

                requestAnimationFrame(autoScroll);
            }

            autoScroll();
        });
    </script>


</body>

</html>