<?php
require_once SRC_PATH . "/includes/database/dbh.inc.php";
require_once SRC_PATH . "/includes/auth/Auth.php";

$auth = new Auth($pdo);

// Admin auth
if (!$auth->isLoggedIn() || !$auth->hasRole('admin')) {
    redirect('home');
    exit;
}

// Only POST
if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['add_visitor'])) {
    redirect('visitor');
    exit;
}

/* =======================
   VALIDATION
======================= */
$f_name = trim($_POST['f_name']);
$l_name = trim($_POST['l_name']);
$aadhaar = trim($_POST['aadhaar']);
$date_visit = $_POST['date_visit'];
$time_slot = $_POST['time_slot'];
$prisoner_id = (int) $_POST['prisoner_id'];

if (!preg_match('/^[0-9]{12}$/', $aadhaar)) {
    die("Invalid Aadhaar number");
}

if (empty($time_slot) || empty($prisoner_id)) {
    die("Invalid input");
}

/* =======================
   INSERT VISITOR
======================= */
$stmt = $pdo->prepare("
    INSERT INTO visitor
    (f_name, l_name, aadhaar, date_visit, time_slot, prisoner_id)
    VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $f_name,
    $l_name,
    $aadhaar,
    $date_visit,
    $time_slot,
    $prisoner_id
]);

redirect('admin');
exit;
