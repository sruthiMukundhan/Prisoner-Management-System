<?php
require "../src/views/layouts/header_unified.php";
?>

<div class="flex items-center justify-center bg-gray-50 pt-12 pb-56 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full">

    <div>
      <img class="mx-auto h-12 w-auto" src="assets/images/police-station.svg" alt="Prison Management System">

      <?php if (isset($_GET['error'])): ?>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-red-600">
          <?php
            if ($_GET['error'] == "emptyFields") echo "Empty fields!!";
            elseif ($_GET['error'] == "wrongcredentials") echo "Wrong username or password!!";
            elseif ($_GET['error'] == "dberror") echo "Database connection error!!";
            elseif ($_GET['error'] == "invalidtype") echo "Invalid user type!!";
          ?>
        </h2>
      <?php endif; ?>

      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        Lawyer Sign In
      </h2>
    </div>

    <form class="mt-8" action="?page=unified-login" method="POST">

      <div class="rounded-md shadow-sm">
        <input name="lawyer_uname" type="text" required
          class="block w-full px-3 py-2 border border-gray-300 rounded-t-md"
          placeholder="Username">

        <input name="lawyer_pwd" type="password" required
          class="block w-full px-3 py-2 border border-gray-300 rounded-b-md"
          placeholder="Password">
      </div>

      <div class="mt-6">
        <button type="submit" name="lawyer_login-submit"
          class="w-full py-2 px-4 rounded-md text-white bg-indigo-600 hover:bg-indigo-500">
          Sign in
        </button>
      </div>

    </form>

  </div>
</div>

<?php require "../src/views/layouts/footer.php"; ?>