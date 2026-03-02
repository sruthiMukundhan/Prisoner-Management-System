<?php
require_once SRC_PATH . "/includes/init.php";
global $pdo;

$id = $_POST['id'] ?? null;

if ($id) {

    $stmt = $pdo->prepare("
        DELETE FROM Lawyer_Visit_Request
        WHERE Request_id=? AND Officer_status='Pending'
    ");
    $stmt->execute([$id]);
}

header("Location: ?page=lawyer-visit&cancelled=1");
exit;