<?php
/**
 * Authentication and Session Management
 */
session_start();

/* ──── AJAX / JSON handler ──── */
$isJson = false;
$inputData = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ct = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    if (strpos($ct, 'application/json') !== false) {
        $inputData = json_decode(file_get_contents("php://input"), true) ?: [];
        $isJson = true;
    } else {
        $inputData = $_POST;
    }
}
$action = $isJson ? ($inputData['action'] ?? '') : ($_POST['action'] ?? '');

/* ──── Logout ──── */
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: index.php");
    exit;
}

/* ──── Login ──── */
$loginError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'login') {
    $u = trim($inputData['username'] ?? '');
    $p = trim($inputData['password'] ?? '');
    
    $success = false;
    if ($u === 'admin' && $p === 'Retsab21ACA*') {
        $_SESSION['admin_logged_in'] = true;
        $success = true;
    }

    if ($isJson) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Acceso concedido. Redirigiendo...' : 'Usuario o contraseña incorrectos.'
        ]);
        exit;
    }

    if ($success) {
        header("Location: index.php");
        exit;
    }
    $loginError = 'Usuario o contraseña incorrectos.';
}

$isLoggedIn = !empty($_SESSION['admin_logged_in']);
