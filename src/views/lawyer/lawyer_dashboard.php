<?php
require_once SRC_PATH . "/views/layouts/header_unified.php";

if (!$auth->isLoggedIn() || !$auth->hasRole('lawyer')) {
    redirect('home');
    exit;
}
?>

<div class="relative z-10">
<section class="mt-16 pb-16">
<div class="container mx-auto px-6">

<div class="text-center mb-8">
    <h1 class="text-2xl font-semibold text-gray-900">
        Lawyer Dashboard
    </h1>
    <p class="text-gray-700 text-sm mt-1">
        Prison Management System
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-5">

    <div class="bg-gray-100 border border-gray-900 rounded-md p-3 shadow-sm hover:shadow-md hover:border-black transition duration-300">
        <h3 class="text-sm font-semibold text-gray-900 mb-1">View Prisoners</h3>
        <p class="text-xs text-gray-600 mb-2">See assigned prisoners & case details</p>
        <a href="?page=lawyer-prisoners" 
        class="text-purple-900 text-sm font-semibold mb-1 hover:underline">Open →</a>
    </div>

    <div class="bg-gray-100 border border-gray-900 rounded-md p-3 shadow-sm hover:shadow-md hover:border-black transition duration-300">
        <h3 class="text-sm font-semibold text-gray-900 mb-1">Request Visit</h3>
        <p class="text-xs text-gray-600 mb-2">Schedule a meeting with prisoner</p>
        <a href="?page=lawyer-visit" 
        class="text-purple-900 text-sm font-semibold mb-1 hover:underline">Request →</a>
    </div>

    <div class="bg-gray-100 border border-gray-900 rounded-md p-3 shadow-sm hover:shadow-md hover:border-black transition duration-300">
        <h3 class="text-sm font-semibold text-gray-900 mb-1">Case Notes</h3>
        <p class="text-xs text-gray-600 mb-2">Add & manage legal notes</p>
        <a href="?page=lawyer-notes" 
        class="text-purple-900 text-sm font-semibold mb-1 hover:underline">Manage →</a>
    </div>

</div>
</div>
</section>
</div>

<?php require_once SRC_PATH . "/views/layouts/footer.php"; ?>