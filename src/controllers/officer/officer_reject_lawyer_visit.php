<?php
require_once SRC_PATH . '/includes/database/dbh.inc.php';
require_once SRC_PATH . '/includes/auth/Auth.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

    $id = (int) $_POST['id'];
    $reason = trim($_POST['reason']);

    $stmt = $pdo->prepare("
        UPDATE Lawyer_Visit_Request
        SET Officer_status = 'Rejected',
            Officer_reject_reason = ?
        WHERE Request_id = ?
    ");

    $stmt->execute([$reason, $id]);

    header("Location: index.php?page=officer-lawyer-visits");
    exit;
}