<?php
require_once SRC_PATH . "/includes/init.php";
global $pdo;

/* Get logged-in lawyer */
$lawyer = $_SESSION['userUidLawyer'] ?? null;
$stmt = $pdo->query("
    SELECT 
        lvr.Request_id,
        lvr.Visit_date,
        lvr.Officer_status,
        lvr.Admin_status,
        p.First_name,
        p.Last_name,
        l.Lawyer_uname
    FROM lawyer_visit_request lvr
    LEFT JOIN prisoner p 
        ON lvr.Prisoner_id = p.Prisoner_id
    LEFT JOIN lawyer l 
        ON lvr.Lawyer_id = l.Lawyer_id
");

$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);


require SRC_PATH . "/views/lawyer/lawyer_dashboard.php";