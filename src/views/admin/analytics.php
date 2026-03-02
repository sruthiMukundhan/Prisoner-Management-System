<?php require "../src/views/layouts/header_unified.php"; ?>

<div class="min-h-screen bg-gray-50 py-10 px-6">

<h1 class="text-4xl font-bold text-center mb-10">
Advanced Analytics Dashboard
</h1>

<!-- APPROVAL RATE CARD -->
<div class="bg-white p-6 rounded-xl shadow mb-10 text-center">
    <h3 class="text-lg font-semibold mb-2">Visit Approval Success Rate</h3>
    <p class="text-5xl font-bold text-indigo-600">
        <?= $approvalRate ?>%
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">

<!-- SECTION OCCUPANCY -->
<div class="bg-white p-6 rounded-xl shadow">
    <h3 class="text-xl font-semibold mb-4">
        Section Occupancy
    </h3>
    <canvas id="sectionChart"></canvas>
</div>

<!-- HIGH RISK HEATMAP -->
<div class="bg-white p-6 rounded-xl shadow">
    <h3 class="text-xl font-semibold mb-4">
        High Risk Distribution
    </h3>
    <canvas id="riskChart"></canvas>
</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

/* SECTION OCCUPANCY */
new Chart(document.getElementById('sectionChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($sections, 'Section_name')) ?>,
        datasets: [{
            label: 'Current Population',
            data: <?= json_encode(array_column($sections, 'Current_population')) ?>,
            backgroundColor: '#6366F1'
        }]
    }
});

/* HIGH RISK HEATMAP */
new Chart(document.getElementById('riskChart'), {
    type: 'doughnut',
    data: {
        labels: <?= json_encode(array_column($riskStats, 'Risk_level')) ?>,
        datasets: [{
            data: <?= json_encode(array_column($riskStats, 'count')) ?>,
            backgroundColor: [
                '#10B981',  // Low
                '#F59E0B',  // Medium
                '#EF4444',  // High
                '#7C3AED'   // Maximum
            ]
        }]
    }
});

setInterval(() => {
    fetch('?page=analytics')
        .then(() => location.reload());
}, 15000);

</script>

<?php require "../src/views/layouts/footer.php"; ?>