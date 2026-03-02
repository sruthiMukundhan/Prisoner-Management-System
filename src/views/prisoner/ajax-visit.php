<?php
global $pdo;

$username = $_SESSION['userUidPrisoner'];

// Get Prisoner_id
$stmt = $pdo->prepare("SELECT Prisoner_id FROM Prisoner WHERE Prisoner_uname = ?");
$stmt->execute([$username]);
$prisoner = $stmt->fetch(PDO::FETCH_ASSOC);

$prisonerId = $prisoner['Prisoner_id'];

// Fetch visits (NO Approved filter)
$stmt = $pdo->prepare("
    SELECT 
        v.First_name,
        v.Last_name,
        v.Relationship_with_prisoner,
        v.Created_date,
        vs.Date_visit,
        vs.Time_slot,
        vs.Status
    FROM Visit vs
    JOIN Visitor v 
        ON vs.Visitor_aadhaar = v.Aadhaar
    WHERE vs.Prisoner_id = ?
    AND v.Status = 'Approved'
    ORDER BY vs.Date_visit DESC
");

$stmt->execute([$prisonerId]);
$visits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="bg-white p-6 rounded-lg shadow-md">

    <h3 class="text-2xl font-semibold mb-6 text-gray-800">
        Visit Records
    </h3>

    <?php if (!empty($visits)): ?>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse">

            <thead>
                <tr class="bg-gray-100 text-gray-700 text-left">
                    <th class="px-4 py-3">Visitor Name</th>
                    <th class="px-4 py-3">Relationship</th>
                    <th class="px-4 py-3">Created Date</th>
                    <th class="px-4 py-3">Time</th>
                    <th class="px-4 py-3 text-center">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">

                <?php foreach ($visits as $row): ?>
                <tr class="hover:bg-gray-50 transition">

                    <td class="px-4 py-3 font-medium text-gray-800">
                        <?= htmlspecialchars($row['First_name'] . ' ' . $row['Last_name']) ?>
                    </td>

                    <td class="px-4 py-3 text-gray-600">
                        <?= htmlspecialchars($row['Relationship_with_prisoner']) ?>
                    </td>

                    <td class="px-4 py-3 text-gray-600">
                        <?= date("d M Y, h:i A", strtotime($row['Created_date'])) ?>
                </td>

                    <td class="px-4 py-3 text-gray-600">
                        <?= htmlspecialchars($row['Time_slot']) ?>
                    </td>

                    <td class="px-4 py-3 text-center">
                        <?php if ($row['Status'] === 'Approved'): ?>
                            <span class="px-3 py-1 bg-green-500 text-white text-sm rounded-full">
                                Approved
                            </span>
                        <?php elseif ($row['Status'] === 'Pending'): ?>
                            <span class="px-3 py-1 bg-yellow-500 text-white text-sm rounded-full">
                                Pending
                            </span>
                        <?php else: ?>
                            <span class="px-3 py-1 bg-red-500 text-white text-sm rounded-full">
                                <?= htmlspecialchars($row['Status']) ?>
                            </span>
                        <?php endif; ?>
                    </td>

                </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>

    <?php else: ?>
        <p class="text-gray-500">No Visitors</p>
    <?php endif; ?>

</div>

