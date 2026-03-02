<?php
require_once SRC_PATH . "/includes/database/dbh.inc.php";
require_once SRC_PATH . "/includes/auth/Auth.php";
require_once SRC_PATH . "/views/layouts/header_unified.php";

global $pdo;
$auth = new Auth($pdo);

if (!$auth->isLoggedIn() || !$auth->hasRole('officer')) {
    redirect('home');
    exit;
}

$stmt = $pdo->query("
    SELECT *
    FROM visitor
    WHERE Status = 'Approved'
    AND Officer_Status = 'Pending'
    ORDER BY Created_date DESC
");

$visits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 class="text-2xl font-bold mb-6">Officer Visitor Approvals</h2>

<div class="bg-white shadow rounded p-6">

<table class="min-w-full text-sm">
<thead class="bg-gray-100">
<tr>
<th class="p-3 text-left">Visitor</th>
<th class="p-3 text-left">Phone</th>
<th class="p-3 text-left">Date</th>
<th class="p-3 text-left">Action</th>
</tr>
</thead>

<tbody>

<?php if(count($visits) > 0): ?>
<?php foreach($visits as $v): ?>
<tr class="border-b hover:bg-gray-50">

<td class="p-3 font-semibold">
<?= htmlspecialchars($v['First_name'].' '.$v['Last_name']) ?>
</td>

<td class="p-3"><?= htmlspecialchars($v['Phone']) ?></td>

<td class="p-3"><?= htmlspecialchars($v['Created_date']) ?></td>

<td class="p-3">
<a href="?page=officer-approve-visitor&id=<?= $v['Aadhaar'] ?>"
class="bg-indigo-600 text-white px-3 py-1 rounded text-xs">
Approve
</a>
</td>

</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
<td colspan="4" class="text-center py-6 text-gray-500">
No pending approvals.
</td>
</tr>
<?php endif; ?>

</tbody>
</table>
</div>

<?php require_once SRC_PATH . "/views/layouts/footer.php"; ?>