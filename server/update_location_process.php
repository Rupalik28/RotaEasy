<?php
include('sessionCheck.php');

// Include database connection
include 'dbConnection.php';

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$id = $_POST['id'];
$name = $_POST['name'];

$sql = "UPDATE locations SET name = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $name, $id);
$response = [];

if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}

$stmt->close();
$conn->close();
echo json_encode($response);
?>
