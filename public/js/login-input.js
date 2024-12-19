document.addEventListener("DOMContentLoaded", function() {
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const loginButton = document.getElementById('log-button');

    usernameInput.addEventListener('input', checkLoginFormValidity);
    passwordInput.addEventListener('input', checkLoginFormValidity);

    function checkLoginFormValidity() {
        const isUsernameValid = usernameInput.value.trim() !== '';
        const isPasswordValid = passwordInput.value.trim() !== '';

        loginButton.disabled = !(isUsernameValid && isPasswordValid);
    }
    checkLoginFormValidity();
});