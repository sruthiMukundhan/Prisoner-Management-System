<?php

// ================= DATABASE SETTINGS =================
define('DB_HOST', 'localhost');
define('DB_NAME', 'prisondb');
define('DB_USER', 'root');
define('DB_PASS', '');

// ================= APPLICATION SETTINGS =================
define('APP_NAME', 'Prison Management System');
define('APP_VERSION', '2.0');
define('APP_URL', 'http://localhost/PMS/Prison-Management-System/public/');

// ================= DEBUG MODE =================
define('DEBUG_MODE', true);
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// ================= TIMEZONE =================
date_default_timezone_set('Asia/Kolkata');

// ================= DATABASE CONNECTION FUNCTION =================
function getDBConnection()
{
    try {

        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";

        $pdo = new PDO(
            $dsn,
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );

        return $pdo;

    } catch (PDOException $e) {

        if (DEBUG_MODE) {
            die("Database Connection Failed: " . $e->getMessage());
        } else {
            die("Database connection failed.");
        }

    }
}