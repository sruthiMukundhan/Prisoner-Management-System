<?php

if (!isset($_POST['officer_add'])) {
    header("Location: ../../public/?page=officer&error=clickonsignupbtnerror");
    exit();
}

require 'dbh.inc.php';

/* =========================
   COLLECT INPUTS
========================= */
$f_name       = trim($_POST['f_name'] ?? '');
$l_name       = trim($_POST['l_name'] ?? '');
$dob          = $_POST['dob'] ?? null;
$specialization = $_POST['specialization'] ?? '';
$experience   = $_POST['experience'] ?? 0;
$mob_number   = trim($_POST['mob_number'] ?? '');
$username     = trim($_POST['username'] ?? '');
$password     = $_POST['password'] ?? '';
$cfmpassword  = $_POST['cfmpassword'] ?? '';

/* =========================
   VALIDATIONS
========================= */
if (
    empty($f_name) || empty($l_name) || empty($username) ||
    empty($password) || empty($cfmpassword) || empty($specialization)
) {
    header("Location: ../../public/?page=officer&error=emptyfields");
    exit();
}

if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
    header("Location: ../../public/?page=officer&error=invaliduid");
    exit();
}

if ($password !== $cfmpassword) {
    header("Location: ../../public/?page=officer&error=passwordnotmatched");
    exit();
}

/* =========================
   CHECK EXISTING USER
========================= */
$sql = "SELECT Officer_uname FROM Officer WHERE Officer_uname = :username";
$stmt = $pdo->prepare($sql);
$stmt->execute(['username' => $username]);

if ($stmt->rowCount() > 0) {
    header("Location: ../../public/?page=officer&error=sameuserexistserror");
    exit();
}

/* =========================
   INSERT DATA (TRANSACTION)
========================= */
try {
    $pdo->beginTransaction();

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert Officer (Lawyer)
    $sql1 = "
        INSERT INTO Officer 
        (Officer_uname, Officer_pwd, First_name, Last_name, Title, Date_of_birth, Specialization, Experience)
        VALUES
        (:username, :password, :f_name, :l_name, 'LAWYER', :dob, :specialization, :experience)
    ";

    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute([
        'username'       => $username,
        'password'       => $hashed_password,
        'f_name'         => $f_name,
        'l_name'         => $l_name,
        'dob'            => $dob,
        'specialization' => $specialization,
        'experience'     => $experience
    ]);

    $officer_id = $pdo->lastInsertId();

    // Insert Phone
    if (!empty($mob_number)) {
        $sql2 = "
            INSERT INTO Officer_phone (Officer_phone, Officer_id)
            VALUES (:mob_number, :officer_id)
        ";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([
            'mob_number' => $mob_number,
            'officer_id' => $officer_id
        ]);
    }

    $pdo->commit();

    header("Location: ../../public/?page=officer_view&insert=success");
    exit();

} catch (PDOException $e) {
    $pdo->rollBack();
    header("Location: ../../public/?page=officer&error=sqlerror");
    exit();
}
