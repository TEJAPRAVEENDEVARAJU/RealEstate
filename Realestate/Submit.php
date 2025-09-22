<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["message" => "Unauthorized access"]);
    exit;
}

$conn = new mysqli("sql200.infinityfree.com", "if0_39282857", "G6wDbAohtp4I", "if0_39282857_realestate");

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["message" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid JSON or empty request body"]);
    exit;
}

$name = $data['name'] ?? '';
$phone = $data['phone'] ?? '';
$plot = $data['plot'] ?? '';
$status = $data['status'] ?? '';
$date = $data['date'] ?? date("Y-m-d");

// Validate required fields
if (!$name || !$phone || !$plot || !$status || !$date) {
    http_response_code(422);
    echo json_encode(["message" => "All fields are required"]);
    exit;
}

// Validate date format
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    http_response_code(422);
    echo json_encode(["message" => "Invalid date format"]);
    exit;
}

$registered_date = $booked_date = $agreement_date = null;

if ($status === 'Registered') $registered_date = $date;
if ($status === 'Booked')     $booked_date    = $date;
if ($status === 'Agreement')  $agreement_date = $date;

// Check for duplicate plot
$check = $conn->prepare("SELECT id FROM user_details WHERE plot = ?");
$check->bind_param("s", $plot);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    http_response_code(409);
    echo json_encode(["message" => "This plot is already registered."]);
    exit;
}
$check->close();

// Insert
$stmt = $conn->prepare("INSERT INTO user_details (name, phone, plot, status, registered_date, booked_date, agreement_date)
                        VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $name, $phone, $plot, $status, $registered_date, $booked_date, $agreement_date);

if ($stmt->execute()) {
    echo json_encode(["message" => "Data submitted successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Failed to insert data: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
