<?php
global $pdo;

$username = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT Date_in, date_out, Status_inout
    FROM Prisoner
    WHERE Prisoner_uname = ?
");

$stmt->execute([$username]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($data):

$daysRemaining = (strtotime($data['date_out']) - time()) / (60*60*24);
$daysRemaining = floor($daysRemaining);
?>

<div class="bg-white p-6 rounded shadow">
    <h3 class="text-xl font-bold mb-4">Sentence Details</h3>

    <p><strong>Date In:</strong> <?= $data['Date_in'] ?></p>
    <p><strong>Date Out:</strong> <?= $data['date_out'] ?></p>
    <p><strong>Status:</strong> <?= $data['Status_inout'] ?></p>
    <p><strong>Days Remaining:</strong> <?= $daysRemaining ?></p>
</div>

<?php else: ?>
<p>No sentence details found.</p>
<?php endif; ?>