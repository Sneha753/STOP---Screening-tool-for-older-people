<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Stop_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$name = $conn->real_escape_string($_POST['name']);
$age = $conn->real_escape_string($_POST['age']);
$gender = $conn->real_escape_string($_POST['gender']);
$address = $conn->real_escape_string($_POST['address']);
$phone = $conn->real_escape_string($_POST['phone']);
$email = $conn->real_escape_string($_POST['email']);
$emergency_contact_name = $conn->real_escape_string($_POST['emergency_contact_name']);
$emergency_contact_phone = $conn->real_escape_string($_POST['emergency_contact_phone']);
$allergies = isset($_POST['allergies']) ? implode(", ", $_POST['allergies']) : "";
$current_medications = $conn->real_escape_string($_POST['current_medications']);
$primary_physician = $conn->real_escape_string($_POST['primary_physician']);
$cognitive_avg = isset($_POST['cognitive_avg']) ? $conn->real_escape_string($_POST['cognitive_avg']) : null;
$cognitive_msg = isset($_POST['cognitive_msg']) ? $conn->real_escape_string($_POST['cognitive_msg']) : null;
$vision_avg = isset($_POST['vision_avg']) ? $conn->real_escape_string($_POST['vision_avg']) : null;
$vision_msg = isset($_POST['vision_msg']) ? $conn->real_escape_string($_POST['vision_msg']) : null;

// Handle file upload
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["medical_history"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if file was uploaded
if ($_FILES["medical_history"]["size"] > 0) {
    // Check file size
    if ($_FILES["medical_history"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif" && $fileType != "pdf") {
        echo "Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["medical_history"]["tmp_name"], $target_file)) {
            $medical_history = $conn->real_escape_string($target_file);
        } else {
            echo "Sorry, there was an error uploading your file.";
            $uploadOk = 0;
        }
    }
} else {
    $medical_history = null;
}

if ($uploadOk == 1) {
    // Insert data into database
    $sql = "INSERT INTO Stop (name, age, gender, address, phone, email, emergency_contact_name, emergency_contact_phone, allergies, current_medications, primary_physician, medical_history, cognitive_test_avg, cognitive_test_msg, vision_test_avg, vision_test_msg)
            VALUES ('$name', '$age', '$gender', '$address', '$phone', '$email', '$emergency_contact_name', '$emergency_contact_phone', '$allergies', '$current_medications', '$primary_physician', '$medical_history', '$cognitive_avg', '$cognitive_msg', '$vision_avg', '$vision_msg')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>