<?php
session_start();

include('sessionCheck.php');
include '../server/dbConnection.php'; // Include your database connection file

$error = '';
$success = '';

//include('sessionCheck.php');

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

// Retrieve user data from the database
$stmt = $conn->prepare("SELECT username, name FROM users WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$stmt->bind_result($email, $full_name);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $new_email = $_POST['email'];
    $new_full_name = $_POST['full_name'];

    // Validate form data
    if (empty($new_email) || empty($new_full_name)) {
        $error = "All fields are required.";
    } else {
        // Update the profile in the database
        $update_stmt = $conn->prepare("UPDATE users SET username = ?, name = ? WHERE username = ?");
        $update_stmt->bind_param("sss", $new_email, $new_full_name, $_SESSION['username']);

        if ($update_stmt->execute()) {
            $success = "Profile updated successfully!";
        } else {
            $error = "Error updating profile.";
        }

        $update_stmt->close();
        header('Location: login.php'); // Redirect to login if not authenticated
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
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
                        <h1 class="mt-4">Edit Profile</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Profile</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                <!-- Display success or error message -->
                                <?php if ($error): ?>
                                    <p style="color:red;"><?php echo $error; ?></p>
                                <?php elseif ($success): ?>
                                    <p style="color:green;"><?php echo $success; ?></p>
                                <?php endif; ?>

                                <!-- Edit Profile Form -->
                                <form action="" method="POST">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="email" type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required />
                                        <label for="email">Email</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="fullName" type="text" name="full_name" placeholder="Full Name" value="<?php echo htmlspecialchars($full_name); ?>" required />
                                        <label for="fullName">Full Name</label>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                        <button type="submit" class="btn btn-primary">Update Profile</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
                <?php include '../componemts/footer.php'; ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
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
