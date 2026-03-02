<?php
require_once SRC_PATH . "/includes/init.php";
global $pdo;

/* ================= SESSION ================= */

$lawyerUsername = $_SESSION['userUidLawyer'] ?? null;
if (!$lawyerUsername) {
    header("Location: ?page=signin-lawyer");
    exit;
}

/* ============== GET LAWYER ID ============== */

$stmt = $pdo->prepare("SELECT Lawyer_id FROM lawyer WHERE Lawyer_uname=?");
$stmt->execute([$lawyerUsername]);
$lawyer = $stmt->fetch();
$lawyerId = $lawyer['Lawyer_id'];

/* ============== DELETE NOTE ============== */

if (isset($_GET['delete'])) {
    $noteId = $_GET['delete'];

    $stmt = $pdo->prepare("
        DELETE FROM lawyer_case_notes
        WHERE Note_id=? AND Lawyer_id=?
    ");
    $stmt->execute([$noteId, $lawyerId]);

    header("Location: ?page=lawyer-notes");
    exit;
}

/* ============== UPDATE NOTE ============== */

if (isset($_POST['update_note'])) {

    $stmt = $pdo->prepare("
        UPDATE lawyer_case_notes
        SET Title=?, Note_content=?
        WHERE Note_id=? AND Lawyer_id=?
    ");

    $stmt->execute([
        $_POST['title'],
        $_POST['content'],
        $_POST['note_id'],
        $lawyerId
    ]);

    header("Location: ?page=lawyer-notes");
    exit;
}

/* ============== SAVE NOTE ============== */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['update_note'])) {

    $stmt = $pdo->prepare("
        INSERT INTO lawyer_case_notes
        (Lawyer_id, Prisoner_id, Title, Note_content)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $lawyerId,
        $_POST['prisoner_id'],
        $_POST['title'],
        $_POST['content']
    ]);

    header("Location: ?page=lawyer-notes");
    exit;
}

/* ============== GET ASSIGNED PRISONERS ============== */

$stmt = $pdo->prepare("
    SELECT DISTINCT p.Prisoner_id,
           CONCAT(p.First_name,' ',p.Last_name) AS Full_Name
    FROM prisoner p
    JOIN lawyer_visit_request lvr
        ON lvr.Prisoner_id = p.Prisoner_id
    WHERE lvr.Lawyer_id=?
");
$stmt->execute([$lawyerId]);
$prisoners = $stmt->fetchAll();

/* ============== GET ALL NOTES ============== */

$stmt = $pdo->prepare("
    SELECT n.*, 
           CONCAT(p.First_name,' ',p.Last_name) AS Prisoner_Name
    FROM lawyer_case_notes n
    JOIN prisoner p ON p.Prisoner_id = n.Prisoner_id
    WHERE n.Lawyer_id=?
    ORDER BY n.Created_at DESC
");
$stmt->execute([$lawyerId]);
$notes = $stmt->fetchAll();

require SRC_PATH . "/views/lawyer/lawyer_notes_view.php";