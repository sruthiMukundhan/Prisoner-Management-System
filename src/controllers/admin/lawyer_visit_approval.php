<?php
require_once SRC_PATH . "/includes/database/dbh.inc.php";
require_once SRC_PATH . "/includes/auth/Auth.php";

global $pdo;
$auth = new Auth($pdo);

/* AUTH CHECK */
if (!$auth->isLoggedIn() || !$auth->hasRole('admin')) {
    redirect('signin-admin');
    exit;
}

/* HANDLE APPROVE */
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);

    $stmt = $pdo->prepare("
        UPDATE lawyer_visit_request
        SET Admin_status='Approved'
        WHERE Request_id=?
    ");
    $stmt->execute([$id]);

    header("Location: ?page=lawyer-visit-approval");
    exit;
}

/* HANDLE REJECT */
if (isset($_GET['reject'])) {
    $id = intval($_GET['reject']);

    $stmt = $pdo->prepare("
        UPDATE lawyer_visit_request
        SET Admin_status='Rejected'
        WHERE Request_id=?
    ");
    $stmt->execute([$id]);

    header("Location: ?page=lawyer-visit-approval");
    exit;
}

/* FETCH DATA */
$stmt = $pdo->query("
    SELECT 
        lvr.Request_id,
        p.First_name AS prisoner_fname,
        p.Last_name AS prisoner_lname,
        l.Lawyer_uname,
        lvr.Visit_date,
        lvr.Officer_status,
        lvr.Admin_status
    FROM lawyer_visit_request lvr
    LEFT JOIN prisoner p 
        ON p.Prisoner_id = lvr.Prisoner_id
    LEFT JOIN lawyer l 
        ON l.Lawyer_id = lvr.Lawyer_id
    ORDER BY lvr.Visit_date DESC
");

$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once SRC_PATH . "/views/layouts/header_unified.php";
?>

<h2 class="text-2xl font-bold mb-6">Lawyer Visit Approvals</h2>

<div class="bg-white shadow rounded p-6">
<table class="min-w-full text-sm">

<thead class="bg-gray-100">
<tr>
<th class="p-3 text-left">Prisoner</th>
<th class="p-3 text-left">Lawyer</th>
<th class="p-3 text-left">Visit Date</th>
<th class="p-3 text-left">Officer Status</th>
<th class="p-3 text-left">Admin Status</th>
<th class="p-3 text-left">Action</th>
</tr>
</thead>

<tbody>

<?php foreach($requests as $row): ?>
<tr class="border-b">

<td class="p-3">
<?= htmlspecialchars($row['prisoner_fname'].' '.$row['prisoner_lname']) ?>
</td>

<td class="p-3">
<?= htmlspecialchars($row['Lawyer_uname']) ?>
</td>

<td class="p-3">
<?= htmlspecialchars($row['Visit_date']) ?>
</td>

<td class="p-3">
<span class="px-3 py-1 rounded-full text-xs
<?= $row['Officer_status']=='Approved' ? 'bg-green-600 text-white' :
   ($row['Officer_status']=='Rejected' ? 'bg-red-600 text-white' :
   'bg-yellow-500 text-white') ?>">
<?= $row['Officer_status'] ?>
</span>
</td>

<td class="p-3">
<span class="px-3 py-1 rounded-full text-xs
<?= $row['Admin_status']=='Approved' ? 'bg-green-600 text-white' :
   ($row['Admin_status']=='Rejected' ? 'bg-red-600 text-white' :
   'bg-yellow-500 text-white') ?>">
<?= $row['Admin_status'] ?>
</span>
</td>

<td class="p-3">

<?php if($row['Officer_status']=='Approved' && $row['Admin_status']=='Pending'): ?>

    <a href="?page=lawyer-visit-approval&approve=<?= $row['Request_id'] ?>"
       class="bg-green-600 text-white px-3 py-1 rounded text-sm">
       Approve
    </a>

    <a href="?page=lawyer-visit-approval&reject=<?= $row['Request_id'] ?>"
       class="bg-red-600 text-white px-3 py-1 rounded text-sm ml-2">
       Reject
    </a>

<?php else: ?>
    -
<?php endif; ?>

</td>

</tr>
<?php endforeach; ?>

</tbody>
</table>
</div>

<?php require_once SRC_PATH . "/views/layouts/footer.php"; ?>