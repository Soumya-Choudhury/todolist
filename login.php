<?php
session_start(); // Start or resume the PHP session

// Check if the user is already logged in, redirect to the To-Do List page if true
if (isset($_SESSION["username"])) {
  header('Location: todo.php'); // Replace 'todo.html' with the actual To-Do List page
  exit();
}

// Include the database connection file
include 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Fetch the user data based on the provided username
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $query); // Change $connection to $conn
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);


    // Verify the hashed password with the one stored in the database using password_verify()
    if ($user && password_verify($password, $user["password"])) {
      // If the password is correct, set the session variable
      $_SESSION["username"] = $user["username"];

      // Redirect the user to the To-Do List page after successful login
      header('Location: todo.php'); // Replace 'todo.html' with the actual To-Do List page
      exit();
    } else {
      // Invalid login credentials, handle the error (e.g., show an error message)
      $error = "Invalid username or password. Please try again.";
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login - My To-Do List</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Login</h2>
    <?php
    if (isset($error)) {
      echo '<p class="error-message">' . $error . '</p>';
    }
    ?>
    <form id="loginForm" method="post" action="login.php">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Submit</button>
    </form>
  </div>
</body>
</html>
