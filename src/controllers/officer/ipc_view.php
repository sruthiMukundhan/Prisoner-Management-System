<?php
require_once SRC_PATH . "/views/layouts/header_unified.php";
require_once SRC_PATH . "/includes/init.php";
global $pdo;

/* SESSION CHECK */
if (!isset($_SESSION['userUidOfficer'])) {
    redirect('home');
    exit;
}

/* FETCH IPC */
$stmt = $pdo->query("
    SELECT ipc_code, description
    FROM ipc_master
    ORDER BY ipc_code ASC
");
$ipcs = $stmt->fetchAll();

$deleted = $_GET['deleted'] ?? null;
?>

<div class="container mx-auto px-6 py-10">

    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl p-8">

        <h2 class="text-2xl font-bold mb-6">All IPC Codes</h2>

        <?php if ($deleted): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
                IPC deleted successfully.
            </div>
        <?php endif; ?>

        <table class="min-w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">IPC Code</th>
                    <th class="border px-4 py-2">Description</th>
                    <th class="border px-4 py-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
<?php foreach ($ipcs as $ipc): ?>
<tr class="hover:bg-gray-50">

    <td class="border px-4 py-2">
        <?= htmlspecialchars($ipc['ipc_code']) ?>
    </td>

    <td class="border px-4 py-2">
        <?= htmlspecialchars($ipc['description']) ?>
    </td>

    <td class="border px-4 py-2 text-center">
        <form method="POST"
              action="index.php?page=ipc-delete"
              onsubmit="return confirm('Delete this IPC?');">

            <input type="hidden"
                   name="ipc_code"
                   value="<?= $ipc['ipc_code'] ?>">

            <button type="submit"
                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                Delete
            </button>

        </form>
    </td>

</tr>
<?php endforeach; ?>
</tbody>
        </table>

    </div>
</div>

<?php require_once SRC_PATH . "/views/layouts/footer.php"; ?>