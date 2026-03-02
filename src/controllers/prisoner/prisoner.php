<?php
require_once SRC_PATH . "/views/layouts/header_unified.php";

?>

<h2 class="text-2xl font-bold mb-4">Add Prisoner</h2>

<form action="?page=prisoner_post" method="post"
      class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <input type="text" name="prisoner_name"
           placeholder="Prisoner Name"
           class="border p-2" required>

    <input type="number" name="age" min="10"
           placeholder="Age"
           class="border p-2" required>

    <select name="gender" class="border p-2" required>
        <option value="">Select Gender</option>
        <option value="MALE">Male</option>
        <option value="FEMALE">Female</option>
        <option value="OTHER">Other</option>
    </select>

    <!-- Crime -->
    <select name="crime_id" class="border p-2" required>
        <option value="">Select Crime</option>
        <?php
        $crimes = $pdo->query("SELECT crime_id, crime_name FROM crime");
        foreach ($crimes as $c) {
            echo "<option value='{$c['crime_id']}'>{$c['crime_name']}</option>";
        }
        ?>
    </select>

    <!-- IPC -->
    <select name="ipc_id" class="border p-2" required>
        <option value="">Select IPC Section</option>
        <?php
        $ipcs = $pdo->query("SELECT ipc_id, ipc_section FROM ipc_master");
        foreach ($ipcs as $i) {
            echo "<option value='{$i['ipc_id']}'>{$i['ipc_section']}</option>";
        }
        ?>
    </select>

    <input type="number" name="sentence_years" min="0"
           placeholder="Sentence (Years)"
           class="border p-2">

    <select name="risk_level" class="border p-2" required>
        <option value="">Risk Level</option>
        <option value="LOW">Low</option>
        <option value="MEDIUM">Medium</option>
        <option value="HIGH">High</option>
    </select>

    <button type="submit" name="prisoner_add"
            class="bg-indigo-600 text-white p-2 rounded col-span-full">
        Add Prisoner
    </button>

</form>

<?php require_once SRC_PATH . "/views/layouts/footer.php"; ?>
