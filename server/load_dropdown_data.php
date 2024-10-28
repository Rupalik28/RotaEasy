<?php
//include('sessionCheck.php');

header('Content-Type: application/json');

// Include database connection
include 'dbConnection.php';

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Function to fetch data from a table
function fetchData($conn, $tableName) {
    $sql = "SELECT name FROM $tableName WHERE name != ''";
    $result = $conn->query($sql);
    $data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = trim($row['name']);
        }
    }
    return array_unique($data);
}

// Fetch team names and location names
$teams = fetchData($conn, 'teams');
$locations = fetchData($conn, 'locations');

// Return data as JSON
echo json_encode(['teams' => $teams, 'locations' => $locations]);

$conn->close();
?>
