<?php
require_once SRC_PATH . "/includes/database/dbh.inc.php";
require_once SRC_PATH . "/includes/auth/Auth.php";

$auth = new Auth($pdo);

// Admin check
if (!$auth->isLoggedIn() || !$auth->hasRole('officer')) {
    redirect('home');
    exit;
}

if (!isset($_POST['prisoner_add'])) {
    redirect('?page=prisoner');
    exit;
}

/* =====================
   GET DATA
===================== */
$name   = trim($_POST['prisoner_name']);
$age    = $_POST['age'];
$gender = $_POST['gender'];
$crime  = $_POST['crime_id'];
$ipc    = $_POST['ipc_id'];
$years  = $_POST['sentence_years'] ?? 0;
$risk   = $_POST['risk_level'];

/* =====================
   VALIDATION
===================== */
if (!$name || !$age || !$gender || !$crime || !$ipc || !$risk) {
    redirect('?page=prisoner&error=emptyfields');
    exit;
}

/* =====================
   INSERT
===================== */
try {
   $stmt = $pdo->prepare("
    INSERT INTO prisoner 
    (First_name, Last_name, Date_in, Dob, Height, Weight, date_out, Address, Section_id, Status_in)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->execute([...]);

/* =======================
   AUTO CREATE LOGIN
======================= */

// 1️⃣ Get newly created Prisoner ID
$prisonerId = $pdo->lastInsertId();

// 2️⃣ Create username & password
$username = 'prisoner' . $prisonerId;
$plainPassword = 'prisoner' . $prisonerId;

// 3️⃣ Hash password
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

// 4️⃣ Update prisoner with login credentials
$loginStmt = $pdo->prepare("
    UPDATE prisoner
    SET username = ?, password = ?
    WHERE Prisoner_id = ?
");
$loginStmt->execute([$username, $hashedPassword, $prisonerId]);


    redirect('?page=prisoner_view&insert=success');

} catch (PDOException $e) {
    redirect('?page=prisoner&error=sqlerror');
}
