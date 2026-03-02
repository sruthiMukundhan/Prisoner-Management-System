<?php
require_once SRC_PATH . "/views/layouts/header_unified.php";

if (!$auth->isLoggedIn() || !$auth->hasRole('officer')) {
    redirect('home');
}

$errors = [
    "emptyfields" => "Please fill all required fields.",
    "sqlerror"    => "Database error occurred. Please try again.",
    "filesize"    => "Please upload an image within 6 MB.",
    "filetype"    => "Only JPG and PNG images are allowed."
];

if (isset($_SESSION['userUidOfficer'])) {

    if (isset($_GET['error']) && isset($errors[$_GET['error']])) {
        echo '<h2 class="mt-6 text-center text-2xl font-bold text-red-600">'
            . $errors[$_GET['error']] .
            '</h2>';
    }
?>
<form action="/PMS/Prison-Management-System/public/index.php?page=crime"
      method="post"
      enctype="multipart/form-data">

    <div class="flex flex-col h-screen">
        <section class="text-gray-700 body-font relative flex-grow">
            <div class="container px-5 my-5 mx-auto">

                <div class="flex flex-col text-center w-full mb-12">
                    <h1 class="sm:text-3xl text-2xl font-medium mb-4 text-gray-900">
                        Crime Registration
                    </h1>
                    <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
                        It is mandatory to enter all details
                    </p>
                </div>

                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                    <div class="flex flex-wrap -m-2">

                        <div class="p-2 w-1/2">
                            <label>First Name</label>
                            <input name="f_name" class="w-full bg-gray-100 rounded border px-3 h-10" />
                        </div>

                        <div class="p-2 w-1/2">
                            <label>Last Name</label>
                            <input name="l_name" class="w-full bg-gray-100 rounded border px-3 h-10" />
                        </div>

                        <div class="p-2 w-1/2">
                            <label>Date In</label>
                            <input name="date_in" type="date"
                                   class="w-full bg-gray-100 rounded border px-3 h-10" />
                        </div>

                        <div class="p-2 w-1/2">
                            <label>Date Out</label>
                            <input name="date_out" type="date"
                                   class="w-full bg-gray-100 rounded border px-3 h-10" />
                        </div>

                        <div class="p-2 w-1/2">
                            <label>Date of Birth</label>
                            <input name="dob" type="date"
                                   class="w-full bg-gray-100 rounded border px-3 h-10" />
                        </div>

                        <div class="p-2 w-1/2">
                            <label>Height (cm)</label>
                            <input name="height"
                                   class="w-full bg-gray-100 rounded border px-3 h-10" />
                        </div>

                        <div class="p-2 w-full">
                            <label>Address</label>
                            <textarea name="addr"
                                      class="w-full bg-gray-100 rounded border px-3 h-16"></textarea>
                        </div>

                        <div class="p-2 w-1/2">
    <label>Section</label>
    <select name="section_id"
            class="w-full bg-gray-100 rounded border px-3 h-10" required>
        <option value="">Select Section</option>

        <?php
        $stmt = $pdo->query("SELECT Section_id FROM section");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='{$row['Section_id']}'>
                    Section {$row['Section_id']}
                  </option>";
        }
        ?>
    </select>
</div>


                        <div class="p-2 w-1/2">
                            <label>Identification Mark</label>
                            <input name="identification_mark"
                                   class="w-full bg-gray-100 rounded border px-3 h-10" />
                        </div>

                        <div class="p-2 w-full">
                            <label>Prisoner Photograph</label>
                            <input type="file"
                                   name="photo"
                                   accept="image/*"
                                   class="w-full bg-gray-100 rounded border px-3 py-2" />
                        </div>

                        <div class="p-2 w-full">
                            <button name="crime_prisoner_add" type="submit"
                                class="flex mx-auto text-white bg-indigo-500 py-2 px-8 rounded text-lg">
                                Submit
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </section>
    </div>
</form>

<?php
}

require_once SRC_PATH . "/views/layouts/footer.php";
