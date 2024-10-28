<?php
include('sessionCheck.php');

header('Content-Type: application/json');

// Include database connection
include 'dbConnection.php';

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Prepare the SQL query to skip the first two records
$sql = "SELECT value FROM data WHERE row_id = 0 AND value != '' LIMIT 18446744073709551615 OFFSET 2";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row['value'];  // Store each 'value' in the data array
    }
} else {
    echo json_encode(['message' => 'No data found']);
    exit;
}

echo json_encode(['data' => $data]);

$conn->close();
?>
