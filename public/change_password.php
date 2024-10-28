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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate form data
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif ($new_password !== $confirm_password) {
        $error = "New password and confirmation do not match.";
    } else {
        // Retrieve user data from the database
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // Verify the current password
            if (password_verify($current_password, $hashed_password)) {
                // Hash the new password
                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the password in the database
                $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
                $update_stmt->bind_param("ss", $new_hashed_password, $_SESSION['username']);

                if ($update_stmt->execute()) {
                    $success = "Password changed successfully!";
                } else {
                    $error = "Error updating password.";
                }

                $update_stmt->close();
            } else {
                $error = "Current password is incorrect.";
            }
        } else {
            $error = "User not found.";
        }

        $stmt->close();
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
                    <h1 class="mt-4">Change Password</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">

                            <!-- Display success or error message -->
                            <?php if ($error): ?>
                                <p style="color:red;"><?php echo $error; ?></p>
                            <?php elseif ($success): ?>
                                <p style="color:green;"><?php echo $success; ?></p>
                            <?php endif; ?>

                            <!-- Change Password Form -->
                            <form action="" method="POST">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="currentPassword" type="password" name="current_password" placeholder="Current Password" required />
                                    <label for="currentPassword">Current Password</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="newPassword" type="password" name="new_password" placeholder="New Password" required />
                                    <label for="newPassword">New Password</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="confirmPassword" type="password" name="confirm_password" placeholder="Confirm New Password" required />
                                    <label for="confirmPassword">Confirm New Password</label>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
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
    <script>
        function logout() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "logout.php"; // Redirect to logout script
            }
        }
    </script>
</body>

</html>