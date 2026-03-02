<?php
require_once SRC_PATH . "/views/layouts/header_unified.php";
?>

<div class="container px-5 py-10 mx-auto">
    <h2 class="text-2xl font-bold mb-6">Prisoner Details</h2>

    <div id="ajax-content">
        <!-- AJAX loads here -->
    </div>
</div>

<script>
fetch('<?= BASE_URL ?>?page=ajax-profile')
    .then(res => res.text())
    .then(data => {
        document.getElementById('ajax-content').innerHTML = data;
    });
</script>

<?php require_once SRC_PATH . "/views/layouts/footer.php"; ?>