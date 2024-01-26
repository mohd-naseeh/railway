<?php
 include 'connect.php';

 // Ensure that the form was submitted
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
     // Retrieve the trainid from the form data
     $trainid = $_POST["trainid"];
 
     // Perform the deletion operation
     $sql = "DELETE FROM trainsch WHERE trainid = ?";
     $stmt = $conn->prepare($sql);
     $stmt->bind_param("i", $trainid); // Assuming trainid is an integer, adjust accordingly if it's a different type
     $stmt->execute();
 
     // Check if the deletion was successful
     if ($stmt->affected_rows > 0) {
         echo "Record deleted successfully";
         header("Location: admindash.php");
     } else {
         echo "Error deleting record: " . $stmt->error;
     }
 
     // Close the statement
     $stmt->close();
 }
 
 // Close the database connection
 $conn->close();

 
 
 ?>
 