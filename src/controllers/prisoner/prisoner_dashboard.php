<?php
require_once SRC_PATH . '/includes/init.php';
require_once SRC_PATH . '/views/layouts/header_unified.php';

global $pdo, $auth;

/* PRISONER AUTH */
if (!$auth->isLoggedIn() || !$auth->hasRole('prisoner')) {
    redirect('home');
    exit;
}

$username = $_SESSION['userUidPrisoner'];

// Get Prisoner ID
$stmt = $pdo->prepare("SELECT Prisoner_id, Risk_level, Status_inout FROM Prisoner WHERE Prisoner_uname = ?");
$stmt->execute([$username]);
$prisoner = $stmt->fetch(PDO::FETCH_ASSOC);

$prisonerId = $prisoner['Prisoner_id'];

/* DASHBOARD STATS */

// Total Visits
$totalVisits = $pdo->prepare("
    SELECT COUNT(*) FROM Visit 
    WHERE Prisoner_id = ?
");
$totalVisits->execute([$prisonerId]);
$totalVisits = $totalVisits->fetchColumn();

// Approved Visits
$approvedVisits = $pdo->prepare("
    SELECT COUNT(*) FROM Visit
    WHERE Prisoner_id = ?
    AND Officer_status='Approved'
    AND Lawyer_status='Approved'
");
$approvedVisits->execute([$prisonerId]);
$approvedVisits = $approvedVisits->fetchColumn();

$riskLevel = $prisoner['Risk_level'];
$statusInOut = $prisoner['Status_inout'];
?>

<div class="container mx-auto px-6 py-8">

<h1 class="text-2xl font-bold text-center mb-2 text-gray-900">
    Prisoner Dashboard
</h1>
<p class="text-center mb-8 text-gray-700 text-sm">
    Prison Management System
</p>

<!-- ================= COMPACT STATS ================= -->
<div class="flex justify-center flex-wrap gap-4 mb-10">

    <div class="bg-gray-100 px-6 py-3 rounded-md border border-gray-800 text-center min-w-[130px]">
        <p class="text-purple-900 text-sm font-semibold mb-1">Total Visits</p>
        <p class="text-xl font-bold text-gray-900 mt-1">
            <?= $totalVisits ?>
        </p>
    </div>

    <div class="bg-gray-100 px-6 py-3 rounded-md border border-gray-800 text-center min-w-[130px]">
        <p class="text-purple-900 text-sm font-semibold mb-1">Approved Visits</p>
        <p class="text-xl font-bold text-gray-900 mt-1">
            <?= $approvedVisits ?>
        </p>
    </div>

    <div class="bg-gray-100 px-6 py-3 rounded-md border border-gray-800 text-center min-w-[130px]">
        <p class="text-purple-900 text-sm font-semibold mb-1">Risk Level</p>
        <p class="text-l font-bold text-gray-900 mt-1">
            <?= htmlspecialchars($riskLevel) ?>
        </p>
    </div>

    <div class="bg-gray-100 px-6 py-3 rounded-md border border-gray-800 text-center min-w-[130px]">
        <p class="text-purple-900 text-sm font-semibold mb-1">Status</p>
        <p class="text-l font-bold text-gray-900 mt-1">
            <?= htmlspecialchars($statusInOut) ?>
        </p>
    </div>

</div>

<!-- ================= ACTION CARDS ================= -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-10">

    <div class="bg-gray-100 border border-gray-900 rounded-md p-3 shadow-sm hover:shadow-md hover:border-black transition duration-300">
        <h3 class="text-sm font-semibold text-gray-900 mb-1">My Profile</h3>
        <p class="text-xs text-gray-600 mb-2">View personal details</p>
        <a href="?page=prisoner-profile" 
        class="text-purple-900 text-sm font-semibold hover:underline">
            View Profile →
        </a>
    </div>

    <div class="bg-gray-100 border border-gray-900 rounded-md p-3 shadow-sm hover:shadow-md hover:border-black transition duration-300">
        <h3 class="text-sm font-semibold text-gray-900 mb-1">Entertainment</h3>
        <p class="text-xs text-gray-600 mb-2">Explore videos & books</p>
        <a href="?page=prisoner-entertainment" 
        class="text-purple-900 text-sm font-semibold hover:underline">
            View →
        </a>
    </div>

    <div class="bg-gray-100 border border-gray-900 rounded-md p-3 shadow-sm hover:shadow-md hover:border-black transition duration-300">
        <h3 class="text-sm font-semibold text-gray-900 mb-1">Visit Status</h3>
        <p class="text-xs text-gray-600 mb-2">Approved & scheduled visits</p>
        <a href="?page=prisoner-visits" 
        class="text-purple-900 text-sm font-semibold hover:underline">
            View Visits →
        </a>
    </div>

</div>

</div>

<?php require_once SRC_PATH . '/views/layouts/footer.php'; ?>