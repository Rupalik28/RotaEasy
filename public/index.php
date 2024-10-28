<!DOCTYPE html>
<html lang="en">

<?php
include('sessionCheck.php');

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

// After successful login
// Get the current hour
$currentHour = date('H'); // 24-hour format

// Determine the greeting based on the current hour
if ($currentHour >= 5 && $currentHour < 12) {
    $greeting = "Good Morning";
} elseif ($currentHour >= 12 && $currentHour < 17) {
    $greeting = "Good Afternoon";
} else {
    $greeting = "Good Evening";
}

?>


<head>
    <?php include '../componemts/head.php'; ?>
</head>

<body class="sb-nav-fixed">
    <?php include '../componemts/header_common.php'; ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include '../componemts/nav_side-Menu.php'; ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4"><?php echo htmlspecialchars($greeting . ", " . $_SESSION['username']); ?></h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <?php include '../componemts/card_index.php'; ?>
                    <br>

                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-user me-1"></i>
                                    Users
                                    <!-- <button class="btn btn-primary btn-sm float-end" onclick="addUser()">Add User</button> -->
                                </div>
                                <div class="card-body">
                                    <table id="userTable" class="table table-bordered">
                                        <!-- <thead>
                                            <tr>
                                                <th>Name</th>
                                            </tr>
                                        </thead> -->
                                        <tbody id="userTableBody">
                                            <!-- User data will be populated here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    Locations
                                    <button class="btn btn-outline-dark btn-sm float-end" onclick="window.location.href='update_team_location.php'">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <table id="locationTable" class="table table-bordered">
                                        <!-- <thead>
                                            <tr>
                                                <th>Location</th>
                                            </tr>
                                        </thead> -->
                                        <tbody id="locationTableBody">
                                            <!-- Location data will be populated here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-users me-1"></i>
                                    Teams
                                    <button class="btn btn-outline-dark btn-sm float-end" onclick="window.location.href='update_team_location.php'">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <table id="teamTable" class="table table-bordered">
                                        <!-- <thead>
                                            <tr>
                                                <th>Team</th>
                                            </tr>
                                        </thead> -->
                                        <tbody id="teamTableBody">
                                            <!-- Team data will be populated here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
            <?php include '../componemts/footer.php'; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script type="module" src="main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fetch user count, location count, and team count
            fetch('../server/load_all.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('location-count').textContent = data.locations.count;
                    document.getElementById('team-count').textContent = data.teams.count;
                    document.getElementById('user-count').textContent = data.users.count;
                })
                .catch(error => console.error('Error fetching data:', error));

            // Fetch user data
            fetch('../server/load_users.php')
                .then(response => response.json())
                .then(data => {
                    const userTableBody = document.getElementById('userTableBody');
                    data.data.forEach(user => {
                        const row = document.createElement('tr');
                        row.innerHTML = `<td>${user}</td>`;
                        userTableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching user data:', error));

            // Fetch location data
            fetch('../server/load_locations.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Fetched data:', data); // Log the entire data object
                    const locationTableBody = document.getElementById('locationTableBody');

                    // Convert the object to an array
                    const locationsArray = Object.values(data.data);

                    if (Array.isArray(locationsArray)) {
                        locationsArray.forEach(location => {
                            const row = document.createElement('tr');
                            row.innerHTML = `<td>${location}</td>`;
                            locationTableBody.appendChild(row);
                        });
                    } else {
                        console.error('Expected data.data to be an array, but got:', locationsArray);
                    }
                })
                .catch(error => console.error('Error fetching location data:', error));


            // Fetch team data
            fetch('../server/load_teams.php')
                .then(response => response.json())
                .then(data => {
                    const teamTableBody = document.getElementById('teamTableBody');
                    // Convert the object to an array
                    const teamsArray = Object.values(data.data);
                    if (Array.isArray(teamsArray)) {
                        teamsArray.forEach(team => {
                            const row = document.createElement('tr');
                            row.innerHTML = `<td>${team}</td>`;
                            teamTableBody.appendChild(row);
                        });
                    } else {
                        console.error('Expected data.data to be an array, but got:', locationsArray);
                    }

                })
                .catch(error => console.error('Error fetching team data:', error));
        });
    </script>
    <script>
        function logout() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "logout.php"; // Redirect to logout script
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>

</html>