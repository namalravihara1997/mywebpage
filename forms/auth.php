<?php
session_start();

// Function to establish a database connection

function connectDatabase() {
    $host = "localhost";
    $username = "your_username";
    $password = "your_password";
    $dbname = "project_database";

    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Function to register a new user

function registerUser($username, $password) {
    $conn = connectDatabase();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (Username, Password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);

    $stmt->execute();
    $stmt->close();
    $conn->close();
}

// Function to verify user login

function loginUser($username, $password) {
    $conn = connectDatabase();

    $stmt = $conn->prepare("SELECT Password FROM users WHERE Username = ?");
    $stmt->bind_param("s", $username);

    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();

    if (password_verify($password, $hashedPassword)) {
        $_SESSION['username'] = $username;
        return true;
    }

    $stmt->close();
    $conn->close();
    return false;
}

// Function to check if a user is authenticated

function isAuthenticated() {
    return isset($_SESSION['username']);
}

// Function to log out a user

function logout() {
    session_destroy();
    header("Location: login.php"); // Redirect to login page after logout
}
?>
