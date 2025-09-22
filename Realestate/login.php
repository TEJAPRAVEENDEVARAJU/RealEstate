<?php
ini_set('session.cookie_lifetime', 0);
session_start();
require 'db_config.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo "Please fill all fields";
    exit;
}

$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo "User not found";
    exit;
}

$stmt->bind_result($id, $username, $hashed_password);
$stmt->fetch();

if (password_verify($password, $hashed_password)) {
    $_SESSION['user_id'] = $id;
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    echo "success";  
} else {
    echo "Incorrect password";
}

$stmt->close();
$conn->close();
?>
