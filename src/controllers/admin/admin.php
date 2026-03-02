<?php
require_once SRC_PATH . '/includes/init.php';
require_once SRC_PATH . '/views/layouts/header_unified.php';

global $pdo, $auth;

/* ADMIN AUTH */
if (!$auth->isLoggedIn() || !$auth->hasRole('admin')) {
    redirect('home');
    exit;
}

/* FETCH DASHBOARD STATS */

// Total Prisoners
$totalPrisoners = $pdo->query("
    SELECT COUNT(*) FROM Prisoner 
    WHERE Status_inout='in'
")->fetchColumn();

// Active Officers
$activeOfficers = $pdo->query("
    SELECT COUNT(*) FROM Officer 
    WHERE Status='active'
")->fetchColumn();

// Today's Approved Visits
$todayVisits = $pdo->query("
    SELECT COUNT(*) 
    FROM Visit
    WHERE Date_visit = CURDATE()
    AND Officer_status='Approved'
    AND Lawyer_status='Approved'
")->fetchColumn();


// High Risk
$highRisk = $pdo->query("
    SELECT COUNT(*) 
    FROM Prisoner
    WHERE Risk_level='High'
    AND Status_inout='in'
")->fetchColumn();

// Violent Crimes
$violent = $pdo->query("
    SELECT COUNT(*) 
    FROM Prisoner
    WHERE Crime_category='Violent'
    AND Status_inout='in'
")->fetchColumn();

?>

<div class="container mx-auto px-6 py-8">

<h1 class="text-2xl font-bold text-center mb-2 text-gray-900">
    Admin Dashboard
</h1>
<p class="text-center mb-8 text-gray-700 text-sm">
    Prison Management System
</p>

<!-- ================= COMPACT STATS ================= -->
<div class="flex justify-center flex-wrap gap-4 mb-10">

    <div class="bg-gray-100 px-6 py-3 rounded-md border border-gray-800 text-center min-w-[130px]">
        <p  class="text-purple-900 text-sm font-semibold mb-1">Prisoners</p>
        <p class="text-xl font-bold text-gray-900 mt-1" id="total_prisoners">
                       <?= $totalPrisoners ?>
        </p>
    </div>

    <div class="bg-gray-100 px-6 py-3 rounded-md border border-gray-800 text-center min-w-[130px]">
        <p  class="text-purple-900 text-sm font-semibold mb-1">Officers</p>
        <p class="text-xl font-bold text-gray-900 mt-1" id="active_officers">
            <?= $activeOfficers ?>
        </p>
    </div>

    <div class="bg-gray-100 px-6 py-3 rounded-md border border-gray-800 text-center min-w-[130px]">
        <p  class="text-purple-900 text-sm font-semibold mb-1">Today's Visits</p>
        <p class="text-xl font-bold text-gray-900 mt-1" id="today_visits">
            <?= $todayVisits ?>
        </p>
    </div>

    <div class="bg-gray-100 px-6 py-3 rounded-md border border-gray-800 text-center min-w-[130px]">
        <p  class="text-purple-900 text-sm font-semibold mb-1">High Risk</p>
        <p class="text-xl font-bold text-gray-900 mt-1" id="high_risk">
            <?= $highRisk ?>
        </p>
    </div>

    <div class="bg-gray-100 px-6 py-3 rounded-md border border-gray-800 text-center min-w-[130px]">
        <p  class="text-purple-900 text-sm font-semibold mb-1">Violent Crimes</p>
        <p class="text-xl font-bold text-gray-900 mt-1" id="violent">
            <?= $violent ?>
        </p>
    </div>

</div>

<!-- ================= ACTION CARDS ================= -->
 <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-10">

    <div class="bg-gray-100 border border-gray-900 rounded-md p-3 shadow-sm hover:shadow-md hover:border-black transition duration-300">
        <h3 class="text-sm font-semibold text-gray-900 mb-1">Add Visitor</h3>
        <p class="text-xs text-gray-600 mb-2">Register new visitors</p>
        <a href="?page=visitor-add" 
      class="text-purple-900 text-sm font-semibold mb-1 hover:underline">Add Visitor →</a>
    </div>

    <div class="bg-gray-100 border border-gray-900 rounded-md p-3 shadow-sm hover:shadow-md hover:border-black transition duration-300">
        <h3 class="text-sm font-semibold text-gray-900 mb-1">Add Officer</h3>
        <p class="text-xs text-gray-600 mb-2">Register new officers</p>
        <a href="?page=add_officer" 
         class="text-purple-900 text-sm font-semibold mb-1 hover:underline">Add Officer →</a>
    </div>

    <div class="bg-gray-100 border border-gray-900 rounded-md p-3 shadow-sm hover:shadow-md hover:border-black transition duration-300">
        <h3 class="text-sm font-semibold text-gray-900 mb-1">Lunch Menu</h3>
        <p class="text-xs text-gray-600 mb-2">Manage daily meals</p>
        <a href="?page=ai_lunch" 
        class="text-purple-900 text-sm font-semibold mb-1 hover:underline">Manage →</a>
    </div>

    <div class="bg-gray-100 border border-gray-900 rounded-md p-3 shadow-sm hover:shadow-md hover:border-black transition duration-300">
        <h3 class="text-sm font-semibold text-gray-900 mb-1">Lawyer – Prisoner Map</h3>
        <p class="text-xs text-gray-600 mb-2">Assign lawyers to prisoners</p>
        <a href="?page=lawyer-map" 
         class="text-purple-900 text-sm font-semibold mb-1 hover:underline">Map Now →</a>
    </div>

    <div class="bg-gray-100 border border-gray-900 rounded-md p-3 shadow-sm hover:shadow-md hover:border-black transition duration-300">
        <h3 class="text-sm font-semibold text-gray-900 mb-1">Analytics Dashboard</h3>
        <p class="text-xs text-gray-600 mb-2">System performance & charts</p>
        <a href="?page=analytics" 
         class="text-purple-900 text-sm font-semibold mb-1 hover:underline">Open Analytics →</a>
    </div>

</div>

<script>
function updateStats() {
    fetch('?page=stats_api')
        .then(res => res.json())
        .then(data => {
            document.getElementById('total_prisoners').innerText = data.Total_Prisoners;
            document.getElementById('active_officers').innerText = data.Active_Officers;
            document.getElementById('today_visits').innerText = data.Today_Visits;
            document.getElementById('high_risk').innerText = data.High_Risk_Prisoners;
            document.getElementById('violent').innerText = data.Violent_Criminals;
        });
}
setInterval(updateStats, 5000);
</script>

<?php require_once SRC_PATH . '/views/layouts/footer.php'; ?>