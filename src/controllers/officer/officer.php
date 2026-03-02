<?php
require_once SRC_PATH . "/views/layouts/header_unified.php";

// Admin check
if (!$auth->isLoggedIn() || !$auth->hasRole('admin')) {
    redirect('home');
}

$errors = [
    "emptyfields" => "Empty fields!!",
    "sqlerror" => "SQL database connection error!!",
    "passwordnotmatched" => "Passwords do not match!!",
    "sameuserexistserror" => "Lawyer already exists!!"
];

if (isset($_GET['error']) && isset($errors[$_GET['error']])) {
    echo '<h2 class="mt-6 text-center text-3xl font-extrabold text-red-600">'
        . $errors[$_GET['error']] .
        '</h2>';
}
?>

<form action="<?php echo SRC_PATH; ?>/includes/database/officer.inc.php" method="post">
<div class="flex flex-col h-screen">
<section class="text-gray-700 body-font relative flex-grow">

<div class="container px-5 my-5 mx-auto">

    <div class="flex flex-col text-center w-full mb-12">
        <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">
            Lawyer Registration
        </h1>
        <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
            Add a Lawyer
        </p>
    </div>

    <div class="lg:w-1/2 md:w-2/3 mx-auto">
    <div class="flex flex-wrap -m-2">

        <div class="p-2 w-1/2">
            <label class="block text-sm font-medium text-gray-700">First Name</label>
            <input name="f_name" class="w-full bg-gray-100 border rounded px-3 h-10" required>
        </div>

        <div class="p-2 w-1/2">
            <label class="block text-sm font-medium text-gray-700">Last Name</label>
            <input name="l_name" class="w-full bg-gray-100 border rounded px-3 h-10" required>
        </div>

        <div class="p-2 w-1/2">
            <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
            <input type="date" name="dob" class="w-full bg-gray-100 border rounded px-3 h-10">
        </div>

        <div class="p-2 w-1/2">
            <label class="block text-sm font-medium text-gray-700">Specialization</label>
            <select name="specialization" class="w-full bg-gray-100 border rounded px-3 h-10" required>
                <option value="">Select</option>
                <option value="CRIMINAL">Criminal</option>
                <option value="BAIL">Bail</option>
                <option value="CIVIL">Civil</option>
            </select>
        </div>

        <div class="p-2 w-1/2">
            <label class="block text-sm font-medium text-gray-700">Experience (Years)</label>
            <input type="number" name="experience" min="0"
                   class="w-full bg-gray-100 border rounded px-3 h-10">
        </div>

        <div class="p-2 w-1/2">
            <label class="block text-sm font-medium text-gray-700">Mobile Number</label>
            <input name="mob_number" class="w-full bg-gray-100 border rounded px-3 h-10">
        </div>

        <div class="p-2 w-1/2">
            <label class="block text-sm font-medium text-gray-700">Username</label>
            <input name="username" class="w-full bg-gray-100 border rounded px-3 h-10" required>
        </div>

        <div class="p-2 w-1/2">
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" class="w-full bg-gray-100 border rounded px-3 h-10" required>
        </div>

        <div class="p-2 w-1/2">
            <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" name="cfmpassword" class="w-full bg-gray-100 border rounded px-3 h-10" required>
        </div>

        <div class="p-2 w-full">
            <button name="officer_add" type="submit"
                class="flex mx-auto text-white bg-indigo-500 py-2 px-8 rounded hover:bg-indigo-600">
                Submit
            </button>
        </div>

    </div>
    </div>
</div>

</section>
</div>
</form>

<?php require_once SRC_PATH . "/views/layouts/footer.php"; ?>
