<?php
require_once SRC_PATH . '/includes/init.php';
global $pdo;

/* IMPORTANT: JSON RESPONSE */
header('Content-Type: application/json');

$data = [];

/* Total Prisoners */
$data['Total_Prisoners'] = $pdo->query("
    SELECT COUNT(*) 
    FROM Prisoner 
    WHERE Status_inout='in'
")->fetchColumn();

/* Active Officers */
$data['Active_Officers'] = $pdo->query("
    SELECT COUNT(*) 
    FROM Officer 
    WHERE Status='active'
")->fetchColumn();

/* Today Approved Visits */
$data['Today_Visits'] = $pdo->query("
    SELECT COUNT(*) 
    FROM Visit
    WHERE Date_visit = CURDATE()
    AND Officer_status='Approved'
    AND Lawyer_status='Approved'
")->fetchColumn();

/* High Risk */
$data['High_Risk_Prisoners'] = $pdo->query("
    SELECT COUNT(*) 
    FROM Prisoner
    WHERE Risk_level='High'
    AND Status_inout='in'
")->fetchColumn();

/* Violent Crimes */
$data['Violent_Criminals'] = $pdo->query("
    SELECT COUNT(*) 
    FROM Prisoner
    WHERE Crime_category='Violent'
    AND Status_inout='in'
")->fetchColumn();

/* OUTPUT JSON ONLY */
echo json_encode($data);
exit;