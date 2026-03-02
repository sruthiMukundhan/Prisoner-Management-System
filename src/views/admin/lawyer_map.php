<?php require "../src/views/layouts/header_unified.php"; ?>

<div class="p-10">
    <h2 class="text-2xl font-bold mb-6">Assign Lawyer to Prisoner</h2>

    <?php if (isset($_GET['assigned'])): ?>
        <p class="text-green-600 mb-4">Assignment Successful!</p>
    <?php endif; ?>

    <form method="POST" class="space-y-4">

        <div>
            <label class="block font-semibold">Select Lawyer</label>
            <select name="lawyer_id" class="border p-2 w-full">
                <?php foreach ($lawyers as $l): ?>
                    <option value="<?= $l['Lawyer_id'] ?>">
                        <?= $l['Lawyer_uname'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block font-semibold">Select Prisoner</label>
            <select name="prisoner_id" class="border p-2 w-full">
                <?php foreach ($prisoners as $p): ?>
                    <option value="<?= $p['Prisoner_id'] ?>">
                        <?= $p['Name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button class="bg-indigo-600 text-white px-6 py-2 rounded">
            Assign
        </button>

    </form>
</div>

<?php require "../src/views/layouts/footer.php"; ?>