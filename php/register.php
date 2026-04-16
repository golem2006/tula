<?php
session_start();
require_once('config.php');

// Initialize response array
$response = [
    'success' => false,
    'message' => '',
    'errors' => []
];

// Validate and sanitize inputs
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$name = htmlspecialchars($_POST['name']);
$surname = htmlspecialchars($_POST['surname']);
$age = intval($_POST['age']);
$gender = htmlspecialchars($_POST['gender']);
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];
$agreement = isset($_POST['agreement']) ? true : false;

// Validate required fields
if (empty($email) || empty($name) || empty($surname) || empty($age) || empty($gender) || empty($password) || empty($password_confirm) || !$agreement) {
    $response['message'] = 'Все обязательные поля должны быть заполнены';
    $response['errors'][] = 'Пропущены обязательные поля';
    echo json_encode($response);
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['errors'][] = 'Некорректный email';
}

// Validate password match
if ($password !== $password_confirm) {
    $response['errors'][] = 'Пароли не совпадают';
}

// Validate age
if ($age < 1 || $age > 120) {
    $response['errors'][] = 'Некорректный возраст';
}

// If there are errors, return them
if (!empty($response['errors'])) {
    $response['message'] = 'Исправьте следующие ошибки: ' . implode(', ', $response['errors']);
    echo json_encode($response);
    exit;
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Handle file upload
$photo_path = null;
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $new_filename = uniqid() . '.' . $file_ext;
    $photo_path = $upload_dir . $new_filename;

    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path)) {
        $response['errors'][] = 'Ошибка загрузки файла';
        echo json_encode($response);
        exit;
    }
} else {
    $photo_path = 'static/pfp.jpg';
}

// Insert main participant
$stmt = $conn->prepare("INSERT INTO participants (email, name, surname, age, gender, password, photo_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssisss", $email, $name, $surname, $age, $gender, $hashed_password, $photo_path);

if (!$stmt->execute()) {
    $response['message'] = 'Ошибка при регистрации: ' . $stmt->error;
    echo json_encode($response);
    exit;
}

$participant_id = $stmt->insert_id;
$_SESSION['id'] = $participant_id;
$_SESSION['photo'] = $photo_path;
$_SESSION['name'] = $name;
$stmt->close();

// Insert family members if any
if (isset($_POST['family']) && is_array($_POST['family'])) {
    $family_stmt = $conn->prepare("INSERT INTO family_members (participant_id, surname, name, age, gender) VALUES (?, ?, ?, ?, ?)");

    foreach ($_POST['family'] as $member) {
        if (!empty($member['name']) || !empty($member['surname'])) {
            $family_surname = htmlspecialchars($member['surname']);
            $family_name = htmlspecialchars($member['name']);
            $family_age = isset($member['age']) ? intval($member['age']) : null;
            $family_gender = htmlspecialchars($member['gender']);

            $family_stmt->bind_param("issis", $participant_id, $family_surname, $family_name, $family_age, $family_gender);
            $family_stmt->execute();
        }
    }

    $family_stmt->close();
}

// Success response
$response['success'] = true;
$response['message'] = 'Регистрация успешна!';
echo json_encode($response);

$conn->close();
?>