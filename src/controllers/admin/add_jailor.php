<?php
require_once SRC_PATH . '/includes/database/dbh.inc.php';
require_once SRC_PATH . '/includes/auth/Auth.php';
require_once SRC_PATH . '/views/layouts/header_unified.php';

global $pdo;
$auth = new Auth($pdo);

if (!$auth->isLoggedIn() || !$auth->hasRole('admin')) {
    redirect('home');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $uname = $_POST['uname'];
    $pwd   = $_POST['pwd'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $dob   = $_POST['dob'];
    $hire  = $_POST['hire_date'];

    $stmt = $pdo->prepare("
        INSERT INTO Jailor 
        (Jailor_uname, Jailor_pwd, First_name, Last_name, Email, Date_of_birth, Hire_date)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([$uname, $pwd, $fname, $lname, $email, $dob, $hire]);

    redirect('add_jailor&success=1');
    exit;
}
?>

<div class="container mx-auto px-6 py-10">

<div class="flex flex-col text-center mb-10">
    <h1 class="text-3xl font-bold mb-2">Add Jailor</h1>
    <p class="text-gray-600">Register a new jailor</p>
</div>

<?php if(isset($_GET['success'])): ?>
<div class="bg-green-500 text-white p-3 rounded mb-6 text-center">
    Jailor Added Successfully ✅
</div>
<?php endif; ?>

<div class="lg:w-1/2 mx-auto">
<form method="POST" class="flex flex-wrap -m-2">

<div class="p-2 w-1/2">
<label>Username</label>
<input name="uname" required class="w-full bg-gray-100 border px-3 h-10 rounded">
</div>

<div class="p-2 w-1/2">
<label>Password</label>
<input name="pwd" required class="w-full bg-gray-100 border px-3 h-10 rounded">
</div>

<div class="p-2 w-1/2">
<label>First Name</label>
<input name="fname" required class="w-full bg-gray-100 border px-3 h-10 rounded">
</div>

<div class="p-2 w-1/2">
<label>Last Name</label>
<input name="lname" required class="w-full bg-gray-100 border px-3 h-10 rounded">
</div>

<div class="p-2 w-1/2">
<label>Email</label>
<input type="email" name="email" required class="w-full bg-gray-100 border px-3 h-10 rounded">
</div>

<div class="p-2 w-1/2">
<label>Date of Birth</label>
<input type="date" name="dob" required class="w-full bg-gray-100 border px-3 h-10 rounded">
</div>

<div class="p-2 w-full">
<label>Hire Date</label>
<input type="date" name="hire_date" required class="w-full bg-gray-100 border px-3 h-10 rounded">
</div>

<div class="p-2 w-full text-center">
<button type="submit"
        class="bg-indigo-600 text-white px-8 py-2 rounded hover:bg-indigo-700">
    Add Jailor
</button>
</div>

</form>
</div>

</div>

<?php require_once SRC_PATH . '/views/layouts/footer.php'; ?>