<?php
require_once SRC_PATH . "/views/layouts/header_unified.php";

if (!$auth->isLoggedIn() || !$auth->hasRole('admin')) {
    redirect('home');
    exit;
}

$prisoner_id = $_GET['id'] ?? null;
if (!$prisoner_id) redirect('?page=prisoner_view');

// Fetch prisoner
$pstmt = $pdo->prepare("SELECT * FROM prisoner WHERE prisoner_id = ?");
$pstmt->execute([$prisoner_id]);
$prisoner = $pstmt->fetch();

if (!$prisoner) redirect('?page=prisoner_view');

// Fetch lawyers
$lawyers = $pdo->query("
    SELECT Officer_id, First_name, Last_name, Specialization
    FROM Officer
    WHERE Title = 'LAWYER'
")->fetchAll();
?>

<h2 class="text-xl font-bold mb-4">
    Assign Lawyer → <?= htmlspecialchars($prisoner['prisoner_name']) ?>
</h2>

<form action="?page=prisoner_map_post" method="post">

    <input type="hidden" name="prisoner_id" value="<?= $prisoner_id ?>">

    <label class="block mb-2">Select Lawyer</label>
    <select name="officer_id" class="border p-2 w-full" required>
        <option value="">Select</option>
        <?php foreach ($lawyers as $l): ?>
            <option value="<?= $l['Officer_id'] ?>">
                <?= $l['First_name'] . " " . $l['Last_name'] ?>
                (<?= $l['Specialization'] ?>)
            </option>
        <?php endforeach; ?>
    </select>

    <button class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded">
        Assign Lawyer
    </button>

</form>

<?php require_once SRC_PATH . "/views/layouts/footer.php"; ?>
