<?php
require_once SRC_PATH . "/views/layouts/header_unified.php";
require_once SRC_PATH . "/includes/init.php";
global $pdo;

if (!isset($_SESSION['userUidOfficer'])) {
    redirect('home');
    exit;
}

/* =====================================
   AUTO UPDATE STATUS BASED ON DATE
===================================== */
$pdo->query("
    UPDATE prisoner
    SET Status_inout =
        CASE
            WHEN date_out < CURDATE() THEN 'out'
            ELSE 'in'
        END
");

/* =====================================
   HANDLE UPDATE / KEEP
===================================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $prisoner_id = $_POST['prisoner_id'];

    /* UPDATE DATE */
    if (isset($_POST['update_date'])) {

        $new_date = $_POST['new_date'];

        $stmt = $pdo->prepare("
            UPDATE prisoner
            SET date_out = ?,
                Updated_date = CURDATE()
            WHERE Prisoner_id = ?
        ");
        $stmt->execute([$new_date, $prisoner_id]);
    }

    /* KEEP SAME */
    if (isset($_POST['keep_date'])) {

        $stmt = $pdo->prepare("
            UPDATE prisoner
            SET Updated_date = CURDATE()
            WHERE Prisoner_id = ?
        ");
        $stmt->execute([$prisoner_id]);
    }

    redirect('prisoner-dateout');
    exit;
}

/* =====================================
   FETCH DATA ASCENDING ORDER
===================================== */
$stmt = $pdo->query("
    SELECT 
        Prisoner_id,
        CONCAT(First_name, ' ', Last_name) AS Full_Name,
        date_out,
        Updated_date,
        Status_inout
    FROM prisoner
    ORDER BY Prisoner_id ASC
");

$prisoners = $stmt->fetchAll();
?>

<div class="content-wrapper">

    <h1 class="page-title">Update Prisoner Out Date</h1>

    <div class="card-table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Current Date Out</th>
                    <th>Status</th>
                    <th>Updated On</th>
                    <th>Change Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($prisoners as $p): ?>
                    <tr>
                        <form method="POST">

                            <td><?= $p['Prisoner_id'] ?></td>

                            <td><?= htmlspecialchars($p['Full_Name']) ?></td>

                            <td><?= $p['date_out'] ?></td>

                            <td>
                                <?php if ($p['Status_inout'] === 'out'): ?>
                                    <span class="status-out">OUT</span>
                                <?php else: ?>
                                    <span class="status-in">IN</span>
                                <?php endif; ?>
                            </td>

                            <td><?= $p['Updated_date'] ?? '-' ?></td>

                            <td>
                                <input 
                                    type="date" 
                                    name="new_date" 
                                    value="<?= $p['date_out'] ?>" 
                                    required
                                >
                                <input type="hidden" 
                                       name="prisoner_id" 
                                       value="<?= $p['Prisoner_id'] ?>">
                            </td>

                            <td>
                                <button type="submit" 
                                        name="update_date" 
                                        class="btn-update">
                                    Update
                                </button>

                                <button type="submit" 
                                        name="keep_date" 
                                        class="btn-keep">
                                    Keep
                                </button>
                            </td>

                        </form>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<style>
.content-wrapper {
    padding: 30px;
}

.page-title {
    margin-bottom: 20px;
    font-weight: 600;
}

.card-table {
    background: rgba(255,255,255,0.95);
    border-radius: 18px;
    padding: 25px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.08);
    backdrop-filter: blur(6px);
}

.card-table table {
    width: 100%;
    border-collapse: collapse;
}

.card-table th {
    background: #f4f6f9;
    padding: 14px;
    text-align: left;
    font-weight: 600;
}

.card-table td {
    padding: 14px;
    border-top: 1px solid #eee;
}

.btn-update {
    background: #28a745;
    color: white;
    border: none;
    padding: 6px 14px;
    border-radius: 8px;
    cursor: pointer;
}

.btn-update:hover {
    background: #218838;
}

.btn-keep {
    background: #6c757d;
    color: white;
    border: none;
    padding: 6px 14px;
    border-radius: 8px;
    margin-left: 5px;
    cursor: pointer;
}

.btn-keep:hover {
    background: #5a6268;
}

.status-in {
    background: #d1fae5;
    color: #065f46;
    padding: 6px 14px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 13px;
}

.status-out {
    background: #fee2e2;
    color: #991b1b;
    padding: 6px 14px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 13px;
}
</style>