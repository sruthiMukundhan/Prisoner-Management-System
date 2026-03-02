<?php require SRC_PATH . "/views/layouts/header_unified.php"; ?>

<div class="p-10">

<h2 class="text-2xl font-bold mb-6">Request Prison Visit</h2>

<?php if(isset($_GET['requested'])): ?>
<div class="bg-green-500 text-white p-3 rounded mb-4">
Visit Requested Successfully
</div>
<?php endif; ?>

<!-- ======================
     REQUEST FORM
====================== -->

<form method="POST" class="space-y-4 mb-10">

<select name="prisoner_id" class="border p-2 w-full rounded" required>
<option value="">-- Select Assigned Prisoner --</option>

<?php if(!empty($prisoners)): ?>
<?php foreach($prisoners as $p): ?>
<option value="<?= $p['Prisoner_id'] ?>">
<?= htmlspecialchars($p['Full_Name']) ?>
</option>
<?php endforeach; ?>
<?php else: ?>
<option disabled>No assigned prisoners</option>
<?php endif; ?>

</select>

<input type="date" name="visit_date" class="border p-2 w-full rounded" required>

<button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded">
Request Visit
</button>

</form>

<!-- ======================
     ALL REQUESTS
====================== -->

<h3 class="text-xl font-semibold mb-4">All Requests</h3>

<div class="bg-white shadow rounded overflow-hidden">

<table class="min-w-full">

<thead class="bg-gray-100">
<tr>
<th class="p-4 text-left">Prisoner</th>
<th class="p-4 text-left">Visit Date</th>
<th class="p-4 text-left">Status</th>
<th class="p-4 text-left">Action</th>
</tr>
</thead>

<tbody>

<?php if(!empty($visits)): ?>
<?php foreach($visits as $v): ?>

<tr class="border-b hover:bg-gray-50">

<td class="p-4">
<?= htmlspecialchars($v['Full_Name']) ?>
</td>

<td class="p-4">
<?= htmlspecialchars($v['Visit_date']) ?>
</td>

<td class="p-4">
<?php

if ($v['Officer_status'] == 'Rejected' || $v['Admin_status'] == 'Rejected') {
    echo "<span class='text-red-600 font-semibold'>Rejected</span>";
}
elseif ($v['Officer_status'] == 'Pending') {
    echo "<span class='text-yellow-600 font-semibold'>Waiting for Officer</span>";
}
elseif ($v['Officer_status'] == 'Approved' && $v['Admin_status'] == 'Pending') {
    echo "<span class='text-orange-500 font-semibold'>Waiting for Admin</span>";
}
elseif ($v['Officer_status'] == 'Approved' && $v['Admin_status'] == 'Approved') {
    echo "<span class='text-green-600 font-semibold'>Approved</span>";
}

?>
</td>

<td class="p-4">
<?php if($v['Officer_status']=='Pending' && $v['Admin_status']=='Pending'): ?>

<form method="POST" action="?page=cancel-lawyer-visit">
<input type="hidden" name="id" value="<?= $v['Request_id'] ?>">

<button class="text-red-600 hover:underline">
Delete
</button>
</form>

<?php else: ?>
-
<?php endif; ?>
</td>

</tr>

<?php endforeach; ?>
<?php else: ?>

<tr>
<td colspan="4" class="p-6 text-center text-gray-500">
No visit requests yet.
</td>
</tr>

<?php endif; ?>

</tbody>
</table>

</div>

</div>

<?php require SRC_PATH . "/views/layouts/footer.php"; ?>