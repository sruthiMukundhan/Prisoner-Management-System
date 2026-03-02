<?php
require_once SRC_PATH . "/includes/init.php";
global $pdo;

if (!isset($_SESSION['userUidOfficer'])) {
    redirect('home');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $ipc_code = $_POST['ipc_code'] ?? null;

    if ($ipc_code) {

        // First remove from commits table
        $pdo->prepare("DELETE FROM commits WHERE IPC = ?")
            ->execute([$ipc_code]);

        // Then remove from ipc_master
        $pdo->prepare("DELETE FROM ipc_master WHERE ipc_code = ?")
            ->execute([$ipc_code]);
    }

    header("Location: ?page=ipc-view&deleted=1");
    exit;
}

echo "<pre>";
print_r($_GET);
print_r($_POST);
echo "</pre>";
exit;