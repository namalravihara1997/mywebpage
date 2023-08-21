<?php
// Function to perform form validation and return error messages

function validateForm($name, $email, $message) {
    $errors = [];

    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    return $errors;
}

// Function to establish a database connection and return the connection object

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

// Function to insert project details into the database

function insertProject($title, $description, $image) {
    $conn = connectDatabase();

    $stmt = $conn->prepare("INSERT INTO projects (Title, Description, Image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $image);

    $stmt->execute();
    $stmt->close();
    $conn->close();
}

// Function to retrieve project data from the database

function getProjects() {
    $conn = connectDatabase();

    $sql = "SELECT * FROM projects";
    $result = $conn->query($sql);

    $projects = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $projects[] = $row;
        }
    }

    $conn->close();
    return $projects;
}

// Function to update project information in the database

function updateProject($id, $title, $description, $image) {
    $conn = connectDatabase();

    $stmt = $conn->prepare("UPDATE projects SET Title = ?, Description = ?, Image = ? WHERE ID = ?");
    $stmt->bind_param("sssi", $title, $description, $image, $id);

    $stmt->execute();
    $stmt->close();
    $conn->close();
}

// Function to delete a project from the database

function deleteProject($id) {
    $conn = connectDatabase();

    $stmt = $conn->prepare("DELETE FROM projects WHERE ID = ?");
    $stmt->bind_param("i", $id);

    $stmt->execute();
    $stmt->close();
    $conn->close();
}


?>
