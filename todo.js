// Function to add a new task using AJAX
function addTask(event) {
    event.preventDefault();
    const taskDescription = document.getElementById("taskDescription").value;
  
    // Perform necessary validation on the task data (e.g., check for a minimum length)
    if (taskDescription.length < 5) {
      alert("Task description must be at least 5 characters long.");
      return;
    }
  
    // Create a new XMLHttpRequest object
    const xhr = new XMLHttpRequest();
  
    // Configure the POST request to task_manager.php
    xhr.open("POST", "task_manager.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  
    // Define the callback function when the request completes
    xhr.onload = function () {
      if (xhr.status === 200) {
        // Reload the task list after successful addition
        loadTasks();
      } else {
        alert("An error occurred while adding the task.");
      }
    };
  
    // Send the POST request with the task data
    xhr.send(`action=add&task=${encodeURIComponent(taskDescription)}`);
  }
  
  // Function to toggle task status (completed/incomplete) using AJAX
  function toggleTaskStatus(taskId, status) {
    // Create a new XMLHttpRequest object
    const xhr = new XMLHttpRequest();
  
    // Configure the POST request to task_manager.php
    xhr.open("POST", "task_manager.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  
    // Define the callback function when the request completes
    xhr.onload = function () {
      if (xhr.status === 200) {
        // Reload the task list after successful status update
        loadTasks();
      } else {
        alert("An error occurred while updating the task status.");
      }
    };
  
    // Send the POST request with the task ID and status data
    xhr.send(`action=update&task_id=${taskId}&status=${status}`);
  }
  
  // Function to delete a task using AJAX
  function deleteTask(taskId) {
    // Create a new XMLHttpRequest object
    const xhr = new XMLHttpRequest();
  
    // Configure the POST request to task_manager.php
    xhr.open("POST", "task_manager.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  
    // Define the callback function when the request completes
    xhr.onload = function () {
      if (xhr.status === 200) {
        // Reload the task list after successful deletion
        loadTasks();
      } else {
        alert("An error occurred while deleting the task.");
      }
    };
  
    // Send the POST request with the task ID for deletion
    xhr.send(`action=delete&task_id=${taskId}`);
  }
  
  // Function to load tasks using AJAX
  function loadTasks() {
    // Create a new XMLHttpRequest object
    const xhr = new XMLHttpRequest();
  
    // Configure the GET request to task_manager.php
    xhr.open("GET", "task_manager.php?action=getTasks", true);
  
    // Define the callback function when the request completes
    xhr.onload = function () {
      if (xhr.status === 200) {
        // Parse the JSON response and update the task list
        const taskList = document.getElementById("taskList");
        taskList.innerHTML = "";
  
        const tasks = JSON.parse(xhr.responseText);
        tasks.forEach((task) => {
          const listItem = document.createElement("li");
          listItem.textContent = task.task_description;
  
          const markButton = document.createElement("button");
          markButton.textContent = task.status === "completed" ? "Mark Incomplete" : "Mark Completed";
          markButton.onclick = function () {
            toggleTaskStatus(task.task_id, task.status === "completed" ? "incomplete" : "completed");
          };
  
          const deleteButton = document.createElement("button");
          deleteButton.textContent = "Delete";
          deleteButton.onclick = function () {
            deleteTask(task.task_id);
          };
  
          listItem.appendChild(markButton);
          listItem.appendChild(deleteButton);
          taskList.appendChild(listItem);
        });
      } else {
        alert("An error occurred while loading tasks.");
      }
    };
  
    // Send the GET request to fetch tasks
    xhr.send();
  }
  
  // Load tasks when the page is loaded
  window.onload = loadTasks;
  