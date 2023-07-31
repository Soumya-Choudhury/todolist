document.addEventListener("DOMContentLoaded", function () {
    const taskForm = document.getElementById("taskForm");
    const taskList = document.getElementById("taskList");
  
    // Handle form submission to add new tasks
    taskForm.addEventListener("submit", function (event) {
      event.preventDefault(); // Prevent form submission
  
      // Get the task name entered by the user
      const taskNameInput = document.querySelector('input[name="taskName"]');
      const taskName = taskNameInput.value.trim();
  
      if (taskName !== "") {
        // Create a new list item to display the task
        const li = document.createElement("li");
        li.innerHTML = `
          <input type="checkbox" name="taskCheckbox">
          ${taskName}
        `;
        taskList.appendChild(li);
  
        // Clear the input field after adding the task
        taskNameInput.value = "";
      }
    });
  });
  