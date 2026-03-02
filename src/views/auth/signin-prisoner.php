<?php
require "../src/views/layouts/header_unified.php";
?>

<div class="flex items-center justify-center bg-gray-50 pt-12 pb-56 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full">

    <div>
      <img class="mx-auto h-12 w-auto" src="assets/images/police-station.svg" alt="Prison Management System">

      <?php
      if (isset($_GET['error'])) {
          if ($_GET['error'] == "emptyFields") {
              echo '<h2 class="mt-6 text-center text-2xl font-extrabold text-red-600">
                    Empty fields!!
                    </h2>';
          } elseif ($_GET['error'] == "wrongcredentials") {
              echo '<h2 class="mt-6 text-center text-2xl font-extrabold text-red-600">
                    Wrong username or password!!
                    </h2>';
          } elseif ($_GET['error'] == "dberror") {
              echo '<h2 class="mt-6 text-center text-2xl font-extrabold text-red-600">
                    Database connection error!!
                    </h2>';
          }
      }
      ?>

      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        Prisoner Sign In
      </h2>
    </div>

    <!-- PRISONER LOGIN FORM -->
    <form class="mt-8" action="?page=unified-login" method="POST">

      <div class="rounded-md shadow-sm">
        <div>
          <input
            name="prisoner_uname"
            type="text"
            required
            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:border-indigo-500 sm:text-sm"
            placeholder="Prisoner ID / Username"
          >
        </div>

        <div class="-mt-px">
          <input
            name="prisoner_pwd"
            type="password"
            required
            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:border-indigo-500 sm:text-sm"
            placeholder="Password"
          >
        </div>
      </div>

      <div class="mt-6">
        <button
          name="prisoner_login-submit"
          type="submit"
          class="group relative w-full flex justify-center py-2 px-4 text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none transition duration-150"
        >
          <span class="absolute left-0 inset-y-0 flex items-center pl-3">
            <svg class="h-5 w-5 text-indigo-300 group-hover:text-indigo-200" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
            </svg>
          </span>
          Sign in
        </button>
      </div>

    </form>

  </div>
</div>

<?php
require "../src/views/layouts/footer.php";
?>
