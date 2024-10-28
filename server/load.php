<?php
// include('sessionCheck.php');

header('Content-Type: application/json');

// Include database connection
include 'dbConnection.php';

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Prepare the SQL query
$sql = "SELECT row_id, column_name, value FROM data";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[$row['row_id']][$row['column_name']] = $row['value'];
}

echo json_encode(['data' => $data]);

$conn->close();
?>
