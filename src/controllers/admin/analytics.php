<?php
require_once SRC_PATH . "/includes/init.php";
global $pdo;

/* BASIC COUNTS */
$totalPrisoners = $pdo->query("
    SELECT COUNT(*) FROM Prisoner WHERE Status_inout='in'
")->fetchColumn();

$totalVisits = $pdo->query("SELECT COUNT(*) FROM Visit")->fetchColumn();

/* SECTION OCCUPANCY */
$sections = $pdo->query("
    SELECT Section_name, Capacity, Current_population
    FROM Section
")->fetchAll(PDO::FETCH_ASSOC);

/* APPROVAL RATE */
$approvalData = $pdo->query("
    SELECT
        COUNT(*) as total,
        SUM(
            CASE 
                WHEN Officer_status='Approved'
                 AND Lawyer_status='Approved'
                THEN 1 
                ELSE 0 
            END
        ) as approved
    FROM Visit
")->fetch(PDO::FETCH_ASSOC);

$approvalRate = $approvalData['total'] > 0
    ? round(($approvalData['approved'] / $approvalData['total']) * 100)
    : 0;

$approvalRate = $approvalData['total'] > 0
    ? round(($approvalData['approved'] / $approvalData['total']) * 100, 2)
    : 0;

/* HIGH RISK HEATMAP DATA */
$riskStats = $pdo->query("
    SELECT Risk_level, COUNT(*) as count
    FROM Prisoner
    WHERE Status_inout='in'
    GROUP BY Risk_level
")->fetchAll(PDO::FETCH_ASSOC);

require SRC_PATH . "/views/admin/analytics.php";