<?php require SRC_PATH . "/views/layouts/header_unified.php"; ?>

<div class="p-10">

<h2 class="text-2xl font-bold mb-6">My Visits</h2>

<table class="min-w-full bg-white shadow rounded">
<thead>
<tr>
<th class="p-3 text-left">Prisoner</th>
<th class="p-3 text-left">Visit Date</th>
<th class="p-3 text-left">Status</th>
</tr>
</thead>

<tbody>

<?php foreach($approvedVisits as $v): ?>
<tr class="border-b">

<td class="p-3"><?= htmlspecialchars($v['Full_Name']) ?></td>
<td class="p-3"><?= $v['Visit_date'] ?></td>

<td class="p-3">
<?php
$today = date('Y-m-d');

if ($v['Visit_date'] < $today) {
    echo '<span class="bg-red-600 text-white px-3 py-1 rounded">Expired</span>';
} elseif ($v['Officer_status']=='Approved' && $v['Admin_status']=='Approved') {
    echo '<span class="bg-green-600 text-white px-3 py-1 rounded">Confirmed</span>';
} elseif ($v['Officer_status']=='Approved') {
    echo '<span class="bg-yellow-500 text-white px-3 py-1 rounded">Waiting Admin</span>';
} else {
    echo '<span class="bg-gray-400 text-white px-3 py-1 rounded">Pending Officer</span>';
}
?>
</td>

</tr>
<?php endforeach; ?>

<?php if(empty($approvedVisits)): ?>
<tr>
<td colspan="3" class="p-3 text-gray-500">
No visits yet.
</td>
</tr>
<?php endif; ?>

</tbody>
</table>

</div>

<?php require SRC_PATH . "/views/layouts/footer.php"; ?>