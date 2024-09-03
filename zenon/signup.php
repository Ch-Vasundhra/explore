<?php
// Database connection
$servername = "localhost"; // Your database host name
$username = "root";        // Your database username
$password = "";            // Your database password
$dbname = "zenon";           // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password for security
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $pinCode = $_POST['pinCode'];

    // Check if email already exists
    $checkEmailSql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmailSql);

    if ($result->num_rows > 0) {
        // Email already exists, show notification and redirect back to signup page
        echo "<script>
            alert('Email already exists. Please use a different email.');
            window.location.href = 'Signup.html';
        </script>";
    } else {
        // SQL query to insert data into the database
        $sql = "INSERT INTO users (name, email, password, mobile, address, country, state, city, pin_code)
                VALUES ('$name', '$email', '$password', '$mobile', '$address', '$country', '$state', '$city', '$pinCode')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to login page
            header("Location: login.html");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
