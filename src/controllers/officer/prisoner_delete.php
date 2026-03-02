<?php
require_once SRC_PATH . "/includes/init.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'] ?? null;

    if ($id) {

        // If mapping tables exist, delete them first
        $stmt1 = db()->prepare("DELETE FROM Commits WHERE Prisoner_id = ?");
        $stmt1->execute([$id]);

        $stmt2 = db()->prepare("DELETE FROM Prisoner WHERE Prisoner_id = ?");
        $stmt2->execute([$id]);
    }

    redirect('prisoner-view&deleted=1');
    exit;
}