<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zenon";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rememberMe = isset($_POST['rememberMe']) ? $_POST['rememberMe'] : '';

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        // Verify the hashed password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct
            if ($rememberMe) {
                setcookie("user", $email, time() + (86400 * 30), "/");
            } else {
                session_start();
                $_SESSION["user"] = $email;
            }

            header("Location: admin.php");
            exit();
        } else {
            echo "<script>alert('Invalid email or password. Please try again.'); window.location.href='login.html';</script>";
        }
    } else {
        // User not found
        echo "<script>alert('Invalid email or password. Please try again.'); window.location.href='login.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
