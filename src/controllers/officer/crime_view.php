<?php
require_once SRC_PATH . "/includes/init.php";
require_once SRC_PATH . "/views/layouts/header_unified.php";
global $pdo;

// Auth check
if (!$auth->isLoggedIn() || !$auth->hasRole('officer')) {
    redirect('home');
}


/* ======================
   DELETE PRISONER
====================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['delete_prisoner_id'])) {

    $pid = $_POST['delete_prisoner_id'];

    // Delete related IPC mappings
    $pdo->prepare("DELETE FROM commits WHERE Prisoner_id = ?")
        ->execute([$pid]);

    // Delete prisoner
    $pdo->prepare("DELETE FROM prisoner WHERE Prisoner_id = ?")
        ->execute([$pid]);

    header("Location: index.php?page=crime-view");
    exit;
}

/* ======================
   FETCH PRISONERS
====================== */
$params = [];
$where = "";

$ipc = $_GET['ipc'] ?? null;

if ($ipc) {
    $where = "WHERE c.IPC = ?";
    $params[] = $ipc;
}

$sql = "
SELECT 
    p.Prisoner_id,
    p.First_name,
    p.Last_name,
    p.Section_id,
    p.Created_date,
    GROUP_CONCAT(c.IPC SEPARATOR ', ') AS IPCs
FROM prisoner p
LEFT JOIN commits c ON p.Prisoner_id = c.Prisoner_id
$where
GROUP BY p.Prisoner_id
ORDER BY p.Prisoner_id 
";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto px-6 py-6">
    <h1 class="text-3xl font-bold mb-6">
        Prisoners
        <?php if ($ipc): ?>
            <span class="text-gray-500 text-lg">
                (IPC <?= htmlspecialchars($ipc) ?>)
            </span>
        <?php endif; ?>
    </h1>

    <table class="min-w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Section</th>
                <th class="border px-4 py-2">IPC Codes</th>
                <th class="border px-4 py-2">Added On</th>
                <th class="border px-4 py-2">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php if ($rows): ?>
                <?php foreach ($rows as $row): ?>
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2"><?= $row['Prisoner_id'] ?></td>
                    <td class="border px-4 py-2">
                        <?= htmlspecialchars($row['First_name'].' '.$row['Last_name']) ?>
                    </td>
                    <td class="border px-4 py-2"><?= $row['Section_id'] ?></td>
                    <td class="border px-4 py-2"><?= $row['IPCs'] ?: '-' ?></td>
                    <td class="border px-4 py-2"><?= $row['Created_date'] ?></td>
                    <td class="border px-4 py-2 text-center">
                        <form method="post"
      action="index.php?page=crime-view"
      onsubmit="return confirm('Delete this prisoner permanently?');">

    <input type="hidden"
           name="delete_prisoner_id"
           value="<?= $row['Prisoner_id'] ?>">

    <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
        Delete
    </button>

</form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">
                        No prisoners found
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once SRC_PATH . "/views/layouts/footer.php"; ?>
