<?php
/* ------------------------------------------------------------------
 *  update_profile_image.php   – shared by user & admin dashboards
 * ------------------------------------------------------------------
 *  Requires:
 *    • db.php            →  $conn   (mysqli)
 *    • auth_check.php    →  requireLogin()
 *  Upload dir:           /assets/img/usersprofiles/
 *  Max size:             2 MB
 *  Allowed MIME:         JPEG | PNG | GIF | WebP
 * ----------------------------------------------------------------*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth_check.php';

$user = requireLogin();                         // redirects to /login if not signed in

/* ---------- role‑based redirect target ---------- */
switch ($user['userType'] ?? '') {
    case 'admin':
        $after = '/college/admin/index';
        break;
    case 'user':
        $after = '/college/users/index';
        break;
    default:
        header('Location: /college/login');
        exit();
}

$email    = $user['email'];                     // we’ll use this in WHERE …
$userId   = (int)$user['id'];                   // still handy for unique filename
$oldImage = $user['user_img'] ?? null;

/* ---------- configuration ---------- */
$folderRel = 'assets/img/usersprofiles/';                    // relative (from web root)
$uploadDir = realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR . $folderRel;
$maxBytes  = 2 * 1024 * 1024;                                // 2 MB
$allowed   = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$defaultImg= $folderRel . 'profilepic.jpg';
/* ----------------------------------- */

/* Ensure upload directory exists & is writable */
if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
    die('Upload directory does not exist and could not be created.');
}

/* ---------- request sanity ---------- */
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_FILES['profile_image'])) {
    header("Location: {$after}");
    exit();
}

$file = $_FILES['profile_image'];

/* ---------- upload validation ---------- */
if ($file['error'] !== UPLOAD_ERR_OK) {
    die('Upload error (code ' . $file['error'] . ')');
}
if ($file['size'] > $maxBytes) {
    die('Image exceeds 2 MB.');
}
$realMime = mime_content_type($file['tmp_name']);
if (!in_array($realMime, $allowed, true)) {
    die('Unsupported file type: ' . $realMime);
}

/* ---------- unique filename ---------- */
$ext      = image_type_to_extension(exif_imagetype($file['tmp_name'])); // e.g. .jpg
$newName  = 'uid' . $userId . '-' . time() . bin2hex(random_bytes(4)) . $ext;
$target   = $uploadDir . $newName;                 // absolute path on disk
$relative = $folderRel . $newName;                 // value stored in DB

/* ---------- move the file ---------- */
if (!move_uploaded_file($file['tmp_name'], $target)) {
    die('Failed to save uploaded image.');
}

/* ---------- delete previous custom avatar ---------- */
if ($oldImage && $oldImage !== $defaultImg) {
    $oldAbs = realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR . ltrim($oldImage, '/\\');
    if ($oldAbs && file_exists($oldAbs)) {
        @unlink($oldAbs);
    }
}

/* ---------- update DB using email in WHERE clause ---------- */
$stmt = $conn->prepare("UPDATE users SET user_img = ? WHERE email = ?");
if (!$stmt) {
    die('Prepare failed: ' . $conn->error);       // column name, perms, etc.
}
$stmt->bind_param('ss', $relative, $email);       // 'ss' → both params are strings
if (!$stmt->execute()) {
    die('Execute failed: ' . $stmt->error);       // value too long, FK, etc.
}
$stmt->close();


/* ---------- finished ---------- */
header("Location: {$after}?img=updated");
exit();
