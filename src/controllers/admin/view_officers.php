<?php
require_once SRC_PATH . '/includes/database/dbh.inc.php';
require_once SRC_PATH . '/views/layouts/header_unified.php';

$stmt = $pdo->query("SELECT * FROM Officer ORDER BY Officer_id DESC");
$officers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto px-6 py-8">

<h1 class="text-2xl font-bold mb-6">Officers List</h1>

<div class="bg-white shadow rounded-lg overflow-hidden">
<table class="min-w-full">

<thead class="bg-gray-100">
<tr>
<th class="p-3 text-left">ID</th>
<th class="p-3 text-left">Name</th>
<th class="p-3 text-left">Title</th>
<th class="p-3 text-left">DOB</th>
</tr>
</thead>

<tbody>

<?php foreach($officers as $o): ?>
<tr class="border-b">
<td class="p-3"><?= $o['Officer_id'] ?></td>
<td class="p-3"><?= $o['First_name'].' '.$o['Last_name'] ?></td>
<td class="p-3"><?= $o['Title'] ?></td>
<td class="p-3"><?= $o['Date_of_birth'] ?></td>
</tr>
<?php endforeach; ?>

</tbody>
</table>
</div>

</div>

<?php require_once SRC_PATH . '/views/layouts/footer.php'; ?>