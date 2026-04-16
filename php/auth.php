<?php
session_start();
require_once('config.php');

ini_set('log_errors', 1);
ini_set('error_log', 'error.log');
set_exception_handler(function ($exception) {
    error_log($exception->getMessage());
});

if (isset($_SESSION['photo']) || isset($_SESSION['id']) || isset($_SESSION['name'])) {
    header('Location: ../index.php');
    exit;
}

$password = $_POST['passw'] ?? '';
$email = filter_var($_POST['mail'] ?? '', FILTER_SANITIZE_EMAIL);

if ($email == 'admin@mail.ru' && $password == '123456') {
    $_SESSION['admin'] = 'true';
    header('Location: ../admin.php');
    exit;
}

if (empty($email) || empty($password)) {
    header('Location: ../index.php');
    exit;
}

$stmt = $conn->prepare("SELECT password, name, id, photo_path FROM `participants` WHERE email = ?");
$stmt->bind_param("s", $email);



if (!$stmt->execute()) {
    header('Location: ../index.php');
    exit;
} else {
    $stmt->store_result();
    if ($stmt->num_rows === 0) {
        header('Location: ../index.php');
        exit;
    }
    $stmt->bind_result($hash, $name, $id, $photo_path);
    $stmt->fetch();
    if (password_verify($password, $hash)) {
        $_SESSION['id'] = $id;
        $_SESSION['photo'] = $photo_path;
        $_SESSION['name'] = $name;
        header('Location: ../index.php');
        exit;
    } else {
        header('Location: ../index.php');
        exit;
    }
}

$conn->close();
exit;
?>