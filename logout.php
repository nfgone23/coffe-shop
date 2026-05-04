<?php
session_start();

if (isset($_SESSION['user_email'])) {
    $log = date('Y-m-d H:i:s') . " | " . $_SERVER['REMOTE_ADDR'] . " | " . $_SESSION['user_email'] . " | LOGOUT" . PHP_EOL;
    file_put_contents('logs/auth.log', $log, FILE_APPEND);
}

session_destroy();
header('Location: login.php');
exit;