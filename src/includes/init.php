<?php
/**
 * Application Initialization
 */

// --------------------
// SESSION
// --------------------
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --------------------
// CONFIG
// --------------------
require_once dirname(dirname(__DIR__)) . '/config/config.php';
require_once dirname(dirname(__DIR__)) . '/config/constants.php';

// --------------------
// CORE
// --------------------
require_once SRC_PATH . '/includes/utils/ErrorHandler.php';
require_once SRC_PATH . '/includes/utils/Validator.php';
require_once SRC_PATH . '/includes/auth/Auth.php';
require_once SRC_PATH . '/includes/controllers/BaseController.php';
require_once SRC_PATH . '/Router.php';
require_once __DIR__ . '/utils/helpers.php';

// --------------------
// ERROR HANDLING
// --------------------
ErrorHandler::getInstance()->initialize();

// --------------------
// TIMEZONE
// --------------------
date_default_timezone_set('Asia/Kolkata');

// --------------------
// DATABASE
// --------------------
try {
    $pdo = getDBConnection();
} catch (PDOException $e) {
    ErrorHandler::getInstance()->logDatabaseError($e);
    die(DEBUG_MODE
        ? "Database connection failed: " . $e->getMessage()
        : "Database connection failed."
    );
}

// --------------------
// AUTH
// --------------------
global $auth;
$auth = new Auth($pdo);

// --------------------
// SESSION EXPIRY
// --------------------
if ($auth->isLoggedIn() && $auth->isSessionExpired()) {
    $auth->logout();
    redirect('home');
    exit;
}
