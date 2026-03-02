<?php
require_once SRC_PATH.'/includes/database/dbh.inc.php';
require_once SRC_PATH.'/views/layouts/header_unified.php';

$date = date('Y-m-d');

/* ONLY APPROVED */
$stmt = $pdo->prepare("
    SELECT d.Meal_type, f.Food_name, f.Category, f.Calories
    FROM Daily_Menu d
    JOIN Food_Items f ON d.Food_id = f.Food_id
    WHERE d.Menu_date = ?
    AND d.Approved = 1
    ORDER BY FIELD(d.Meal_type,'Breakfast','Lunch','Dinner')
");
$stmt->execute([$date]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$grouped = [];
foreach ($rows as $r) {
    $grouped[$r['Meal_type']][] = $r;
}
?>

<div class="container mx-auto px-6 py-8">

<h1 class="text-2xl font-bold mb-6">
Today's Approved Menu 🍽️
</h1>

<?php if(empty($grouped)): ?>
<div class="bg-yellow-100 text-yellow-800 p-4 rounded">
No approved meals for today.
</div>
<?php else: ?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

<?php foreach ($grouped as $meal => $foods): ?>
<div class="bg-white shadow rounded-lg p-6">
<h2 class="text-xl font-bold mb-4 border-b pb-2">
<?= $meal ?>
</h2>

<ul class="space-y-2">
<?php foreach ($foods as $food): ?>
<li class="flex justify-between">
<span><?= $food['Food_name'] ?></span>
<span class="text-sm text-gray-500">
<?= $food['Category'] ?> | <?= $food['Calories'] ?> kcal
</span>
</li>
<?php endforeach; ?>
</ul>

</div>
<?php endforeach; ?>

</div>
<?php endif; ?>

</div>

<?php require_once SRC_PATH.'/views/layouts/footer.php'; ?>