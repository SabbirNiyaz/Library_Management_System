const loginForm = document.getElementById("login-form");
const registerForm = document.getElementById("register-form");

// Show the register form and hide the login form
function showRegisterForm() {
    loginForm.style.display = "none";
    registerForm.style.display = "block";
}

// Show the login form and hide the register form
function showLoginForm() {
    registerForm.style.display = "none";
    loginForm.style.display = "block";
}