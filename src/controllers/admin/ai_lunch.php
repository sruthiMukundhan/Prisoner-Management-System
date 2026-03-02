v  <?php
require_once SRC_PATH.'/includes/database/dbh.inc.php';
require_once SRC_PATH.'/views/layouts/header_unified.php';

$date = date('Y-m-d');

/* Fetch ALL today menu (pending + approved) */
$stmt = $pdo->prepare("
    SELECT d.Menu_id, d.Meal_type, f.Food_name, f.Category, f.Calories, d.Approved
    FROM Daily_Menu d
    JOIN Food_Items f ON d.Food_id = f.Food_id
    WHERE d.Menu_date = ?
    ORDER BY FIELD(d.Meal_type,'Breakfast','Lunch','Dinner')
");
$stmt->execute([$date]);
$menu = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto px-6 py-8">

<h1 class="text-2xl font-bold mb-6">Add Lunch Menu (AI Control)</h1>

<?php if(isset($_GET['generated'])): ?>
<div class="bg-blue-500 text-white p-3 rounded mb-4">
AI Menu Generated Successfully ✅
</div>
<?php endif; ?>

<?php if(isset($_GET['approved'])): ?>
<div class="bg-green-500 text-white p-3 rounded mb-4">
Food Approved Successfully ✅
</div>
<?php endif; ?>

<a href="?page=generate_menu"
   class="bg-indigo-600 text-white px-4 py-2 rounded mb-6 inline-block">
   Generate AI Menu
</a>

<table class="min-w-full bg-white shadow rounded-lg">

<thead class="bg-gray-100">
<tr>
<th class="p-3">Meal</th>
<th class="p-3">Food</th>
<th class="p-3">Category</th>
<th class="p-3">Calories</th>
<th class="p-3">Status</th>
<th class="p-3">Action</th>
</tr>
</thead>

<tbody>

<?php foreach($menu as $m): ?>
<tr class="border-b">
<td class="p-3"><?= $m['Meal_type'] ?></td>
<td class="p-3"><?= $m['Food_name'] ?></td>
<td class="p-3"><?= $m['Category'] ?></td>
<td class="p-3"><?= $m['Calories'] ?> kcal</td>

<td class="p-3">
<?php if($m['Approved']): ?>
<span class="bg-green-500 text-white px-3 py-1 rounded">Approved</span>
<?php else: ?>
<span class="bg-yellow-500 text-white px-3 py-1 rounded">Pending</span>
<?php endif; ?>
</td>

<td class="p-3">
<?php if(!$m['Approved']): ?>
<a href="?page=approve_food&id=<?= $m['Menu_id'] ?>"
   class="bg-green-500 text-white px-3 py-1 rounded">
   Approve
</a>
<?php endif; ?>
</td>
</tr>
<?php endforeach; ?>

</tbody>
</table>

</div>

<?php require_once SRC_PATH.'/views/layouts/footer.php'; ?>