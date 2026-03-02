<?php
require_once SRC_PATH . "/includes/database/dbh.inc.php";
require_once SRC_PATH . "/includes/auth/Auth.php";
require_once SRC_PATH . "/views/layouts/header_unified.php";

global $pdo;
$auth = new Auth($pdo);

if (!$auth->isLoggedIn() || !$auth->hasRole('admin')) {
    redirect('home');
    exit;
}

$stmt = $pdo->query("
    SELECT *
    FROM visitor
    ORDER BY Created_date DESC
");

$visitors = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 class="text-2xl font-bold mb-6">All Visitors</h2>

<div class="bg-white shadow rounded p-6">

<table class="min-w-full text-sm">

<thead class="bg-gray-100">
<tr>
<th class="p-3 text-left">Name</th>
<th class="p-3 text-left">Phone</th>
<th class="p-3 text-left">Relationship</th>
<th class="p-3 text-left">Status</th>
<th class="p-3 text-left">Action</th>
</tr>
</thead>

<tbody>

<?php foreach($visitors as $v): ?>
<tr class="border-b hover:bg-gray-50">

<td class="p-3 font-semibold">
<?= htmlspecialchars($v['First_name'].' '.$v['Last_name']) ?>
</td>

<td class="p-3"><?= htmlspecialchars($v['Phone']) ?></td>

<td class="p-3"><?= htmlspecialchars($v['Relationship_with_prisoner']) ?></td>

<td class="p-3">
<?php if($v['Status'] === 'Approved'): ?>
<span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">Approved</span>
<?php else: ?>
<span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs">Pending</span>
<?php endif; ?>
</td>

<td class="p-3">
<?php if($v['Status'] === 'Pending'): ?>
<a href="?page=approve-visitor&id=<?= $v['Aadhaar'] ?>"
class="bg-green-600 text-white px-3 py-1 rounded text-xs">
Approve
</a>
<?php endif; ?>
</td>

</tr>
<?php endforeach; ?>

</tbody>
</table>
</div>

<?php require_once SRC_PATH . "/views/layouts/footer.php"; ?>