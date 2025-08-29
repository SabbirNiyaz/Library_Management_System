// Show/hide forms
    function showRegisterForm() {
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('register-form').style.display = 'block';
    }
    function showLoginForm() {
        document.getElementById('register-form').style.display = 'none';
        document.getElementById('login-form').style.display = 'block';
    }

    // Register Form Validation
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Clear previous errors
        document.getElementById('nameError').innerText = '';
        document.getElementById('emailError').innerText = '';
        document.getElementById('passwordError').innerText = '';
        document.getElementById('roleError').innerText = '';

        // Get input values
        let name = document.getElementById('name').value.trim();
        let email = document.getElementById('email').value.trim();
        let password = document.getElementById('password').value;
        let role = document.getElementById('role').value;

        let isValid = true;

        // Name validation
        if (name === "") {
            document.getElementById('nameError').innerText = '*Name cannot be empty.';
            isValid = false;
        } else if (!/^[a-zA-Z\s]{2,}$/.test(name)) {
            document.getElementById('nameError').innerText = '*Please enter a valid name (at least 2 letters, letters and spaces only).';
            isValid = false;
        }

        // Email validation
        if (email === "") {
            document.getElementById('emailError').innerText = '*Email cannot be empty.';
            isValid = false;
        } else if (!/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(email)) {
            document.getElementById('emailError').innerText = '*Please enter a valid email address.';
            isValid = false;
        }

        // Password validation
        if (password === "") {
            document.getElementById('passwordError').innerText = '*Password cannot be empty.';
            isValid = false;
        } else if (password.length < 6) {
            document.getElementById('passwordError').innerText = '*Password must be at least 6 characters long.';
            isValid = false;
        } else if (!/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password) || !/[\W_]/.test(password)) {
            document.getElementById('passwordError').innerText = '*Password must contain uppercase, lowercase, digit, and special character.';
            isValid = false;
        }

        // Role validation
        if (role === "") {
            document.getElementById('roleError').innerText = '*Please select a role.';
            isValid = false;
        }

        if (isValid) {
            alert('Registration successful!');
            // submit the form (e.g., via AJAX) or php
            // this.submit(); // Uncomment if you want to submit normally
        }
    });

    // Login Form Validation
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();

        document.getElementById('loginEmailError').innerText = '';
        document.getElementById('loginPasswordError').innerText = '';

        let email = document.getElementById('loginEmail').value.trim();
        let password = document.getElementById('loginPassword').value;

        let isValid = true;

        // Email validation
        if (email === "") {
            document.getElementById('loginEmailError').innerText = '*Email cannot be empty.';
            isValid = false;
        } else if (!/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(email)) {
            document.getElementById('loginEmailError').innerText = '*Please enter a valid email address.';
            isValid = false;
        }

        // Password validation
        if (password === "") {
            document.getElementById('loginPasswordError').innerText = '*Password cannot be empty.';
            isValid = false;
        }

        if (isValid) {
            alert('Login successful!');
            // You can submit the form (e.g., via AJAX) or php
            // this.submit(); // Uncomment if you want to submit normally
        }
    });