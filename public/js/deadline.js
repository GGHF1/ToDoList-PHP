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
        datePicker.value = '';
        datePicker.style.display = 'inline';
        datePicker.focus();
        setTimeout(() => datePicker.click(), 100);  // Add a short delay for better focus

        // Check if date is selected
        datePicker.addEventListener('change', function() {
            if (datePicker.value || document.getElementById(`time-picker-${itemId}`).value) {
                setDeadlineBtn.style.display = 'inline'; 
            }
        });
    }

    // Show time picker 
    function showTimePicker(itemId) {
        const timePicker = document.getElementById(`time-picker-${itemId}`);
        const setDeadlineBtn = document.getElementById(`set-deadline-btn-${itemId}`);
        
       
        timePicker.value = '';  
        timePicker.style.display = 'inline';  
        timePicker.focus();
        setTimeout(() => timePicker.click(), 100);  // Add a short delay for better focus

        // Check if time is selected and show the "Set Deadline" button
        timePicker.addEventListener('change', function() {
            if (timePicker.value || document.getElementById(`date-picker-${itemId}`).value) {
                setDeadlineBtn.style.display = 'inline'; 
            }
        });
    }

    // Check if either date or time is selected
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
            deadline = datePicker.value + ' 23:59';  
        }
    
        // If only time is selected, use today's date
        if (timePicker.value) {
            if (deadline) {
                deadline = datePicker.value + ' ' + timePicker.value;  
            } else {
                // Get today's date in YYYY-MM-DD
                const today = new Date();
                const dd = String(today.getDate()).padStart(2, '0');
                const mm = String(today.getMonth() + 1).padStart(2, '0');
                const yyyy = today.getFullYear();
                const formattedDate = `${yyyy}-${mm}-${dd}`; 
                deadline = formattedDate + ' ' + timePicker.value;  
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
        } else if (selectedDate.toDateString() === currentDate.toDateString() && selectedDate < new Date()) {
            errorMessage.style.display = 'block';
            errorMessage.textContent = 'You cannot set a deadline in the past. Please choose a future time.';
            return;
        } else {
            errorMessage.style.display = 'none';
        }
    
        // Get CSRF token 
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
                location.reload(); // Added reload to correctly set deadlines
            } else {
                alert('Error setting deadline.');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    window.showDeadlineOptions = showDeadlineOptions;
    window.showDatePicker = showDatePicker;
    window.showTimePicker = showTimePicker;
    window.setDeadline = setDeadline;
    window.checkDeadlineInputs = checkDeadlineInputs;
});