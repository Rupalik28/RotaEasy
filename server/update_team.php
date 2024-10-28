<?php
include('sessionCheck.php');

// Include database connection
include 'dbConnection.php';

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$id = $_GET['id'];
$teamQuery = "SELECT * FROM teams WHERE id = ?";
$stmt = $conn->prepare($teamQuery);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$team = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Team</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Update Team</h1>
        <form id="updateTeamForm">
            <input type="hidden" name="id" value="<?php echo $team['id']; ?>">
            <div class="form-group">
                <label for="name">Team Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $team['name']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update Team</button>
        </form>
    </div>

    <script>
        document.getElementById('updateTeamForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('update_team_process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Team updated successfully!');
                    window.location.href = '../public/update_team_location.php';
                } else {
                    alert('Failed to update team.');
                }
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
