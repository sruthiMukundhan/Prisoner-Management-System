<?php
require_once SRC_PATH . '/includes/init.php';
require_once SRC_PATH . '/views/layouts/header_unified.php';

global $pdo, $auth;

if (!$auth->isLoggedIn() || !$auth->hasRole('admin')) {
    redirect('home');
    exit;
}

/* HANDLE FORM SUBMIT */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $lawyer   = isset($_POST['lawyer_id']) ? intval($_POST['lawyer_id']) : 0;
$prisoner = isset($_POST['prisoner_id']) ? intval($_POST['prisoner_id']) : 0;
$case     = isset($_POST['case_title']) ? trim($_POST['case_title']) : '';

    $stmt = $pdo->prepare("
        INSERT INTO lawyer_prisoner_map (lawyer_id, prisoner_id, case_title)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$lawyer, $prisoner, $case]);

    echo "<div class='bg-green-500 text-white p-3 rounded mb-4'>
            Mapping Successful ✅
          </div>";
}

/* FETCH LAWYERS */
$lawyers = $pdo->query("
    SELECT Lawyer_id, Lawyer_uname 
    FROM Lawyer
")->fetchAll(PDO::FETCH_ASSOC);

/* FETCH PRISONERS */
$prisoners = $pdo->query("
    SELECT Prisoner_id, Prisoner_uname 
    FROM Prisoner
")->fetchAll(PDO::FETCH_ASSOC);

/* FETCH EXISTING MAPPINGS */
$maps = $pdo->query("
    SELECT 
        m.id,
        p.Prisoner_uname,
        l.Lawyer_uname,
        m.case_title,
        m.assigned_at,
        m.status
    FROM lawyer_prisoner_map m
    JOIN Prisoner p ON m.prisoner_id = p.Prisoner_id
    JOIN Lawyer l ON m.lawyer_id = l.Lawyer_id
    ORDER BY m.assigned_at DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto px-6 py-8">

<h2 class="text-2xl font-bold mb-6">Lawyer – Prisoner Map</h2>

<form method="POST" class="space-y-4 mb-10">

<select name="lawyer_id" class="border p-2 w-full" required>
<option value="">Select Lawyer</option>
<?php foreach ($lawyers as $l): ?>
<option value="<?= $l['Lawyer_id'] ?>">
<?= htmlspecialchars($l['Lawyer_uname']) ?>
</option>
<?php endforeach; ?>
</select>

<select name="prisoner_id" class="border p-2 w-full" required>
<option value="">Select Prisoner</option>
<?php foreach ($prisoners as $p): ?>
<option value="<?= $p['Prisoner_id'] ?>">
<?= htmlspecialchars($p['Prisoner_uname']) ?>
</option>
<?php endforeach; ?>
</select>

<input 
    type="text" 
    name="case_title" 
    placeholder="Enter Case Name"
    class="border p-2 w-full"
    required
>

<button class="bg-indigo-600 text-white px-4 py-2 rounded">
Map Now
</button>

</form>

<h3 class="text-xl font-semibold mb-4">Mapped Records</h3>

<table class="min-w-full bg-white shadow rounded">
<thead class="bg-gray-100">
<tr>
<th class="p-3 text-left">Prisoner</th>
<th class="p-3 text-left">Lawyer</th>
<th class="p-3 text-left">Case</th>
<th class="p-3 text-left">Assigned At</th>
<th class="p-3 text-left">Status</th>
<th class="p-3 text-left">Action</th>
</tr>
</thead>

<tbody>

<?php if (count($maps) > 0): ?>
<?php foreach ($maps as $m): ?>
<tr class="border-b">
<td class="p-3"><?= htmlspecialchars($m['Prisoner_uname']) ?></td>
<td class="p-3"><?= htmlspecialchars($m['Lawyer_uname']) ?></td>
<td class="p-3"><?= htmlspecialchars($m['case_title']) ?></td>
<td class="p-3"><?= $m['assigned_at'] ?></td>
<td class="p-3">
<span class="bg-blue-500 text-white px-2 py-1 rounded">
<?= $m['status'] ?>
</span>
</td>
<td class="p-3">
<a href="?page=delete-lawyer-map&id=<?= $m['id'] ?>"
onclick="return confirm('Delete this mapping?')"
class="bg-red-600 text-white px-3 py-1 rounded">
Delete
</a>
</td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
<td colspan="6" class="p-4 text-center opacity-70">
No mappings found
</td>
</tr>
<?php endif; ?>

</tbody>
</table>

</div>

<?php require_once SRC_PATH . '/views/layouts/footer.php'; ?>