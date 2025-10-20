<?php
session_start();

// Admin credentials (for simplicity, hardcoded. In a real app, use a database)
define("ADMIN_USERNAME", "admin");
define("ADMIN_PASSWORD", "password123"); // Hashed password in a real application

function isAdminLoggedIn() {
    return isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"] === true;
}

function requireAdminLogin() {
    if (!isAdminLoggedIn()) {
        header("Location: index.php");
        exit();
    }
}

function loginAdmin($username, $password) {
    if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
        $_SESSION["admin_logged_in"] = true;
        return true;
    }
    return false;
}

function logoutAdmin() {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
?>