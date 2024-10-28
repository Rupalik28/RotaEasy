<?php

include('sessionCheck.php');

// Include database connection
include '../server/dbConnection.php';

// Check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];

    $insertQuery = "INSERT INTO locations (name) VALUES ('$name')";
    if ($conn->query($insertQuery) === TRUE) {
        header("Location: ../public/update_team_location.php"); // Redirect to the table page
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../componemts/head.php'; ?>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <?php include 'logo.php'; ?>
        <!-- Navbar code remains the same -->
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <!-- Sidebar code remains the same -->
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Add Location</h1>
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Location Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Location</button>
                                <a href="../public/update_team_location.php" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
            <!-- Footer code remains the same -->
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
