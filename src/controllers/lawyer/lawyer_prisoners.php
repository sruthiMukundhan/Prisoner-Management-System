<?php
require_once SRC_PATH . "/includes/database/dbh.inc.php";
require_once SRC_PATH . "/includes/auth/Auth.php";

global $pdo;
$auth = new Auth($pdo);

if (!$auth->isLoggedIn() || !$auth->hasRole('lawyer')) {
    redirect('signin-lawyer');
    exit;
}

/* Get logged-in lawyer username */
$lawyerUsername = $_SESSION['userUidLawyer'] ?? null;

/* Get Lawyer ID */
$stmt = $pdo->prepare("SELECT Lawyer_id FROM lawyer WHERE Lawyer_uname=?");
$stmt->execute([$lawyerUsername]);
$lawyerId = $stmt->fetchColumn();

/* Fetch assigned prisoners */
$stmt = $pdo->prepare("
    SELECT 
        CONCAT(p.First_name,' ',p.Last_name) AS Full_Name,
        p.Crime_category,
        p.Risk_level,
        s.Section_name
    FROM prisoner p
    JOIN lawyer_prisoner_map lpm 
        ON p.Prisoner_id = lpm.Prisoner_id
    LEFT JOIN section s 
        ON p.Section_id = s.Section_id
    WHERE lpm.Lawyer_id = ?
");
$stmt->execute([$lawyerId]);
$prisoners = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once SRC_PATH . "/views/layouts/header_unified.php";
?>

<div class="min-h-screen bg-gray-50 py-10 px-6">

<h1 class="text-3xl font-bold mb-8">My Assigned Prisoners</h1>

<?php if (empty($prisoners)): ?>
    <div class="bg-yellow-100 text-yellow-800 p-4 rounded">
        No prisoners assigned yet.
    </div>
<?php else: ?>

<div class="bg-white shadow rounded-lg overflow-hidden">
<table class="min-w-full">
<thead class="bg-gray-200">
<tr>
<th class="p-3 text-left">Name</th>
<th class="p-3 text-left">Section</th>
<th class="p-3 text-left">Crime</th>
<th class="p-3 text-left">Risk Level</th>
</tr>
</thead>
<tbody>

<?php foreach ($prisoners as $p): ?>
<tr class="border-b">
<td class="p-3"><?= htmlspecialchars($p['Full_Name']) ?></td>
<td class="p-3"><?= htmlspecialchars($p['Section_name']) ?></td>
<td class="p-3"><?= htmlspecialchars($p['Crime_category']) ?></td>
<td class="p-3"><?= htmlspecialchars($p['Risk_level']) ?></td>
</tr>
<?php endforeach; ?>

</tbody>
</table>
</div>

<?php endif; ?>

</div>

<?php require_once SRC_PATH . "/views/layouts/footer.php"; ?>