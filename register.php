<?php
session_start(); // Start or resume the PHP session

// Check if the user is already logged in, redirect to the To-Do List page if true
if (isset($_SESSION['username'])) {
  header('Location: todo.php'); // Replace 'todo.html' with the actual To-Do List page
  exit();
}

// Include the database connection file
include 'database_connection.php';

// Handle the user registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate the username and password (e.g., check for minimum length, etc.)
    // Add appropriate validation logic here.

    // Hash the password for secure storage in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the username already exists in the database
    $checkQuery = "SELECT * FROM users WHERE username = ?";
    $checkStmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($checkStmt, 's', $username);
    mysqli_stmt_execute($checkStmt);
    $checkResult = mysqli_stmt_get_result($checkStmt);
    
    if (mysqli_num_rows($checkResult) > 0) {
      // The username already exists, handle the error (e.g., show an error message)
      $error = "Username already exists. Please choose a different username.";
    } else {
      // Insert the new user data into the "users" table
      $insertQuery = "INSERT INTO users (username, password) VALUES (?, ?)";
      $insertStmt = mysqli_prepare($conn, $insertQuery);
      mysqli_stmt_bind_param($insertStmt, 'ss', $username, $hashedPassword);
      mysqli_stmt_execute($insertStmt);

      // Registration successful, set the session variable and redirect to the To-Do List page
      $_SESSION['username'] = $username;
      header('Location: todo.php'); 
      exit();
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register - My To-Do List</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Register</h2>
    <?php
    if (isset($error)) {
      echo '<p class="error-message">' . $error . '</p>';
    }
    ?>
    <form id="registerForm" method="post" action="register.php">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Register</button>
    </form>
  </div>
</body>
</html>
