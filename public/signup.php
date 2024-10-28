<?php
// dbConnection.php logic integrated here:
// Include database connection
include '../server/dbConnection.php';

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$error = '';
$success = '';

// Role constants
define("MAIN_ADMIN", 1);
define("SECOND_ADMIN", 2);
define("THIRD_ADMIN", 3);
define("FOURTH_ADMIN", 4);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validate form data
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        $error = "Please fill in all fields.";
    } else {
        // Map role to integer
        switch ($role) {
            case "Main Admin":
                $roleValue = MAIN_ADMIN;
                break;
            case "Second Admin":
                $roleValue = SECOND_ADMIN;
                break;
            case "Third Admin":
                $roleValue = THIRD_ADMIN;
                break;
            case "Fourth Admin":
                $roleValue = FOURTH_ADMIN;
                break;
            default:
                $error = "Invalid role selected.";
                break;
        }

        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // User with this email already exists
            $error = "User with this email already exists.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database with role as an integer
            $stmt = $conn->prepare("INSERT INTO users (username, password, name, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $email, $hashed_password, $name, $roleValue); // Note the 'i' for integer

            if ($stmt->execute()) {
                // Registration successful
                $success = "Registration successful! You can now log in.";
            } else {
                $error = "Error: Could not register the user.";
            }
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Register</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display success or error message -->
                        <?php if ($error): ?>
                            <p style="color:red;"><?php echo $error; ?></p>
                        <?php elseif ($success): ?>
                            <p style="color:green;"><?php echo $success; ?></p>
                        <?php endif; ?>

                        <!-- Registration Form -->
                        <form action="" method="POST">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputName" type="text" name="name" placeholder="Enter your name" required />
                                <label for="inputName">Full Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputEmail" type="email" name="email" placeholder="name@example.com" required />
                                <label for="inputEmail">Email address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Password" required />
                                <label for="inputPassword">Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <!-- <label for="inputRole">Role</label> -->
                                <select class="form-control" id="inputRole" name="role" required>
                                    <option value="" disabled selected>Select your role</option>
                                    <option value="Main Admin">Main Admin</option>
                                    <option value="Second Admin">Second Admin</option>
                                    <option value="Third Admin">Third Admin</option>
                                </select>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="small"><a href="login.php">Already have an account? Login!</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
