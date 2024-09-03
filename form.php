<?php
// Database configuration
$servername = "localhost";  // Database server (usually 'localhost')
$username = "root";         // Database username
$password = "";             // Database password (use your own)
$dbname = "zenon";  // Database name (replace with your database name)

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $country = $_POST['country'];
    $location = $_POST['location'];

    // Handle the image upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/"; // Directory where images will be saved
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        
        // Check if the uploads directory exists, if not, create it
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Move the uploaded file to the target directory
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    }

    // Insert data into the database
    $sql = "INSERT INTO listings (title, description, image, price, country, location)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $title, $description, $image, $price, $country, $location);

    if ($stmt->execute()) {
        echo "New listing added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the statement
    $stmt->close();
}
header("Location: admin.php");
// Close the database connection
$conn->close();
?>
