<?php
require_once SRC_PATH . "/views/layouts/header_unified.php";

// Get requested page
$page = $_GET['page'] ?? 'prisoner-profile';

// Map prisoner subpages to AJAX routes
$map = [
    'prisoner-profile'  => 'ajax-profile',
    'prisoner-sentence' => 'ajax-sentence',
    'prisoner-section'  => 'ajax-section',
    'prisoner-visits'   => 'ajax-visit',
    'prisoner-crime'    => 'ajax-crime',
    'prisoner-medical'  => 'ajax-medical'
];

$ajaxPage = $map[$page] ?? 'ajax-profile';
?>

<div class="container px-5 py-10 mx-auto">
    <div id="ajax-content">
        <p>Loading...</p>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    fetch('?page=<?= $ajaxPage ?>')
        .then(response => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.text();
        })
        .then(data => {
            document.getElementById('ajax-content').innerHTML = data;
        })
        .catch(error => {
            document.getElementById('ajax-content').innerHTML =
                "<p style='color:red;'>Error loading content</p>";
            console.error("Fetch error:", error);
        });

});
</script>

<?php require_once SRC_PATH . "/views/layouts/footer.php"; ?>