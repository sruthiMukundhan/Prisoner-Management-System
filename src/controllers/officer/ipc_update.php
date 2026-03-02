<?php
require_once SRC_PATH . "/views/layouts/header_unified.php";
require_once SRC_PATH . "/includes/init.php";
global $pdo;

/* ======================
   AUTH CHECK
====================== */
if (!isset($_SESSION['userUidOfficer'])) {
    redirect('home');
    exit;
}

/* ======================
   UPDATE IPC
====================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $prisoner_id = $_POST['prisoner_id'] ?? null;
    $ipc_code    = $_POST['ipc_code'] ?? null;

    if ($prisoner_id && $ipc_code) {

        $stmt = $pdo->prepare("
            UPDATE prisoner
            SET Crime_category = ?
            WHERE Prisoner_id = ?
        ");
        $stmt->execute([$ipc_code, $prisoner_id]);
    }

    header("Location: ?page=ipc-update&updated=1");
    exit;
}

/* ======================
   FETCH PRISONERS
====================== */
$stmt = $pdo->query("
    SELECT 
        Prisoner_id,
        First_name,
        Last_name,
        Crime_category
    FROM prisoner
    WHERE Status_inout = 'in'
    ORDER BY Prisoner_id ASC
");
$prisoners = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ======================
   FETCH IPC LIST
====================== */
$ipcList = $pdo->query("
    SELECT ipc_code
    FROM ipc_master
    ORDER BY ipc_code
")->fetchAll(PDO::FETCH_ASSOC);

$updated = $_GET['updated'] ?? null;
?>

<div class="container mx-auto px-6 py-6">

    <h1 class="text-3xl font-bold mb-6">Update IPC for Prisoners</h1>

    <?php if ($updated): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            IPC updated successfully.
        </div>
    <?php endif; ?>

    <table class="min-w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Current IPC</th>
                <th class="border px-4 py-2">Change IPC</th>
                <th class="border px-4 py-2">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($prisoners as $p): ?>
                <tr class="hover:bg-gray-50">
                    <form method="POST">
                        <td class="border px-4 py-2">
                            <?= $p['Prisoner_id'] ?>
                        </td>

                        <td class="border px-4 py-2">
                            <?= htmlspecialchars($p['First_name'].' '.$p['Last_name']) ?>
                        </td>

                       <td class="border px-4 py-2">
    <?= is_numeric($p['Crime_category']) ? $p['Crime_category'] : '-' ?>
</td>

                        <td class="border px-4 py-2">
                            <select name="ipc_code" class="border px-2 py-1 rounded">
                                <?php foreach ($ipcList as $ipc): ?>
                                    <option value="<?= $ipc['ipc_code'] ?>"
                                        <?= ($ipc['ipc_code'] == $p['Crime_category']) ? 'selected' : '' ?>>
                                        <?= $ipc['ipc_code'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <input type="hidden"
                                   name="prisoner_id"
                                   value="<?= $p['Prisoner_id'] ?>">
                        </td>

                       <td class="border px-4 py-2 text-center">

    <button type="submit"
        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
        Update
    </button>

</td>

                    </form>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<?php require_once SRC_PATH . "/views/layouts/footer.php"; ?>