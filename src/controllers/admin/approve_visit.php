<?php
require_once SRC_PATH . "/includes/database/dbh.inc.php";

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("
        UPDATE visitor
        SET Status = 'Approved'
        WHERE Aadhaar = ?
    ");
    $stmt->execute([$_GET['id']]);
}

header("Location: ?page=visitors");
exit;