<?php
require_once SRC_PATH . '/includes/init.php';

global $pdo, $auth;

if (!$auth->isLoggedIn() || !$auth->hasRole('admin')) {
    redirect('home');
    exit;
}

if (!isset($_GET['id'])) {
    redirect('lawyer-map');
    exit;
}

$id = intval($_GET['id']);

$stmt = $pdo->prepare("
    DELETE FROM lawyer_prisoner_map
    WHERE id = ?
");
$stmt->execute([$id]);

redirect('lawyer-map');
exit;