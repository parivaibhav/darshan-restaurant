<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth_check.php';

$user = requireLogin();                     // redirect → /login if not logged in

/* ---------- role gate ---------- */
if ($user['userType'] !== 'admin') {
    header('Location: ' . ($user['userType'] === 'user'
        ? '/college/users/index' : '/college/login'));
    exit();
}

/* ---------- fetch the freshest user_img from DB ---------- */
$avatarDB = null;
$stmt = $conn->prepare("SELECT user_img FROM users WHERE email = ?");
if ($stmt) {
    $stmt->bind_param('s', $user['email']);
    $stmt->execute();
    $stmt->bind_result($avatarDB);
    $stmt->fetch();
    $stmt->close();
}

/* ---------- build avatar path ---------- */
$uploadsRel = 'assets/img/usersprofiles/';            // relative path from web root
$defaultRel = $uploadsRel . 'profilepic.jpg';
$avatarRel  = $defaultRel;

/* choose DB value if present */
if ($avatarDB) {
    // Normalize the path - remove leading slashes and ensure consistent format
    $normalizedPath = ltrim($avatarDB, '/\\');
    
    // Check if file exists
    $filePath = __DIR__ . '/../' . $normalizedPath;
    if (file_exists($filePath)) {
        $avatarRel = $normalizedPath;
    }
}

$_SESSION['email'] = $user['email'];

/* ---------- build final URL ---------- */
$avatarUrl = '../' . $avatarRel;

/* ---------- other header values ---------- */
$email = $user['email'];

/* ---------- email condition check ---------- */
$isSpecialEmail = ($email === 'parivaibhav@gmail.com');
?>
<!-- ===== ADMIN HEADER (Bootstrap 5) ===== -->
<style>
.avatar-btn{padding:0;border:none;background:none}
.avatar-img{width:40px;height:40px;object-fit:cover;border-radius:50%;
            border:2px solid rgb(135,135,135)}
</style>





<header id="header" class="header d-flex align-items-center sticky-top bg-white " id="main-navbar">
    <div class="container position-relative d-flex align-items-center justify-content-between">

        <a href="/college/admin/index" class="logo d-flex align-items-center me-auto me-xl-0">
            <h1 class="sitename text-danger">Darshan Restaurant</h1>
            <?php if ($isSpecialEmail): ?>
                <span class="badge bg-success ms-2" style="font-size: 0.7rem;">Special Access</span>
            <?php endif; ?>
        </a>

        <nav id="navmenu" class="navmenu mx-auto">
            <ul>
                <li><a href="/college/admin/index">Home</a></li>
                <li><a href="/college/admin/menu">Menu</a></li>
                <?php if ($isSpecialEmail): ?>
                    <li><a href="/college/admin/users">Users</a></li>

                <?php endif; ?>
                <li><a href="/college/admin/myorder">Orders</a></li>
                <li><a href="/college/admin/bookings">Bookings</a></li>
            </ul>
        </nav>

        <i class="mobile-nav-toggle d-xl-none bi bi-list mb-3"></i>
    </div>
   <!-- avatar -->
   <div class="d-flex align-items-center gap-3 px-4">
    <div class="dropdown">
      <button class="avatar-btn" id="avatarDropdown"
              data-bs-toggle="dropdown" aria-expanded="false"
              title="<?= htmlspecialchars($email) ?>">
        <img src="<?= htmlspecialchars($avatarUrl) ?>"
             alt="User Avatar" class="avatar-img">
      </button>
      <ul class="dropdown-menu shadow" aria-labelledby="avatarDropdown">
       
        <li><a href="#" class="dropdown-item"
               data-bs-toggle="modal" data-bs-target="#updateProfileImageModal">
               Update Profile Image</a></li>
        <li><a class="dropdown-item"
               data-bs-toggle="modal" data-bs-target="#updatePwModal">
               Change Password</a></li>
        <li><a href="/logout" class="dropdown-item"
               data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a></li>
      </ul>
    </div>
  </div>
</header>

<!-- ===== Profile‑image Modal ===== -->
<div class="modal fade" id="updateProfileImageModal" tabindex="-1"
     aria-labelledby="updateProfileImageModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="../includes/update_profile_image.php"
            method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="updateProfileImageModalLabel">Update Profile Image</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="file" name="profile_image" accept="image/*"
                 class="form-control" required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary"
                  data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </form>
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

<!-- ===== Logout Confirmation Modal ===== -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title">Confirm Logout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">Are you sure you want to log out?</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="../includes/logout.php" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>
</div>

<script>
/* tooltips */
document.querySelectorAll('[data-bs-toggle="tooltip"]')
        .forEach(el => new bootstrap.Tooltip(el));

/* password validation */
(() => {
  const form      = document.getElementById('pwForm');
  const newPw     = document.getElementById('newPw');
  const confirmPw = document.getElementById('confirmPw');
  const saveBtn   = document.getElementById('saveBtn');

  const rule = /^(?=(?:.*\d){3,})(?=.*[!@#$%^&*()_+\-=[\\]{};':"\\|,.<>\\/?]).{3,}$/;

  function validate() {
    const ruleOK  = rule.test(newPw.value);
    newPw.classList.toggle('is-invalid', !ruleOK);

    const matchOK = newPw.value === confirmPw.value && confirmPw.value !== '';
    confirmPw.classList.toggle('is-invalid', !matchOK);

    saveBtn.disabled = !(ruleOK && matchOK && form.checkValidity());
  }

  newPw.addEventListener('input', validate);
  confirmPw.addEventListener('input', validate);

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
<!-- ===== /ADMIN HEADER ===== -->
