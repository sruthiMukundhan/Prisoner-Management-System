<?php
require_once SRC_PATH . "/includes/database/dbh.inc.php";
require_once SRC_PATH . "/includes/auth/Auth.php";
require_once SRC_PATH . "/views/layouts/header_unified.php";

global $pdo;

$auth = new Auth($pdo);

/* =======================
   AUTH CHECK (ADMIN ONLY)
======================= */
if (!$auth->isLoggedIn() || !$auth->hasRole('admin')) {
    redirect('home');
    exit;
}

/* =======================
   FETCH APPROVED FOOD
   (Doctor Recommended = 1)
======================= */
$stmt = $pdo->query("
    SELECT 
        f.Food_name,
        f.Category,
        f.Calories
    FROM Daily_Menu d
    JOIN Food_Items f ON d.Food_id = f.Food_id
    WHERE d.Approved = 1
    AND d.Menu_date = CURDATE()
    ORDER BY f.Food_name ASC
");

$foods = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 class="text-2xl font-bold mb-6">Approved Lunch Menu</h2>

<table class="min-w-full bg-white shadow rounded">
<thead>
<tr>
    <th class="p-3 text-left">Food</th>
    <th class="p-3 text-left">Category</th>
    <th class="p-3 text-left">Calories</th>
</tr>
</thead>

<tbody>
<?php foreach($foods as $f): ?>
<tr class="border-b">
    <td class="p-3"><?= htmlspecialchars($f['Food_name']) ?></td>
    <td class="p-3"><?= htmlspecialchars($f['Category']) ?></td>
    <td class="p-3"><?= htmlspecialchars($f['Calories']) ?> kcal</td>
</tr>
<?php endforeach; ?>

<?php if(count($foods) === 0): ?>
<tr>
    <td colspan="3" class="p-4 text-center opacity-70">
        No approved food items found
    </td>
</tr>
<?php endif; ?>
</tbody>
</table>

<?php require_once SRC_PATH . "/views/layouts/footer.php"; ?>