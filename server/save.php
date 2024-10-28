<?php
include('../public/sessionCheck.php');
header('Content-Type: application/json');

// Include database connection
include 'dbConnection.php';

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Get the data from the POST request
$data = json_decode(file_get_contents('php://input'), true)['data'];

// Clear existing data
$conn->query("TRUNCATE TABLE data");

// Insert new data
foreach ($data as $row_id => $row) {
    foreach ($row as $column_name => $value) {
        $value = $conn->real_escape_string($value);
        $sql = "INSERT INTO data (row_id, column_name, value) VALUES ('$row_id', '$column_name', '$value')";
        if (!$conn->query($sql)) {
            echo json_encode(['error' => 'Error: ' . $conn->error]);
            exit;
        }
    }
}

echo json_encode(['success' => 'Data saved successfully']);

$conn->close();
?>
