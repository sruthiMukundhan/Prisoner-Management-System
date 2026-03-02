<?php
require_once SRC_PATH . "/includes/database/dbh.inc.php";
require_once SRC_PATH . "/includes/auth/Auth.php";

global $pdo;
$auth = new Auth($pdo);

if (!$auth->isLoggedIn() || !$auth->hasRole('admin')) {
    header("Location: ?page=home");
    exit;
}

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $aadhaar = $_GET['id'];

    $stmt = $pdo->prepare("
        DELETE FROM visitor
        WHERE Aadhaar = ?
    ");

    $stmt->execute([$aadhaar]);
}

header("Location: ?page=visitors");
exit;