<?php
/**
 * Unified Login Handler
 * 
 * Handles login for all user types using the unified Auth class
 */

require_once SRC_PATH . '/includes/auth/Auth.php';
require_once SRC_PATH . '/includes/database/dbh.inc.php';
require_once SRC_PATH . '/includes/utils/ErrorHandler.php';

$auth = new Auth($pdo);
$errorHandler = ErrorHandler::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userType = '';
    $username = '';
    $password = '';

    /* =======================
       ADMIN LOGIN
    ======================= */
    if (isset($_POST['admin_login-submit'])) {
        $userType = 'admin';
        $username = $_POST['admin_uname'] ?? '';
        $password = $_POST['admin_pwd'] ?? '';
    }

    /* =======================
       OFFICER LOGIN
    ======================= */
    elseif (isset($_POST['officer_login-submit'])) {
        $userType = 'officer';
        $username = $_POST['officer_uname'] ?? '';
        $password = $_POST['officer_pwd'] ?? '';
    }


    /* =======================
   LAWYER LOGIN
======================= */
elseif (isset($_POST['lawyer_login-submit'])) {
    $userType = 'lawyer';
    $username = $_POST['lawyer_uname'] ?? '';
    $password = $_POST['lawyer_pwd'] ?? '';
}

    /* =======================
       PRISONER LOGIN (NEW)
    ======================= */
    elseif (isset($_POST['prisoner_login-submit'])) {
        $userType = 'prisoner';
        $username = $_POST['prisoner_uname'] ?? '';
        $password = $_POST['prisoner_pwd'] ?? '';
    }

    /* =======================
       PROCESS LOGIN
    ======================= */
    if ($userType) {

        $result = $auth->login($userType, $username, $password);

        if ($result['success']) {

            $errorHandler->log(
                "Successful login for {$userType}: {$username}",
                'INFO'
            );

            header("Location: " . $result['redirect']);
            exit;

        } else {

            $errorHandler->logAuthError(
                "Failed login attempt",
                [
                    'user' => $username,
                    'type' => $userType,
                    'reason' => $result['message'],
                    'ip' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown'
                ]
            );

            header("Location: " . $result['redirect']);
            exit;
        }

    } else {
        header("Location: ?page=home");
        exit;
    }

} else {
    header("Location: ?page=home");
    exit;
}
