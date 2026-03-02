<?php
require_once SRC_PATH . "/includes/database/dbh.inc.php";
require_once SRC_PATH . "/includes/auth/Auth.php";

global $pdo;
$auth = new Auth($pdo);

if (!$auth->isLoggedIn() || !$auth->hasRole('officer')) {
    header("Location: ?page=home");
    exit;
}

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $stmt = $pdo->prepare("
        UPDATE Lawyer_Visit_Request
        SET Officer_status = 'Approved'
        WHERE Request_id = ?
    ");

    $stmt->execute([$_GET['id']]);
}

header("Location: ?page=officer-lawyer-visits");
exit;