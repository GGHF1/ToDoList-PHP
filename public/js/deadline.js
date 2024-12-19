document.addEventListener('DOMContentLoaded', function () {
    function showDeadlineOptions(itemId) {
        const options = document.getElementById(`deadline-options-${itemId}`);
        const datePicker = document.getElementById(`date-picker-${itemId}`);
        const timePicker = document.getElementById(`time-picker-${itemId}`);
        
        if (options.style.display === 'block') {
            options.style.display = 'none';  
            datePicker.style.display = 'none';  
            timePicker.style.display = 'none';  
        } else {
            options.style.display = 'block';  
        }
    }

    // Show date picker 
    function showDatePicker(itemId) {
        const datePicker = document.getElementById(`date-picker-${itemId}`);
        const setDeadlineBtn = document.getElementById(`set-deadline-btn-${itemId}`);
        
        // Reset value and prepare the field
        datePicker.value = '';  // Clear any previously set value
        datePicker.style.display = 'inline';
        datePicker.focus();
        // Trigger the click event to open the dropdown directly (without text input)
        setTimeout(() => datePicker.click(), 100);  // Add a short delay for better focus

        // Check if date is selected and show the "Set Deadline" button
        datePicker.addEventListener('change', function() {
            if (datePicker.value || document.getElementById(`time-picker-${itemId}`).value) {
                setDeadlineBtn.style.display = 'inline'; // Show the button when date or time is set
            }
        });
    }

    // Show time picker 
    function showTimePicker(itemId) {
        const timePicker = document.getElementById(`time-picker-${itemId}`);
        const setDeadlineBtn = document.getElementById(`set-deadline-btn-${itemId}`);
        
        // Reset value and prepare the field 
        timePicker.value = '';  // Clear any previously set value
        timePicker.style.display = 'inline';  
        // Focus on the time picker to trigger the native dropdown behavior
        timePicker.focus();
        // Trigger the click event to open the dropdown directly
        setTimeout(() => timePicker.click(), 100);  // Add a short delay for better focus

        // Check if time is selected and show the "Set Deadline" button
        timePicker.addEventListener('change', function() {
            if (timePicker.value || document.getElementById(`date-picker-${itemId}`).value) {
                setDeadlineBtn.style.display = 'inline'; // Show the button when date or time is set
            }
        });
    }

    // Check if either date or time is selected and show the "Set Deadline" button
    function checkDeadlineInputs(itemId) {
        const datePicker = document.getElementById(`date-picker-${itemId}`);
        const timePicker = document.getElementById(`time-picker-${itemId}`);
        const setDeadlineBtn = document.getElementById(`set-deadline-btn-${itemId}`);

        if (datePicker.value || timePicker.value) {
            setDeadlineBtn.style.display = 'inline';
        } else {
            setDeadlineBtn.style.display = 'none';
        }
    }

    // Function to handle setting the deadline
    function setDeadline(itemId) {
        const datePicker = document.getElementById(`date-picker-${itemId}`);
        const timePicker = document.getElementById(`time-picker-${itemId}`);
        const errorMessage = document.getElementById(`error-message-${itemId}`); 
    
        let deadline = '';
    
        if (datePicker.value) {
            deadline = datePicker.value;  // Get the selected date
        }
    
        // If only time is selected, use today's date
        if (timePicker.value) {
            if (deadline) {
                deadline += ' ' + timePicker.value;  
            } else {
                // Get today's date in YYYY-MM-DD format
                const today = new Date();
                const dd = String(today.getDate()).padStart(2, '0');
                const mm = String(today.getMonth() + 1).padStart(2, '0'); // Month is 0-based, so +1
                const yyyy = today.getFullYear();
                const formattedDate = `${yyyy}-${mm}-${dd}`; // Format as YYYY-MM-DD
                deadline = formattedDate + ' ' + timePicker.value;  // Combine today’s date with the selected time
            }
        }
    
        if (!deadline) {
            alert('Please select a valid date and/or time.');
            return;
        }
    
        // Validate if the deadline is not in the past
        const selectedDate = new Date(deadline);
        const currentDate = new Date();
    
        // Set the current date to midnight to ignore time for comparison
        currentDate.setHours(0, 0, 0, 0);
    
        if (selectedDate < currentDate) {
            errorMessage.style.display = 'block';
            errorMessage.textContent = 'You cannot set a deadline in the past. Please choose a future date and time.';
            return;
        } else {
            errorMessage.style.display = 'none';
        }
    
        // Get CSRF token from meta tag (assuming it's in a meta tag)
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const formData = new FormData();
        formData.append('deadline', deadline);
        formData.append('_token', csrfToken); 
    
        // Make the Ajax request to update the deadline
        fetch(`/set-deadline/${itemId}`, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the displayed deadline on the task
                const deadlineText = document.querySelector(`.list-item[data-id='${itemId}'] .deadline`);
                const deadlineDate = new Date(deadline);
                const now = new Date();
                let formattedDeadline = '';
    
                // Format the deadline in European style
                const dd = String(deadlineDate.getDate()).padStart(2, '0');
                const mm = String(deadlineDate.getMonth() + 1).padStart(2, '0'); // Month is 0-based
                const yyyy = deadlineDate.getFullYear();
                const hours = String(deadlineDate.getHours()).padStart(2, '0');
                const minutes = String(deadlineDate.getMinutes()).padStart(2, '0');
                formattedDeadline = `${dd}/${mm}/${yyyy}, ${hours}:${minutes}`;

                deadlineText.textContent = formattedDeadline;

                // Change color if the deadline is expired
                if (deadlineDate < now) {
                    deadlineText.style.color = 'red';
                } else {
                    deadlineText.style.color = '';
                }

                // Hide the pickers and set button after success
                datePicker.style.display = 'none';
                timePicker.style.display = 'none';
                const setDeadlineBtn = document.getElementById(`set-deadline-btn-${itemId}`);
                setDeadlineBtn.style.display = 'none';  // Hide the "Set Deadline" button
            } else {
                alert('Error setting deadline.');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Expose functions for use in the template
    window.showDeadlineOptions = showDeadlineOptions;
    window.showDatePicker = showDatePicker;
    window.showTimePicker = showTimePicker;
    window.setDeadline = setDeadline;
    window.checkDeadlineInputs = checkDeadlineInputs;
});
