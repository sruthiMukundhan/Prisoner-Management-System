<?php
require_once '../src/includes/database.php';
session_start();

$id = $_SESSION['user_id'];

$query = "SELECT Crime_category, Risk_level, Crimes FROM Prisoner_Details WHERE Prisoner_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
?>

<h2>Crime & Risk</h2>
<hr><br>

<p><strong>Category:</strong> <?= $data['Crime_category']; ?></p>
<p><strong>Risk Level:</strong> <?= $data['Risk_level']; ?></p>
<p><strong>Crimes:</strong> <?= $data['Crimes']; ?></p>