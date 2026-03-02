<?php
require_once SRC_PATH . "/includes/database/dbh.inc.php";
require_once SRC_PATH . "/includes/auth/Auth.php";

$auth = new Auth($pdo);

if (!$auth->isLoggedIn() || !$auth->hasRole('admin')) {
    redirect('home');
    exit;
}

$prisoner_id = $_POST['prisoner_id'];
$officer_id  = $_POST['officer_id'];

if (!$prisoner_id || !$officer_id) {
    redirect('?page=prisoner_view');
    exit;
}

/* =====================
   CALCULATE PRIORITY
===================== */
$pstmt = $pdo->prepare("SELECT risk_level FROM prisoner WHERE prisoner_id = ?");
$pstmt->execute([$prisoner_id]);
$prisoner = $pstmt->fetch();

$priority = 1;
if ($prisoner['risk_level'] === 'HIGH') $priority += 2;
if ($prisoner['risk_level'] === 'MEDIUM') $priority += 1;

try {
    $pdo->beginTransaction();

    // Deactivate old mapping
    $pdo->prepare("
        UPDATE prisoner_lawyer_map
        SET status = 'INACTIVE'
        WHERE prisoner_id = ?
    ")->execute([$prisoner_id]);

    // Insert new mapping
    $stmt = $pdo->prepare("
        INSERT INTO prisoner_lawyer_map
        (prisoner_id, officer_id, priority, assigned_by)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $prisoner_id,
        $officer_id,
        $priority,
        $_SESSION['user_id']
    ]);

    $pdo->commit();

    redirect('?page=prisoner_view&mapped=success');

} catch (PDOException $e) {
    $pdo->rollBack();
    redirect('?page=prisoner_view&error=sqlerror');
}
