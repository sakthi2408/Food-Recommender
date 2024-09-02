<?php
    echo "got";
    $db_hostname = "127.0.0.1";
    $db_username = "root";
    $db_password = ""; // Change this to your actual database password
    $db_name = "phppage";

    $conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_name);
    if(!$conn){
        echo "connection failed" . mysqli_connect_error();
        exit;
    }

    // Check if the form fields are set
    if(isset($_POST['name'], $_POST['email'], $_POST['password'])) {
        // Sanitize user inputs
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Hash the password securely
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO accounts (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashed_password);

        // Execute the statement
        if($stmt->execute()){
            echo "registration done";
        } else {
            echo "FAILURE" . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Form fields are not set.";
    }

    // Close connection
    mysqli_close($conn);
?>
