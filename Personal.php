<?php

$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "Stop_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$name = $_POST['name'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$emergency_contact_name = $_POST['emergency-contact-name'];
$emergency_contact_phone = $_POST['emergency-contact-phone'];
$allergies = isset($_POST['allergies']) ? implode(", ", $_POST['allergies']) : "";
$current_medications = $_POST['current-medications'];
$primary_physician = $_POST['primary-physician'];

// Handle file upload
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["medical-history"]["name"]);
move_uploaded_file($_FILES["medical-history"]["tmp_name"], $target_file);
$medical_history = $_FILES["medical-history"]["name"];

// Insert data into database
$sql = "INSERT INTO Stop (name, age, gender, address, phone, email, emergency_contact_name, emergency_contact_phone, allergies, current_medications, primary_physician, medical_history)
        VALUES ('$name', '$age', '$gender', '$address', '$phone', '$email', '$emergency_contact_name', '$emergency_contact_phone', '$allergies', '$current_medications', '$primary_physician', '$medical_history')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>