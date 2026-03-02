<?php
require_once SRC_PATH . '/includes/database/dbh.inc.php';

if (isset($_GET['id'])) {

    $id = (int) $_GET['id'];

    $stmt = $pdo->prepare("
        UPDATE Lawyer_Visit_Request
        SET Officer_status = 'Approved'
        WHERE Request_id = ?
    ");

    $stmt->execute([$id]);

    header("Location: index.php?page=officer-lawyer-visits");
    exit;
}