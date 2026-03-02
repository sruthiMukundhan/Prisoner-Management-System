<?php
require_once SRC_PATH . "/views/layouts/header_unified.php";
require_once SRC_PATH . "/includes/database/dbh.inc.php";

if (!$auth->isLoggedIn() || !$auth->hasRole('admin')) {
    redirect('home');
    exit;
}
$stmt = $pdo->query("
SELECT Visit_id, Prisoner_id, Date, Status
FROM Visit
");
$visits = $stmt->fetchAll();
?>

<div class="p-10">

<h2 class="text-2xl font-bold mb-6">Visitor Pass Management</h2>

<div class="bg-white rounded-xl shadow overflow-hidden">

<table class="min-w-full">

<thead class="bg-gray-100">
<tr>
<th class="p-4 text-left">Prisoner ID</th>
<th class="p-4 text-left">Date</th>
<th class="p-4 text-left">Status</th>
<th class="p-4 text-left">Action</th>
</tr>
</thead>

<tbody>

<?php foreach($visits as $row): ?>
<tr class="border-b hover:bg-gray-50">

<td class="p-4"><?= $row['Prisoner_id'] ?></td>
<td class="p-4"><?= $row['Visit_date'] ?></td>

<td class="p-4">
<span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">
Approved
</span>
</td>

<td class="p-4">
<a href="?page=delete_visit&id=<?= $row['Visit_id'] ?>"
   onclick="return confirm('Delete this visit?')"
   class="bg-red-500 text-white px-3 py-1 rounded">
   Delete
</a>
</td>

</tr>
<?php endforeach; ?>

<?php if(empty($visits)): ?>
<tr>
<td colspan="4" class="p-6 text-center text-gray-500">
No approved visitor passes yet.
</td>
</tr>
<?php endif; ?>

</tbody>
</table>

</div>
</div>

<?php require_once SRC_PATH . "/views/layouts/footer.php"; ?>