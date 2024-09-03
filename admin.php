<?php
// Database configuration
$servername = "localhost";  // Your database server (usually 'localhost')
$username = "root";         // Your database username
$password = "";             // Your database password
$dbname = "zenon";  // Your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Destinations</title>
    <style>
        /* CSS styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo h1 {
            margin: 0;
        }
        .search-bar input {
            padding: 5px;
            margin-right: 10px;
        }
        .search-bar button, .user-options button {
            padding: 5px 10px;
            cursor: pointer;
        }
        nav {
            background-color: #444;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
        }
        nav ul {
            list-style: none;
            display: flex;
            padding: 0;
            margin: 0;
        }
        nav ul li {
            margin-right: 20px;
            cursor: pointer;
        }
        main {
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
        }
        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            margin: 10px;
            padding: 15px;
            width: calc(33% - 40px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .card img {
            width: 100%;
            height: auto;
        }
        .card h3 {
            margin: 10px 0;
        }
        .card p {
            color: #888;
        }
        .tax-toggle {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <h1>Explore</h1>
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Search destinations">
            <button>Search</button>
        </div>
        <div class="user-options">
            <a href="form.html"><button>List Place</button></a>
            <a href="index.html"><button>Log Out</button></a>
        </div>
    </header>
    
    <nav>
        <ul>
            <li>Trending</li>
            <li>Tree Houses</li>
            <li>Beach Front</li>
            <li>Amazing Pools</li>
            <li>Rooms</li>
            <li>Castles</li>
            <li>Cruises</li>
            <li>Camping</li>
            <li>Mountain</li>
            <li>Luxury Hotel</li>
        </ul>
        <div class="tax-toggle">
            <span>Total with Tax</span>
            <input type="checkbox" id="taxToggle">
        </div>
    </nav>

    <main>
        <?php
        // SQL query to fetch data from listings table
        $sql = "SELECT title, description, image, price FROM listings";
        $result = $conn->query($sql);

        // Check if any results are returned
        if ($result->num_rows > 0) {
            // Loop through and output data of each row
            while($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<img src="uploads/' . $row["image"] . '" alt="' . htmlspecialchars($row["title"]) . '">';
                echo '<h3>' . htmlspecialchars($row["title"]) . '</h3>';
                echo '<p>₹' . htmlspecialchars($row["price"]) . '/Night</p>';
                echo '</div>';
            }
        } else {
            echo "No listings found.";
        }

        // Close the database connection
        $conn->close();
        ?>
    </main>

    <script>
        // JavaScript code for handling the checkbox toggle functionality
        document.getElementById('taxToggle').addEventListener('change', function() {
            if (this.checked) {
                alert('Tax included in total!');
            } else {
                alert('Tax not included in total!');
            }
        });
    </script>
</body>
</html>
