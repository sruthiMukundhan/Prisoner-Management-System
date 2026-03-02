<?php
require_once SRC_PATH . "/includes/database/dbh.inc.php";
require_once SRC_PATH . "/includes/auth/Auth.php";

global $pdo;
$auth = new Auth($pdo);

if (!$auth->isLoggedIn() || !$auth->hasRole('officer')) {
    header("Location: ?page=home");
    exit;
}

if (isset($_GET['id'])) {

    $stmt = $pdo->prepare("
        UPDATE visitor
        SET Officer_Status = 'Approved'
        WHERE Aadhaar = ?
    ");

    $stmt->execute([$_GET['id']]);
}

header("Location: ?page=officer-visitor-visits");
exit;