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

/* Fetch visits */
$stmt = $pdo->prepare("
    SELECT 
        CONCAT(p.First_name,' ',p.Last_name) AS Full_Name,
        lvr.Visit_date,
        lvr.Officer_status,
        lvr.Admin_status
    FROM lawyer_visit_request lvr
    JOIN prisoner p ON p.Prisoner_id = lvr.Prisoner_id
    WHERE lvr.Lawyer_id = ?
    ORDER BY lvr.Visit_date DESC
");
$stmt->execute([$lawyerId]);
$approvedVisits = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once SRC_PATH . "/views/layouts/header_unified.php";
?>

<div class="p-10">

<h2 class="text-2xl font-bold mb-6">My Visits</h2>

<table class="min-w-full bg-white shadow rounded">
<thead>
<tr>
<th class="p-3 text-left">Prisoner</th>
<th class="p-3 text-left">Visit Date</th>
<th class="p-3 text-left">Status</th>
</tr>
</thead>

<tbody>

<?php foreach($approvedVisits as $v): ?>
<tr class="border-b">

<td class="p-3"><?= htmlspecialchars($v['Full_Name']) ?></td>
<td class="p-3"><?= $v['Visit_date'] ?></td>

<td class="p-3">
<?php
$today = date('Y-m-d');

if ($v['Visit_date'] < $today) {
    echo '<span class="bg-red-600 text-white px-3 py-1 rounded">Expired</span>';
} elseif ($v['Officer_status']=='Approved' && $v['Admin_status']=='Approved') {
    echo '<span class="bg-green-600 text-white px-3 py-1 rounded">Confirmed</span>';
} elseif ($v['Officer_status']=='Approved') {
    echo '<span class="bg-yellow-500 text-white px-3 py-1 rounded">Waiting Admin</span>';
} else {
    echo '<span class="bg-gray-400 text-white px-3 py-1 rounded">Pending Officer</span>';
}
?>
</td>

</tr>
<?php endforeach; ?>

<?php if(empty($approvedVisits)): ?>
<tr>
<td colspan="3" class="p-3 text-gray-500">
No visits yet.
</td>
</tr>
<?php endif; ?>

</tbody>
</table>

</div>

<?php require_once SRC_PATH . "/views/layouts/footer.php"; ?>