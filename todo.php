<?php
session_start(); // Start or resume the PHP session

// Check if the user is logged in, redirect to the login page if not logged in
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>My To-Do List</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <h3>Add a New Task</h3>
    <form id="taskForm" method="post" action="task_manager.php">
      <input type="text" name="task" placeholder="Enter task description" required>
      <button type="submit">Add Task</button>
    </form>

    <!-- Display the user's tasks from the "tasks" table -->
    <h3>Your Tasks</h3>
    <ul id="taskList">
        <!-- Tasks will be dynamically loaded here using JavaScript -->
      </ul>
  
      <!-- Include JavaScript -->
      <script src="todo.js"></script>
  
      <form method="post" action="logout.php">
        <button type="submit">Logout</button>

