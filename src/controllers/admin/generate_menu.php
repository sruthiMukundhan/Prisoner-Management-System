<?php
require_once SRC_PATH.'/includes/database/dbh.inc.php';
global $pdo;

$date = date('Y-m-d');

/* 1️⃣ DELETE OLD MENU FOR TODAY */
$delete = $pdo->prepare("DELETE FROM Daily_Menu WHERE Menu_date = ?");
$delete->execute([$date]);

$meals = ['Breakfast','Lunch','Dinner'];

foreach ($meals as $meal) {

    // Get random carb
    $carb = $pdo->query("
        SELECT * FROM Food_Items 
        WHERE Category='Carbs' 
        ORDER BY RAND() LIMIT 1
    ")->fetch();

    // Get random protein
    $protein = $pdo->query("
        SELECT * FROM Food_Items 
        WHERE Category='Protein' 
        ORDER BY RAND() LIMIT 1
    ")->fetch();

    // Get random fiber or vitamin
    $fiber = $pdo->query("
        SELECT * FROM Food_Items 
        WHERE Category IN ('Fiber','Vitamins') 
        ORDER BY RAND() LIMIT 1
    ")->fetch();

    $foods = [$carb, $protein, $fiber];

    foreach($foods as $food){

        $stmt = $pdo->prepare("
            INSERT INTO Daily_Menu (Menu_date, Meal_type, Food_id, Approved)
            VALUES (?, ?, ?, 0)
        ");

        $stmt->execute([$date, $meal, $food['Food_id']]);
    }
}

redirect('ai_lunch&generated=1');
exit;