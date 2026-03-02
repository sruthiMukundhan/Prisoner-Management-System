<?php
require_once SRC_PATH . '/includes/init.php';

global $pdo, $auth;

if (!$auth->isLoggedIn() || !$auth->hasRole('admin')) {
    redirect('home');
    exit;
}

if (!isset($_GET['id'])) {
    redirect('ai_lunch');
    exit;
}

$id = intval($_GET['id']);

$stmt = $pdo->prepare("
    UPDATE Daily_Menu
    SET Approved = 1
    WHERE Menu_id = ?
");
$stmt->execute([$id]);

redirect('ai_lunch&approved=1');
exit;