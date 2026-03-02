<?php

if (isset($_POST['crime_prisoner_add'])) {

    require 'dbh.inc.php';

    $f_name     = $_POST['f_name'] ?? '';
    $l_name     = $_POST['l_name'] ?? '';
    $date_in    = $_POST['date_in'] ?? '';
    $date_out   = $_POST['date_out'] ?? null;
    $dob        = $_POST['dob'] ?? '';
    $height     = $_POST['height'] ?? '';
    $addr       = $_POST['addr'] ?? '';
    $section_id = $_POST['section_id'] ?? '';
    $ident_mark = $_POST['identification_mark'] ?? '';
    $status_inout = 'in';

    // DEFAULTS for required DB columns
    $weight = 0;
    $crime_category = 'General';
    $risk_level = 'Low';
    $medical_conditions = 'None';
    $emergency_contact = 'NA';
    $created_date = date('Y-m-d');

    if (
        empty($f_name) || empty($l_name) || empty($date_in) ||
        empty($dob) || empty($height) || empty($addr) ||
        empty($section_id) || empty($ident_mark)
    ) {
        header("Location: /PMS/Prison-Management-System/public/index.php?page=crime&error=emptyfields");
        exit();
    }

    /* PHOTO */
    $photoName = null;

    if (!empty($_FILES['photo']['name'])) {

        if ($_FILES['photo']['size'] > 6 * 1024 * 1024) {
            header("Location: /PMS/Prison-Management-System/public/index.php?page=crime&error=filesize");
            exit();
        }

        $allowed = ['image/jpeg','image/png','image/jpg'];
        if (!in_array($_FILES['photo']['type'], $allowed)) {
            header("Location: /PMS/Prison-Management-System/public/index.php?page=crime&error=filetype");
            exit();
        }

        $dir = '../../public/uploads/prisoners/';
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photoName = uniqid('prisoner_', true) . '.' . $ext;

        move_uploaded_file($_FILES['photo']['tmp_name'], $dir . $photoName);
    }

    try {
        $sql = "INSERT INTO prisoner
        (First_name, Last_name, Date_in, Dob, Height, Weight, Date_out, Address,
         Section_id, Status_inout, Crime_category, Risk_level,
         Medical_conditions, Emergency_contact, Created_date,
         identification_mark, photo)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $f_name,
            $l_name,
            $date_in,
            $dob,
            $height,
            $weight,
            $date_out,
            $addr,
            $section_id,
            $status_inout,
            $crime_category,
            $risk_level,
            $medical_conditions,
            $emergency_contact,
            $created_date,
            $ident_mark,
            $photoName
        ]);

        header("Location: /PMS/Prison-Management-System/public/index.php?page=successcrime_prisoner");
        exit();

    } catch (PDOException $e) {
        echo "<pre style='color:red'>";
        echo $e->getMessage();
        echo "</pre>";
        exit();
    }
}
