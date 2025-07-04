<?php
// db.php should contain $conn = new mysqli(...)
include __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth_check.php';
$user = requireLogin();
$email = $user['email'];

// Only users allowed (not admins)
if ($user['userType'] !== 'user') {
    if ($user['userType'] === 'admin') {
        header('Location: /college/admin/index');
        exit();
    }
    header('Location: /college/login');
    exit();
}


$imgPath = 'assets/img/usersprofiles/profilepic.jpg'; // Default

if (!empty($email)) {
    $stmt = $conn->prepare("SELECT user_img FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($fetchedImg);
    if ($stmt->fetch() && !empty($fetchedImg) && file_exists(__DIR__ . '/../' . ltrim($fetchedImg, '/\\'))) {
        $imgPath = $fetchedImg;
    }

    $stmt->close();
}
?>

<style>
    .avatar-btn {
        padding: 0;
        border: none;
        background: none;
    }

    .avatar-img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid rgb(135, 135, 135);
    }
</style>

<header id="header" class="header d-flex align-items-center sticky-top bg-white" id="main-navbar">
    <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="/college/users/index" class="logo d-flex align-items-center me-auto me-xl-0">
            <h1 class="sitename text-danger d-none d-lg-flex">Darshan Restaurant</h1>
        </a>

        <nav id="navmenu" class="navmenu mx-auto">
            <ul>
                <li><a href="/college/users/index">Home</a></li>
                <li><a href="/college/users/aboutus">About</a></li>
                <li><a href="/college/users/menu">Menu</a></li>
                <li><a href="/college/users/contactus">Contact</a></li>
                <li><a href="/college/users/myorder">My Order</a></li>
            </ul>
        </nav>

        <i class="mobile-nav-toggle d-xl-none bi bi-list mb-3 d-flex  justify-content-center"></i>
    </div>

    <div class=" d-flex align-items-center gap-3 px-4">

        <!-- Avatar Dropdown -->
        <div class="dropdown">
            <button class="avatar-btn" id="avatarDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="<?= htmlspecialchars($email) ?>">
                <img src="<?= "../" . htmlspecialchars($imgPath) ?>" alt="User Avatar" class="avatar-img" />
            </button>

            <ul class="dropdown-menu shadow" aria-labelledby="avatarDropdown">
                <li>
                    <!-- Button trigger modal -->
                    <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#updateProfileImageModal">
                        Update Profile Image
                    </a>

                </li>
                <li><a class="dropdown-item"
                        data-bs-toggle="modal" data-bs-target="#updatePwModal">
                        Change Password</a></li>
                <li>
                    <a href="#" class="dropdown-item text-danger"
                        data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        Remove Account
                    </a>
                </li>

                <li><a href="/logout" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a></li>
            </ul>
        </div>

    </div>
</header>
<!-- Modal -->
<div class="modal fade" id="updateProfileImageModal" tabindex="-1" aria-labelledby="updateProfileImageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../includes/update_profile_image.php" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateProfileImageModalLabel">Update Profile Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="file" name="profile_image" accept="image/*" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Are you sure you want to log out?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="../includes/logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- ===== Password‑change Modal ===== -->
<div class="modal fade" id="updatePwModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content needs-validation" id="pwForm" novalidate
            action="../includes/update_password.php" method="post">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">New password</label>
                    <input type="password" name="new" id="newPw" class="form-control" required>
                    <div class="form-text">≥3 chars, ≥1 symbol, ≥3 numbers</div>
                    <div class="invalid-feedback">Doesn’t meet the rules.</div>
                </div>
                <div class="mb-1">
                    <label class="form-label">Confirm new password</label>
                    <input type="password" name="confirm" id="confirmPw" class="form-control" required>
                    <div class="invalid-feedback">Passwords don’t match.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="saveBtn" class="btn btn-success" disabled>Save</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== Delete‑account Modal ===== -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="../includes/delete_account.php" method="post" onsubmit="return confirmFinalDelete()">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Delete My Account</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-0">
                    This will permanently delete your account, orders, and profile data.<br>
                    <strong>This action cannot be undone.</strong>
                </p>
                <p class="mt-3">
                    Please type <code>DELETE</code> below to confirm:
                </p>
                <input type="text" name="confirm_phrase" class="form-control" required>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>


<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));
</script>
<!-- ===== Script (place after Bootstrap bundle) =================== -->
<script>
    (() => {
        const form = document.getElementById('pwForm');
        const newPw = document.getElementById('newPw');
        const confirmPw = document.getElementById('confirmPw');
        const saveBtn = document.getElementById('saveBtn');

        const rule = /^(?=(?:.*\d){3,})(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>/?]).{3,}$/;

        function validate() {
            // Check rule on new password
            const ruleOK = rule.test(newPw.value);
            newPw.classList.toggle('is-invalid', !ruleOK);

            // Check match
            const matchOK = newPw.value === confirmPw.value && confirmPw.value !== '';
            confirmPw.classList.toggle('is-invalid', !matchOK);

            saveBtn.disabled = !(ruleOK && matchOK && form.checkValidity());
        }

        // live validation
        newPw.addEventListener('input', validate);
        confirmPw.addEventListener('input', validate);

        // standard Bootstrap validation on submit
        form.addEventListener('submit', e => {
            validate();
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    })();
</script>
<script>
    function confirmFinalDelete() {
        return confirm("Are you absolutely sure you want to delete your account?");
    }
</script>