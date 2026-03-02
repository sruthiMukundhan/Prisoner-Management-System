<?php
require_once SRC_PATH . "/includes/init.php";
global $pdo;

if (!isset($_SESSION['userUidLawyer'])) {
    redirect('home');
    exit;
}

$lawyerUsername = $_SESSION['userUidLawyer'];

/* ===============================
   GET LAWYER ID
================================= */
$stmt = $pdo->prepare("
    SELECT Lawyer_id 
    FROM Lawyer 
    WHERE Lawyer_uname = ?
");
$stmt->execute([$lawyerUsername]);
$lawyerId = $stmt->fetchColumn();

/* ===============================
   FETCH ALL PRISONERS
   (Simple version - like before)
================================= */
$stmt = $pdo->query("
    SELECT Prisoner_id,
           CONCAT(First_name,' ',Last_name) AS Full_Name
    FROM Prisoner
");
$prisoners = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ===============================
   HANDLE VISIT REQUEST
================================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $prisonerId = $_POST['prisoner_id'];
    $visitDate  = $_POST['visit_date'];

    $stmt = $pdo->prepare("
        INSERT INTO Lawyer_Visit_Request
        (Lawyer_id, Prisoner_id, Visit_date, Status, Officer_status, Admin_status)
        VALUES (?, ?, ?, 'Pending', 'Pending', 'Pending')
    ");

    $stmt->execute([$lawyerId, $prisonerId, $visitDate]);

    header("Location: ?page=lawyer-visit&requested=1");
    exit;
}

/* ===============================
   FETCH ALL VISITS OF THIS LAWYER
================================= */
$stmt = $pdo->prepare("
    SELECT lvr.*,
           CONCAT(p.First_name,' ',p.Last_name) AS Full_Name
    FROM Lawyer_Visit_Request lvr
    JOIN Prisoner p 
        ON lvr.Prisoner_id = p.Prisoner_id
    WHERE lvr.Lawyer_id = ?
    ORDER BY lvr.Visit_date DESC
");
$stmt->execute([$lawyerId]);
$visits = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* LOAD VIEW */
require SRC_PATH . "/views/lawyer/lawyer_visit.php";