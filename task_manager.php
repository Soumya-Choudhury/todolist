<?php
session_start(); // Start or resume the PHP session

// Check if the user is not logged in, redirect to the login page if true
if (!isset($_SESSION['username'])) {
  header('Location: login.html'); // Replace 'login.html' with the actual login page
  exit();
}

// Include the database connection file
include 'database_connection.php';

// Handle adding new tasks to the "tasks" table
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['task'])) {
    $task = $_POST['task'];

    // Perform necessary validation on the task data (e.g., check for a minimum length)
    if (strlen($task) < 5) {
      $error = "Task description must be at least 5 characters long.";
    } else {
      // Insert the new task into the "tasks" table
      $insertQuery = "INSERT INTO tasks (user_id, task_name) VALUES (?, ?)";
      $insertStmt = mysqli_prepare($conn, $insertQuery);
      mysqli_stmt_bind_param($insertStmt, 'is', $_SESSION['user_id'], $task);
      mysqli_stmt_execute($insertStmt);

      // Redirect to the same page to prevent form resubmission on refresh
      header('Location: todo.php');
      exit();
    }
  }

  // Handle updating task status (e.g., completed/incomplete)
  if (isset($_POST['task_id']) && isset($_POST['status'])) {
    $task_id = $_POST['task_id'];
    $status = $_POST['status'];

    // Update the task status in the "tasks" table
    $updateQuery = "UPDATE tasks SET status = ? WHERE task_id = ? AND user_id = ?";
    $updateStmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, 'sii', $status, $task_id, $_SESSION['user_id']);
    mysqli_stmt_execute($updateStmt);

    // Redirect to the same page to update the task list
    header('Location: todo.php');
    exit();
  }

  // Handle deleting tasks
  if (isset($_POST['delete_task_id'])) {
    $task_id = $_POST['delete_task_id'];

    // Delete the task from the "tasks" table
    $deleteQuery = "DELETE FROM tasks WHERE task_id = ? AND user_id = ?";
    $deleteStmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($deleteStmt, 'ii', $task_id, $_SESSION['user_id']);
    mysqli_stmt_execute($deleteStmt);

    // Redirect to the same page to update the task list
    header('Location: todo.php');
    exit();
  }

  // Remember to use prepared statements to prevent SQL injection
}

// Fetch and display the user's tasks from the "tasks" table
$tasksQuery = "SELECT * FROM tasks WHERE user_id = ? ORDER BY status, task_id DESC";
$tasksStmt = mysqli_prepare($conn, $tasksQuery);
mysqli_stmt_bind_param($tasksStmt, 'i', $_SESSION['user_id']);
mysqli_stmt_execute($tasksStmt);
$tasksResult = mysqli_stmt_get_result($tasksStmt);
?>
