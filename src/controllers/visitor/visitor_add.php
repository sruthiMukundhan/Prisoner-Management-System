<?php
require_once SRC_PATH . '/includes/database/dbh.inc.php';
require_once SRC_PATH . '/includes/auth/Auth.php';
require_once SRC_PATH . '/views/layouts/header_unified.php';

global $pdo;
$auth = new Auth($pdo);

/* =======================
   AUTH CHECK (ADMIN ONLY)
======================= */
if (!$auth->isLoggedIn() || !$auth->hasRole('admin')) {
    redirect('home');
    exit;
}

/* =======================
   HANDLE FORM SUBMIT
======================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $f_name      = trim($_POST['f_name']);
    $l_name      = trim($_POST['l_name']);
    $aadhaar     = trim($_POST['aadhaar']);
    $date_visit  = $_POST['date_visit'];
    $time_slot   = $_POST['time_slot'];
    $prisoner_id = (int) $_POST['prisoner_id'];

    if (!preg_match('/^[0-9]{12}$/', $aadhaar)) {
        die("Invalid Aadhaar number");
    }

    try {

        $pdo->beginTransaction();

        /* Insert visitor only if not exists */
        $check = $pdo->prepare("SELECT Aadhaar FROM Visitor WHERE Aadhaar = ?");
        $check->execute([$aadhaar]);

        if (!$check->fetch()) {
            $stmtVisitor = $pdo->prepare("
                INSERT INTO Visitor (Aadhaar, First_name, Last_name)
                VALUES (?, ?, ?)
            ");
            $stmtVisitor->execute([$aadhaar, $f_name, $l_name]);
        }

        /* Insert visit */
        $stmtVisit = $pdo->prepare("
            INSERT INTO Visit (Visitor_aadhaar, Date_visit, Time_slot, Prisoner_id, Status)
            VALUES (?, ?, ?, ?, 'Pending')
        ");

        $stmtVisit->execute([
            $aadhaar,
            $date_visit,
            $time_slot,
            $prisoner_id
        ]);

        $pdo->commit();

header("Location: ?page=visitor-add&success=1");
exit;
    } catch (PDOException $e) {

        $pdo->rollBack();
        die("Database Error: " . $e->getMessage());
    }
}

/* =======================
   FETCH PRISONERS
======================= */
$stmt = $pdo->query("
    SELECT Prisoner_id, First_name, Last_name
    FROM Prisoner
    WHERE Status_inout = 'in'
");
$prisoners = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if (isset($_GET['success'])): ?>
    <div class="bg-green-500 text-white p-3 rounded mb-4 text-center">
        Visitor Added Successfully ✅
    </div>
<?php endif; ?>

<!-- =======================
     VISITOR FORM
======================= -->

<form method="POST" action="?page=visitor-add">
    <section class="text-gray-700 body-font relative">
        <div class="container px-5 py-10 mx-auto">

            <div class="flex flex-col text-center mb-10">
                <h1 class="text-3xl font-bold mb-2">Visitor Registration</h1>
                <p class="text-gray-600">Add a Visitor</p>
            </div>

            <div class="lg:w-1/2 mx-auto">
                <div class="flex flex-wrap -m-2">

                    <div class="p-2 w-1/2">
                        <label>First Name</label>
                        <input name="f_name" required
                               class="w-full bg-gray-100 border px-3 h-10 rounded">
                    </div>

                    <div class="p-2 w-1/2">
                        <label>Last Name</label>
                        <input name="l_name" required
                               class="w-full bg-gray-100 border px-3 h-10 rounded">
                    </div>

                    <div class="p-2 w-1/2">
                        <label>Aadhaar</label>
                        <input name="aadhaar"
                               maxlength="12"
                               inputmode="numeric"
                               pattern="[0-9]{12}"
                               required
                               oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                               class="w-full bg-gray-100 border px-3 h-10 rounded">
                    </div>

                    <div class="p-2 w-1/2">
                        <label>Date</label>
                        <input type="date" name="date_visit" required
                               class="w-full bg-gray-100 border px-3 h-10 rounded">
                    </div>

                    <div class="p-2 w-1/2">
                        <label>Time Slot</label>
                        <select name="time_slot" required
                                class="w-full bg-gray-100 border px-3 h-10 rounded">
                            <option value="">Select Time Slot</option>
                            <option value="09:00 - 10:00">09:00 – 10:00</option>
                            <option value="10:00 - 11:00">10:00 – 11:00</option>
                            <option value="11:00 - 12:00">11:00 – 12:00</option>
                            <option value="14:00 - 15:00">14:00 – 15:00</option>
                            <option value="15:00 - 16:00">15:00 – 16:00</option>
                        </select>
                    </div>

                    <div class="p-2 w-1/2">
                        <label>Prisoner</label>
                        <select name="prisoner_id" required
                                class="w-full bg-gray-100 border px-3 h-10 rounded">
                            <option value="">Select Prisoner</option>
                            <?php foreach ($prisoners as $p): ?>
                                <option value="<?= $p['Prisoner_id'] ?>">
                                    PRI<?= $p['Prisoner_id'] ?> –
                                    <?= htmlspecialchars($p['First_name'] . ' ' . $p['Last_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="p-2 w-full text-center">
                        <button type="submit"
                                class="bg-indigo-600 text-white px-8 py-2 rounded">
                            Add Visitor
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </section>
</form>

<?php require_once SRC_PATH . '/views/layouts/footer.php'; ?>