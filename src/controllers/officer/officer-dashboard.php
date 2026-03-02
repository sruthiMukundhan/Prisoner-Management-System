<?php
require_once SRC_PATH . "/views/layouts/header_unified.php";

if (!$auth->isLoggedIn() || !$auth->hasRole('officer')) {
    redirect('home');
    exit;
}
?>

<div class="relative z-10">

<section class="mt-16 pb-16">
<div class="container mx-auto px-6">

<div class="text-center mb-8">
    <h1 class="text-2xl font-semibold text-gray-900">
        Officer Dashboard
    </h1>
    <p class="text-gray-700 text-sm mt-1">
        Prison Management System
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-5">

    <!-- CARD -->
    <div class="bg-gray-100 border border-gray-900 rounded-md p-3
                shadow-sm hover:shadow-md hover:border-black
                transition duration-300">

        <h3 class="text-gray-900 text-sm font-semibold mb-1">
            Add Prisoner & Crime
        </h3>

        <p class="text-gray-600 text-xs mb-2">
            Register prisoner and crime details
        </p>

        <a href="?page=crime"
          class="text-purple-900 text-sm font-semibold mb-1 hover:underline">
            Add Prisoner →
        </a>
    </div>

    <!-- CARD -->
    <div class="bg-gray-100 border border-gray-900 rounded-md p-3
                shadow-sm hover:shadow-md hover:border-black
                transition duration-300">

        <h3 class="text-gray-900 text-sm font-semibold mb-1">
            Update Prisoner Out Date
        </h3>

        <p class="text-gray-600 text-xs mb-2">
            Update prisoner date_out
        </p>

        <a href="?page=prisoner-dateout"
           class="text-purple-900 text-sm font-semibold mb-1 hover:underline">
            Update →
        </a>
    </div>

    <!-- CARD -->
<div class="bg-gray-100 border border-gray-900 rounded-md p-3
                shadow-sm hover:shadow-md hover:border-black
                transition duration-300">
    <h3 class="text-gray-900 text-sm font-semibold mb-1">IPC Management</h3>
    <p class="text-gray-600 text-xs mb-2">View and modify IPC details</p>

    <div class="card-actions">
        <a href="?page=ipc-view" 
        class="text-purple-900 text-sm font-semibold mb-1 hover:underline">
            View IPC →
        </a>

        <a href="?page=ipc-update" 
       class="text-purple-900 text-sm font-semibold mb-1 hover:underline">
            Update IPC →
        </a>
    </div>
</div>

    <!-- CARD -->
    <div class="bg-gray-100 border border-gray-900 rounded-md p-3
                shadow-sm hover:shadow-md hover:border-black
                transition duration-300">

        <h3 class="text-gray-900 text-sm font semi-bold mb-1">
            View Crime Details
        </h3>

        <p class="text-gray-600 text-xs mb-2">
            View all prisoner crime records
        </p>

        <a href="?page=crime-view"
         class="text-purple-900 text-sm font-semibold mb-1 hover:underline">
            View Crimes →
        </a>
    </div>



</div>

</div>
</section>

</div>

<?php require_once SRC_PATH . "/views/layouts/footer.php"; ?>