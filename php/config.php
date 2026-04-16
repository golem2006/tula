<?php
$host = 'MySQL-8.4';
$username = 'root';
$password = '';
$db = 'tulaGer';

$conn = new mysqli($host, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>