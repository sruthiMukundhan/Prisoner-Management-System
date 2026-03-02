<?php
global $pdo;

$username = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT 
        P.First_name,
        P.Last_name,
        P.Dob,
        P.Date_in,
        P.date_out,
        P.Status_inout,
        P.Crime_category,
        P.Risk_level,
        P.Medical_conditions,
        P.Emergency_contact,
        S.Section_name,
        S.Security_level,
        J.First_name AS Jailor_First,
        J.Last_name AS Jailor_Last
    FROM Prisoner P
    LEFT JOIN Section S ON P.Section_id = S.Section_id
    LEFT JOIN Jailor J ON S.Jailor_id = J.Jailor_id
    WHERE P.Prisoner_uname = ?
");

$stmt->execute([$username]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($data):

$daysRemaining = floor((strtotime($data['date_out']) - time()) / (60*60*24));
?>

<div class="bg-white p-6 rounded shadow space-y-6">

    <h2 class="text-2xl font-bold mb-4">My Profile</h2>

    <!-- BASIC DETAILS -->
    <div>
        <p><strong>Name:</strong> <?= $data['First_name'] . " " . $data['Last_name'] ?></p>
        <p><strong>Date of Birth:</strong> <?= $data['Dob'] ?></p>
        <p><strong>Status:</strong> <?= $data['Status_inout'] ?></p>
    </div>

    <hr>

    <!-- SENTENCE DETAILS -->
    <div>
        <h3 class="text-xl font-semibold mb-2">Sentence Details</h3>
        <p><strong>Date In:</strong> <?= $data['Date_in'] ?></p>
        <p><strong>Date Out:</strong> <?= $data['date_out'] ?></p>
        <p><strong>Days Remaining:</strong> <?= $daysRemaining ?></p>
    </div>

    <hr>

    <!-- CRIME -->
    <div>
        <h3 class="text-xl font-semibold mb-2">Crime & Risk</h3>
        <p><strong>Crime Category:</strong> <?= $data['Crime_category'] ?></p>
        <p><strong>Risk Level:</strong> <?= $data['Risk_level'] ?></p>
    </div>

    <hr>

    <!-- SECTION -->
    <div>
        <h3 class="text-xl font-semibold mb-2">Section Information</h3>
        <p><strong>Section:</strong> <?= $data['Section_name'] ?></p>
        <p><strong>Security Level:</strong> <?= $data['Security_level'] ?></p>
        <p><strong>Assigned Jailor:</strong> 
            <?= $data['Jailor_First'] . " " . $data['Jailor_Last'] ?>
        </p>
    </div>

    <hr>

    <!-- MEDICAL -->
    <div>
        <h3 class="text-xl font-semibold mb-2">Medical Information</h3>
        <p><strong>Conditions:</strong> <?= $data['Medical_conditions'] ?></p>
        <p><strong>Emergency Contact:</strong> <?= $data['Emergency_contact'] ?></p>
    </div>

</div>

<?php else: ?>
<p>No profile data found.</p>
<?php endif; ?>