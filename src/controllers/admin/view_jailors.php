<?php
require_once SRC_PATH . '/includes/database/dbh.inc.php';
require_once SRC_PATH . '/views/layouts/header_unified.php';

$stmt = $pdo->query("SELECT * FROM Jailor ORDER BY Jailor_id DESC");
$jailors = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto px-6 py-8">

<h1 class="text-2xl font-bold mb-6">Jailors List</h1>

<div class="bg-white shadow rounded-lg overflow-hidden">
<table class="min-w-full">

<thead class="bg-gray-100">
<tr>
<th class="p-3 text-left">ID</th>
<th class="p-3 text-left">Name</th>
<th class="p-3 text-left">Email</th>
<th class="p-3 text-left">Hire Date</th>
</tr>
</thead>

<tbody>

<?php foreach($jailors as $j): ?>
<tr class="border-b">
<td class="p-3"><?= $j['Jailor_id'] ?></td>
<td class="p-3"><?= $j['First_name'].' '.$j['Last_name'] ?></td>
<td class="p-3"><?= $j['Email'] ?></td>
<td class="p-3"><?= $j['Hire_date'] ?></td>
</tr>
<?php endforeach; ?>

</tbody>
</table>
</div>

</div>

<?php require_once SRC_PATH . '/views/layouts/footer.php'; ?>