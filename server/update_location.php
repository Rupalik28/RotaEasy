<?php
include('sessionCheck.php');

// Include database connection
include 'dbConnection.php';

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$id = $_GET['id'];
$locationQuery = "SELECT * FROM locations WHERE id = ?";
$stmt = $conn->prepare($locationQuery);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$location = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Location</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Update Location</h1>
        <form id="updateLocationForm">
            <input type="hidden" name="id" value="<?php echo $location['id']; ?>">
            <div class="form-group">
                <label for="name">Location Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $location['name']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update Location</button>
        </form>
    </div>

    <script>
        document.getElementById('updateLocationForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('update_location_process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Location updated successfully!');
                    window.location.href = '../public/update_team_location.php';
                } else {
                    alert('Failed to update location.');
                }
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
