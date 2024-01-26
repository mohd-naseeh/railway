<?php
include 'connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the HTML form
    $departure = $_POST['from'];
    $arrival = $_POST['to'];
    $date = $_POST['date'];

    // Check if the required variables are set
    if (isset($departure, $arrival, $date)) {
        // Perform the SQL query to search for matching records
        $sql = "SELECT * FROM trainsch WHERE depstation = ? AND arrstation = ? AND date = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $departure, $arrival, $date);
        $stmt->execute();

        // Display the search results in an HTML table
        echo "<h2>Search Results:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Train Name</th><th>Departure Station</th><th>Arrival Station</th><th>Departure Time</th><th>Arrival Time</th><th>Price</th><th>Date</th></tr>";

        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['trainname'] . "</td>";
            echo "<td>" . $row['depstation'] . "</td>";
            echo "<td>" . $row['arrstation'] . "</td>";
            echo "<td>" . $row['deptime'] . "</td>";
            echo "<td>" . $row['arrtime'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "<form method='post' action='' onsubmit='return confirmDelete()'>"; // Adjust the action attribute based on your backend logic
                  echo "<input type='hidden' name='trainid' value='" . $row["trainid"] . "'>";
                  echo "<button type='submit'>BOOK</button>";
            echo "<td>" . $row['date'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        // Close the database connection
        $stmt->close();
    } else {
        echo "Please fill out all the fields in the form.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
