<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once SRC_PATH . '/includes/database/dbh.inc.php';
require_once SRC_PATH . '/includes/auth/Auth.php';

global $pdo;

$auth = new Auth($pdo);
$currentUser = $auth->getCurrentUser();

$notificationCount = 0;
$notificationLink = "#";

/* ------------------ NOTIFICATION LOGIC ------------------ */

if ($currentUser && $currentUser['type'] === 'officer') {
    $notificationCount = $pdo->query("
        SELECT COUNT(*) FROM Lawyer_Visit_Request
        WHERE Officer_status='Pending'
    ")->fetchColumn();
    $notificationLink = "?page=officer-lawyer-visits";
}

if ($currentUser && $currentUser['type'] === 'admin') {
    $notificationCount = $pdo->query("
        SELECT COUNT(*) FROM Lawyer_Visit_Request
        WHERE Officer_status='Approved'
        AND Admin_status='Pending'
    ")->fetchColumn();
    $notificationLink = "?page=lawyer-visit-approval";
}

if ($currentUser && $currentUser['type'] === 'lawyer' && isset($_SESSION['userUidLawyer'])) {
    $stmt = $pdo->prepare("
        SELECT COUNT(*) FROM Lawyer_Visit_Request lvr
        JOIN Lawyer l ON lvr.Lawyer_id = l.Lawyer_id
        WHERE l.Lawyer_uname = ?
        AND Officer_status='Approved'
        AND Admin_status='Approved'
    ");
    $stmt->execute([$_SESSION['userUidLawyer']]);
    $notificationCount = $stmt->fetchColumn();
    $notificationLink = "?page=my-visits";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>PMS</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r121/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.net.min.js"></script>

<style>
.badge {
    position: absolute;
    top: -6px;
    right: -10px;
}
</style>

</head>

<body>
<div id="vanta-bg" class="min-h-screen flex flex-col">
<main class="flex-grow">


<!-- HEADER -->
<header class="bg-white bg-opacity-80 backdrop-blur-md shadow-md border-b border-gray-200">

<div class="max-w-7xl mx-auto px-8 h-16 flex items-center justify-between">

    <!-- Logo -->
    <a href="?page=home" class="text-2xl font-black text-indigo-700">
        PMS
    </a>

    <!-- Navigation -->
    <div class="flex items-center space-x-8 text-lg font-bold text-gray-800">

        <?php if (!$currentUser): ?>
            <a href="?page=signin-admin" class="hover:text-indigo-600">Admin</a>
            <a href="?page=signin-officer" class="hover:text-indigo-600">Officer</a>
            <a href="?page=signin-lawyer" class="hover:text-indigo-600">Lawyer</a>
            <a href="?page=signin-prisoner" class="hover:text-indigo-600">Prisoner</a>
        <?php endif; ?>

        <?php if ($currentUser): ?>

            <?php if ($currentUser['type'] === 'admin'): ?>
                <a href="?page=admin" class="hover:text-indigo-600">Dashboard</a>
                <a href="?page=visitors" class="hover:text-indigo-600">Visitors</a>
                <a href="?page=approved-lunch" class="hover:text-indigo-600">Lunch</a>
                <a href="?page=lawyer-visit-approval" class="hover:text-indigo-600">Lawyer Visits</a>
            <?php endif; ?>

            <?php if ($currentUser['type'] === 'officer'): ?>
                <a href="?page=officer-dashboard" class="hover:text-indigo-600">Dashboard</a>
                <a href="?page=officer-lawyer-visits" class="hover:text-indigo-600">Lawyer Visits</a>
                <a href="?page=officer-visitor-visits" class="hover:text-indigo-600">Visitor Visits</a>
            <?php endif; ?>

            <?php if ($currentUser['type'] === 'lawyer'): ?>
                <a href="?page=lawyer-dashboard" class="hover:text-indigo-600">Dashboard</a>
                <a href="?page=my-visits" class="hover:text-indigo-600">My Visits</a>
            <?php endif; ?>

            <!-- Notifications -->
            <div class="relative">
                <a href="<?= $notificationLink ?>" class="text-xl hover:text-indigo-600">🔔</a>
                <?php if ($notificationCount > 0): ?>
                    <span class="badge bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">
                        <?= $notificationCount ?>
                    </span>
                <?php endif; ?>
            </div>

            <a href="?page=logout" class="text-red-600 hover:text-red-800">Logout</a>

        <?php endif; ?>

    </div>

</div>
</header>

<!-- MAIN CONTENT -->
<main class="max-w-7xl mx-auto px-8 py-10">

<script>
document.addEventListener("DOMContentLoaded", function () {

    if (document.querySelector("#vanta-bg")) {

        VANTA.NET({
            el: "#vanta-bg",
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            minHeight: 200,
            minWidth: 200,
            scale: 1,
            scaleMobile: 1,
            color: 0x4f46e5,
            backgroundColor: 0xffffff
        });

    }

});
</script>