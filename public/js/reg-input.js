document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector('form');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const emailInput = document.getElementById('email');

    const usernameError = document.getElementById('usernameError');
    const passwordError = document.getElementById('passwordError');
    const emailError = document.getElementById('email').nextElementSibling;

    const usernamePattern = /^[a-zA-Z0-9]+$/; //Only English letters
    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/; //Password format validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; //Email format validation

    usernameInput.addEventListener('input', validateUsername);
    passwordInput.addEventListener('input', validatePassword);
    emailInput.addEventListener('input', validateEmail);

    function validateUsername() {
        if (!usernamePattern.test(usernameInput.value)) {
            usernameInput.classList.add('is-invalid');
            usernameError.textContent = "Username must contain only English letters and digits.";
        } else if (usernameInput.value.length < 4 || usernameInput.value.length > 20) {
            usernameInput.classList.add('is-invalid');
            usernameError.textContent = "Username must be between 4 and 20 characters.";
        } else {
            usernameInput.classList.remove('is-invalid');
            usernameError.textContent = "";
        }
        checkFormValidity();
    }

    function validatePassword() {
        if (!passwordPattern.test(passwordInput.value)) {
            passwordInput.classList.add('is-invalid');
            passwordError.textContent = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
        } else {
            passwordInput.classList.remove('is-invalid');
            passwordError.textContent = "";
        }
        checkFormValidity();
    }

    function validateEmail() {
        if (!emailPattern.test(emailInput.value)) {
            emailInput.classList.add('is-invalid');
            emailError.textContent = "Enter a valid email address.";
        } else {
            emailInput.classList.remove('is-invalid');
            emailError.textContent = "";
        }
        checkFormValidity();
    }

    function checkFormValidity() {
        const isUsernameValid = !usernameInput.classList.contains('is-invalid');
        const isPasswordValid = !passwordInput.classList.contains('is-invalid');
        const isEmailValid = !emailInput.classList.contains('is-invalid');
    
        const isFormValid = isUsernameValid && isPasswordValid && isEmailValid;
        document.getElementById('reg-button').disabled = !isFormValid;
    }
});