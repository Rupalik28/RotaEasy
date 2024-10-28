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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tables - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <!-- Handsontable CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable@latest/dist/handsontable.full.min.css">
    <link href="css/styles.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../styles/styles.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
</head>

<body class="sb-nav-fixed">
<?php include '../componemts/nav_table.php'; ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
        <?php include '../componemts/nav_side-Menu.php'; ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <br>
                    <div class="card mb-4 fixed">
                        <div class="card-body">
                            <div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
                                <select id="yearFilter" class="form-control" style="width: auto;">
                                    <option value="" disabled selected>Filter By Year</option>
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>
                                </select>
                                <select id="teamFilter" class="form-control" style="width: auto;">
                                    <option value="" disabled selected>Filter By Team</option>
                                </select>


                                <select id="locFilter" class="form-control" style="width: auto;">
                                    <option value="" disabled selected>Filter By Location</option>
                                </select>

                                <select id="month-filter" class="form-control" style="width: auto;">
                                    <option value="" disabled selected>Filter By Month</option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                                |
                                <input type="date" id="start-date" class="form-control" style="width: auto;">
                                TO
                                <input type="date" id="end-date" class="form-control" style="width: auto;">

                                <button id="filter-date" class="form-control" style="width: auto;">
                                    <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M22 5.81445V6.50427C22 7.54211 22 8.06103 21.7404 8.49121C21.4808 8.92139 21.0065 9.18837 20.058 9.72234L17.145 11.3622C16.5085 11.7204 16.1903 11.8996 15.9625 12.0974C15.488 12.5093 15.1959 12.9933 15.0636 13.587C15 13.872 15 14.2056 15 14.8727V17.5422C15 19.4517 15 20.4064 14.3321 20.8242C13.6641 21.242 12.7248 20.8748 10.8462 20.1404C9.95128 19.7905 9.50385 19.6156 9.25192 19.2611C9 18.9065 9 18.4518 9 17.5422L9 14.8727C9 14.2056 9 13.872 8.93644 13.587C8.80408 12.9933 8.51199 12.5093 8.03751 12.0974C7.80967 11.8996 7.49146 11.7204 6.85504 11.3622L3.94202 9.72234C2.99347 9.18837 2.5192 8.92139 2.2596 8.49121C2 8.06103 2 7.54211 2 6.50427V5.81445"
                                            stroke="#1C274C" stroke-width="1.5" />
                                        <path opacity="0.5"
                                            d="M22 5.81466C22 4.48782 22 3.8244 21.5607 3.4122C21.1213 3 20.4142 3 19 3H5C3.58579 3 2.87868 3 2.43934 3.4122C2 3.8244 2 4.48782 2 5.81466"
                                            stroke="#1C274C" stroke-width="1.5" />
                                    </svg>
                                </button>
                                <button id="export-button" class="form-control" style="width: auto;">
                                <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
<svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M9.29289 1.29289C9.48043 1.10536 9.73478 1 10 1H18C19.6569 1 21 2.34315 21 4V9C21 9.55228 20.5523 10 20 10C19.4477 10 19 9.55228 19 9V4C19 3.44772 18.5523 3 18 3H11V8C11 8.55228 10.5523 9 10 9H5V20C5 20.5523 5.44772 21 6 21H7C7.55228 21 8 21.4477 8 22C8 22.5523 7.55228 23 7 23H6C4.34315 23 3 21.6569 3 20V8C3 7.73478 3.10536 7.48043 3.29289 7.29289L9.29289 1.29289ZM6.41421 7H9V4.41421L6.41421 7ZM19 12C19.5523 12 20 12.4477 20 13V19H23C23.5523 19 24 19.4477 24 20C24 20.5523 23.5523 21 23 21H19C18.4477 21 18 20.5523 18 20V13C18 12.4477 18.4477 12 19 12ZM11.8137 12.4188C11.4927 11.9693 10.8682 11.8653 10.4188 12.1863C9.96935 12.5073 9.86526 13.1318 10.1863 13.5812L12.2711 16.5L10.1863 19.4188C9.86526 19.8682 9.96935 20.4927 10.4188 20.8137C10.8682 21.1347 11.4927 21.0307 11.8137 20.5812L13.5 18.2205L15.1863 20.5812C15.5073 21.0307 16.1318 21.1347 16.5812 20.8137C17.0307 20.4927 17.1347 19.8682 16.8137 19.4188L14.7289 16.5L16.8137 13.5812C17.1347 13.1318 17.0307 12.5073 16.5812 12.1863C16.1318 11.8653 15.5073 11.9693 15.1863 12.4188L13.5 14.7795L11.8137 12.4188Z" fill="#000000"/>
</svg>
                                </button>

                                <?php include '../componemts/rota_codes.php'; ?>
                                
                            </div>
                        </div>
                    </div>
                    <div id="valueCountsContent" class="card mb-4 p-1"></div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            <output class="console" id="output">Click "Load" to load data from server</output>
                        </div>
                        <div class="card-body">

                            <div id="example1"></div>
                            <!-- <button id="export-button">Export to Excel</button> -->
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
    <script src="https://cdn.jsdelivr.net/npm/handsontable@latest/dist/handsontable.full.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <script type="module" src="main.js"></script>
    <!-- <script type="module" src="public/elements/populate-dropdown.js"></script> -->

    <script src="js/scripts.js"></script>

    <script>
        window.onload = function () {
            document.getElementById("load").click();
        };
    </script>

<script>
    const clearFiltersButton = document.getElementById('clear-filters-button');

    // Clear all filters
    clearFiltersButton.addEventListener('click', () => {
        location.reload(); // Refresh the page
        console.log('Filters cleared');
    });
</script>

<script>
        function logout() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "logout.php"; // Redirect to logout script
            }
        }
    </script>


</body>

</html>