<?php
require_once SRC_PATH . '/includes/database/dbh.inc.php';

if (!isset($_GET['id'])) {
    header("Location: ?page=visitor_pass");
    exit;
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM Visit WHERE Visit_id = ?");
$stmt->execute([$id]);

header("Location: ?page=visitor_pass&deleted=1");
exit;