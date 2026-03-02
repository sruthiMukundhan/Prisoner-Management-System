<?php require SRC_PATH . "/views/layouts/header_unified.php"; ?>

<div class="min-h-screen bg-gray-50 py-10 px-6">

<h1 class="text-3xl font-bold mb-8">My Assigned Prisoners</h1>

<?php if (empty($prisoners)): ?>
    <div class="bg-yellow-100 text-yellow-800 p-4 rounded">
        No prisoners assigned yet.
    </div>
<?php else: ?>

<div class="bg-white shadow rounded-lg overflow-hidden">
<table class="min-w-full">
<thead class="bg-gray-200">
<tr>
<th class="p-3 text-left">Name</th>
<th class="p-3 text-left">Section</th>
<th class="p-3 text-left">Crime</th>
<th class="p-3 text-left">Risk Level</th>
</tr>
</thead>
<tbody>

<?php foreach ($prisoners as $p): ?>
<tr class="border-b">
<td class="p-3"><?= htmlspecialchars($p['Full_Name']) ?></td>
<td class="p-3"><?= htmlspecialchars($p['Section_name']) ?></td>
<td class="p-3"><?= htmlspecialchars($p['Crime_category']) ?></td>
<td class="p-3"><?= htmlspecialchars($p['Risk_level']) ?></td>
</tr>
<?php endforeach; ?>

</tbody>
</table>
</div>

<?php endif; ?>

</div>

<?php require SRC_PATH . "/views/layouts/footer.php"; ?>