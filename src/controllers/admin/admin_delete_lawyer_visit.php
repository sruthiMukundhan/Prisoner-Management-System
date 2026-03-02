<?php
require_once SRC_PATH . "/includes/database/dbh.inc.php";
require_once SRC_PATH . "/includes/auth/Auth.php";

global $pdo;
$auth = new Auth($pdo);

if (!$auth->isLoggedIn() || !$auth->hasRole('admin')) {
    header("Location: ?page=home");
    exit;
}

if (isset($_GET['id'])) {

    $stmt = $pdo->prepare("
        DELETE FROM Lawyer_Visit_Request
        WHERE Request_id = ?
    ");

    $stmt->execute([$_GET['id']]);
}

header("Location: ?page=lawyer-visit-approval");
exit;