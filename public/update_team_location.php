<?php

include('sessionCheck.php');
// The rest of your page code goes here

// Include database connection
include '../server/dbConnection.php';

// Role constants
define("MAIN_ADMIN", 1);
define("SECOND_ADMIN", 2);
define("THIRD_ADMIN", 3);

// Create an associative array to map roles
$roles = [
    MAIN_ADMIN => "Main Admin",
    SECOND_ADMIN => "Second Admin",
    THIRD_ADMIN => "Third Admin",
];

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

    <head>
        <?php include '../componemts/head.php'; ?>
    </head>
</head>

<body class="sb-nav-fixed">
<?php include '../componemts/header_common.php'; ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <?php include '../componemts/nav_side-Menu.php'; ?>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Start Bootstrap
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Update Location/Team</h1>
                    <br>
                    <!-- <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tables</li>
                    </ol> -->

                    <!-- Locations Table -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-map-marker-alt me-1"></i>
                                Locations Table
                            </div>
                            <a href="../server/add_location.php" class="btn btn-primary btn-sm">Add Location</a>
                        </div>
                        <div class="card-body">
                            <table id="locationsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php while ($row = $locationsResult->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td>
                                                <a href="../server/update_location.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Update</a>
                                                <a href="../server/delete_location.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Teams Table -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-users me-1"></i>
                                Teams Table
                            </div>
                            <a href="../server/add_team.php" class="btn btn-primary btn-sm">Add Team</a>
                        </div>
                        <div class="card-body">
                            <table id="teamsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php while ($row = $teamsResult->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td>
                                                <a href="../server/update_team.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Update</a>
                                                <a href="../server/delete_team.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?php include '../componemts/footer.php'; ?>
        </div>
    </div>
    <script>
        // Initialize DataTables
        document.addEventListener('DOMContentLoaded', function() {
            new simpleDatatables.DataTable("#locationsTable");
            new simpleDatatables.DataTable("#teamsTable");
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
</body>

</html>