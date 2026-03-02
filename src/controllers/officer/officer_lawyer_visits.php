<?php
require_once SRC_PATH . "/views/layouts/header_unified.php";
require_once SRC_PATH . "/includes/database/dbh.inc.php";

if (!$auth->isLoggedIn() || !$auth->hasRole('officer')) {
    redirect('home');
    exit;
}

$stmt = $pdo->query("
    SELECT *
    FROM Lawyer_Visit_Request
    WHERE Officer_status = 'Pending'
    ORDER BY Visit_date DESC
");

$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="p-10">

<h2 class="text-2xl font-bold mb-6">Officer Visit Approvals</h2>

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

<?php foreach($requests as $r): ?>
<tr class="border-b hover:bg-gray-50">

<td class="p-4"><?= $r['Prisoner_id'] ?></td>
<td class="p-4"><?= $r['Visit_date'] ?></td>

<td class="p-4">
<span class="bg-yellow-400 text-white px-3 py-1 rounded-full text-sm">
Pending
</span>
</td>

<td class="p-4 space-x-2">

<a href="?page=officer-approve-lawyer-visit&id=<?= $r['Request_id'] ?>"
   class="bg-green-600 hover:bg-green-700 px-4 py-1 rounded text-white text-sm">
   Approve
</a>

<form method="POST"
      action="?page=officer-reject-lawyer-visit"
      class="inline">

    <input type="hidden"
           name="id"
           value="<?= $r['Request_id'] ?>">

    <button type="submit"
        class="bg-red-500 hover:bg-red-600 px-4 py-1 rounded text-white text-sm">
        Delete
    </button>
</form>

</td>

</tr>
<?php endforeach; ?>

<?php if(empty($requests)): ?>
<tr>
<td colspan="4" class="p-6 text-center text-gray-500">
No pending approvals.
</td>
</tr>
<?php endif; ?>

</tbody>
</table>

</div>
</div>

<?php require_once SRC_PATH . "/views/layouts/footer.php"; ?>