<?php
include('sessionCheck.php');

header('Content-Type: application/json');

// Include database connection
include 'dbConnection.php';

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Function to fetch data based on row_id
function fetchData($conn, $row_id) {
    $sql = "SELECT value FROM data WHERE row_id = ? AND value != '' LIMIT 100";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $row_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = trim($row['value']);
        }
        // Remove duplicates
        $data = array_unique($data);
    }
    return [
        'data' => $data,
        'count' => count($data)  // Get the count of unique items
    ];
}

// Fetching data
$locations = fetchData($conn, 2);
$teams = fetchData($conn, 1);
$users = fetchData($conn, 0);

// Closing the connection
$conn->close();

// Combine results into a single response
$response = [
    'locations' => $locations,
    'teams' => $teams,
    'users' => $users,
];

echo json_encode($response);
?>
