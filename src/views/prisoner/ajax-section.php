<?php
global $pdo;

$username = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT S.Section_name,
           S.Security_level,
           S.Capacity,
           S.Current_population,
           J.First_name AS Jailor_First,
           J.Last_name AS Jailor_Last
    FROM Prisoner P
    JOIN Section S ON P.Section_id = S.Section_id
    LEFT JOIN Jailor J ON S.Jailor_id = J.Jailor_id
    WHERE P.Prisoner_uname = ?
");

$stmt->execute([$username]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($data):
?>

<div class="bg-white p-6 rounded shadow">
    <h3 class="text-xl font-bold mb-4">Section Information</h3>

    <p><strong>Section:</strong> <?= $data['Section_name'] ?></p>
    <p><strong>Security Level:</strong> <?= $data['Security_level'] ?></p>
    <p><strong>Capacity:</strong> <?= $data['Capacity'] ?></p>
    <p><strong>Current Population:</strong> <?= $data['Current_population'] ?></p>
    <p><strong>Assigned Jailor:</strong>
        <?= $data['Jailor_First'] . " " . $data['Jailor_Last'] ?>
    </p>
</div>

<?php else: ?>
<p>No section information found.</p>
<?php endif; ?>