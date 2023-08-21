<?php
// Function to establish a database connection

function connectDatabase() {
    $host = "localhost";
    $username = "username";
    $password = "password";
    $dbname = "portfolio";

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

// Function to update project information

function updateProject($id, $title, $description, $image) {
    $conn = connectDatabase();

    $stmt = $conn->prepare("UPDATE projects SET Title = ?, Description = ?, Image = ? WHERE ID = ?");
    $stmt->bind_param("sssi", $title, $description, $image, $id);

    $stmt->execute();
    $stmt->close();
    $conn->close();
}

// Function to delete a project

function deleteProject($id) {
    $conn = connectDatabase();

    $stmt = $conn->prepare("DELETE FROM projects WHERE ID = ?");
    $stmt->bind_param("i", $id);

    $stmt->execute();
    $stmt->close();
    $conn->close();
}
?>
