<?php
// Validate form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    
    $errors = array();
    
    // Validate full name
    if (empty($full_name)) {
        $errors[] = "Need Full_name";
    }
    
    // Validate email address
    if (empty($email)) {
        $errors[] = "Need Email address";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Write your email address correctly";
    }
    
    // If there are no errors, insert data into database
    if (empty($errors)) {
        // Database connection details
        $servername = "localhost";
        $username = "your_username";
        $password = "your_password";
        $dbname = "your_database_name";
        
        // Create a new MySQLi instance
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Prepare and execute the SQL query to insert data
        $sql = "INSERT INTO students (full_name, email, gender) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $full_name, $email, $gender);
        $stmt->execute();
        
        // Close the statement and connection
        $stmt->close();
        $conn->close();
        
        // Display success message
        echo "Registration successful!";
    } else {
        // Display error messages
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}
?>