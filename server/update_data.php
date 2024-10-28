<?php
include('sessionCheck.php');

// Database connection parameters
$servername = "localhost";
$username = "your_username"; // Replace with your DB username
$password = "your_password"; // Replace with your DB password
$dbname = "your_database"; // Replace with your DB name

// Create connection
// Include database connection
include 'dbConnection.php';

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Fetch locations
$locationsQuery = "SELECT * FROM locations";
$locationsResult = $conn->query($locationsQuery);

// Fetch teams
$teamsQuery = "SELECT * FROM teams";
$teamsResult = $conn->query($teamsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Update Data</h1>
        
        <h2>Locations</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $locationsResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td>
                            <a href="update_location.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Update</a>
                            <a href="delete_location.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2>Teams</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $teamsResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td>
                            <a href="update_team.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Update</a>
                            <a href="delete_team.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
