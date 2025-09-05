<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../Authentication/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librarian Dashboard - Library Management System</title>
    <link rel="stylesheet" href="librarian-Style.css">
    <style>
   .action-btn {
   background: #0065d1;
   margin: 0 auto;
   color: white;
   border: none;
   /* padding: 12px; */
   width: 15%;
   border-radius: 5px;
   cursor: pointer;
}
.action-btn:hover {
   background: #113F67;
}
.back-button {
   display: block;
   margin: 15px auto;
   width: 10%;
   height: 45px;
   font-size: 16px;
   font-weight: 600;
   border-radius: 10px;
}


.btn {
   width: 15%;
   display: block;
   margin: 0 auto;
   height: 45px;
   padding: 12px;
   margin-top: 10px;
   border: none;
   border-radius: 8px;
   font-size: 16px;
   font-weight: bold;
   cursor: pointer;
   background: #007bff;
   color: white;
   transition: 0.3s;
   margin-bottom: 10px;
}
.btn:hover {
   background: #0056b3;
}

/* View Profile */
.view-profile-container {
   background: #fff;
   padding: 50px;
   border-radius: 12px;
   box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
   width: 100%;
   height: 100%;
}
.profile-picture {
   width: 200px;
   border-radius: 100%;
   margin: 10px auto;
   display: block;
}

.profile-name {
   font-size: 20px;
   font-weight: bold;
   text-align: center;
   margin: 20px auto 10px auto;
}

.profile-email {
   color: gray;
   text-align: center;
   margin-bottom: 40px;
   font-size: 16px;
}

.view-profile-container button {
   display: block;
   padding: 10px 30px;
   margin: 20px auto;
   font-size: 16px;
}

/* Update Profile */
.update-profile-container {
   background: #fff;
   padding: 50px;
   border-radius: 12px;
   box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
   width: 100%;
   height: 100%;
}

.update-profile-container h2 {
   text-align: center;
   margin-bottom: 40px;
   color: #333;
}

.form-group {
   /* margin-bottom: 4px;
   margin-top: 8px; */
   margin: 10px auto;
   width: 50%;
}

.form-group label {
   display: block;
   font-size: 18px;
   margin-bottom: 5px;
   font-weight: bold;
   color: #555;
}

.form-group input {
   width: 100%;
   height: 45px;
   padding: 10px;
   border: 1px solid #ccc;
   border-radius: 8px;
   outline: none;
   font-size: 14px;
}

.form-group input:focus {
   border-color: #007bff;
}

/* error message */
.error{
   padding-bottom: 10px;
   color: red;
   font-size: small;
}


    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <h2>📚 Library Management System</h2>
                <p>Librarian Portal</p>
            </div>
            <div class="librarian-info">
                <div class="librarian-avatar">LP</div>
                <div>
                    <strong><?= $_SESSION['name']; ?></strong><br>
                    <small>Senior Librarian</small>
                </div>
                <button class="logout-btn" onclick="window.location.href='../../Authentication/logout.php'">Logout</button>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="stats-grid">
            <div class="stat-card books">
                <div class="stat-number" id="totalBooks">1,000</div>
                <div class="stat-label">Total Books</div>
            </div>
        <div class="stat-card manageUsers">
                <div class="stat-number" id="manageUsersNumber">10</div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-card issued">
                <div class="stat-number" id="booksIssued">100</div>
                <div class="stat-label">Books Issued</div>
            </div>
            <div class="stat-card returned">
                <div class="stat-number" id="todayReturns">10</div>
                <div class="stat-label">Today's Returns</div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="nav-tabs">
            <button class="nav-tab active" onclick="showSection('circulation')">🏠 Home</button>
            <button class="nav-tab" onclick="showSection('books')">📚 Manage Books</button>
            <button class="nav-tab" onclick="showSection('manageUsers')">👥 Manage Users</button>
            <button class="nav-tab" onclick="showSection('settings')">⚙️ Settings</button>
        </div>

        <!-- Circulation Section -->
        <div id="circulation" class="content-section active">
            <!-- ... (your existing code for circulation section) ... -->
            
        </div>

        <!-- Books Management Section -->
        <div id="books" class="content-section">
            <!-- ... (your existing code for books management section) ... -->
        </div>

        <!-- Manage Users & Fines Section -->
        <div id="manageUsers" class="content-section">
            <!-- ... (your existing code for manageUsers & fines section) ... -->
            
        </div>

        Settings Section<!-- Settings Section -->
<div id="settings" class="content-section">
    <!-- View Profile -->
    <div id="viewProfile" class="view-profile-container">
        <img
            class="profile-picture"
            src="images/profile-picture.png"
            alt="Profile Picture"
        />
        <p class="profile-name"><?= $_SESSION['name']; ?></p>
        <p class="profile-email"> Gmail: <strong><?= $_SESSION['email']; ?></strong></p>

        <!-- Edit Profile Buttons -->
        <button
            id="editProfileButton"
            class="action-btn"
            onclick="editProfile()"
        >
            Edit Profile
        </button>
        <button
            id="changeNameButton"
            class="action-btn"
            onclick="changeName()"
        >
            Change Name
        </button>
        <button
            id="resetPasswordButton"
            class="action-btn"
            onclick="resetPassword()"
        >
            Reset Password
        </button>
    </div>

    <!-- Update Profile -->
    <div
        id="editProfile"
        class="update-profile-container section hidden"
    >
        <h2>Edit Name and Password</h2>
        <form id="updateProfileForm" autocomplete="off" novalidate>
            <div class="form-group">
                <label for="name">Name</label>
                <input
                    type="text"
                    id="name"
                    placeholder="Enter your name"
                    required
                />
                <div class="error" id="nameError"></div>
            </div>
            <div class="form-group">
                <label for="oldPassword">Old Password</label>
                <input
                    type="password"
                    id="oldPassword"
                    placeholder="Enter your old password"
                    required
                />
                <div class="error" id="oldPasswordError"></div>
            </div>
            <div class="form-group">
                <label for="newPassword">New Password</label>
                <input
                    type="password"
                    id="newPassword"
                    placeholder="Enter a new password"
                    required
                />
                <div class="error" id="newPasswordError"></div>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input
                    type="password"
                    id="confirmPassword"
                    placeholder="Confirm password"
                    required
                />
                <div class="error" id="confirmPasswordError"></div>
            </div>
            <button type="submit" class="btn">Update</button>
        </form>
        <button
            id="backToProfileButton"
            class="logout-btn back-button"
            onclick="backToProfile()"
        >
            Back
        </button>
    </div>

    <!-- Change Name -->
    <div
        id="changeName"
        class="update-profile-container section hidden"
    >
        <h2>Change Name</h2>
        <form id="changeNameForm" autocomplete="off" novalidate>
            <div class="form-group">
                <label for="newName">New Name</label>
                <input
                    type="text"
                    id="newName"
                    placeholder="Enter your new full name"
                    required
                />
                <div class="error" id="newNameError"></div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    placeholder="Enter your password"
                    required
                />
                <div class="error" id="passwordError"></div>
            </div>
            <button type="submit" class="btn">Update</button>
        </form>
        <button
            id="backToProfileButton2"
            class="logout-btn back-button"
            onclick="backToProfile()"
        >
            Back
        </button>
    </div>

    <!-- Reset Password -->
    <div
        id="resetPassword"
        class="update-profile-container section hidden"
    >
        <h2>Reset Password</h2>
        <form id="resetPasswordForm" autocomplete="off" novalidate>
            <div class="form-group">
                <label for="currentPassword">Current Password</label>
                <input
                    type="password"
                    id="currentPassword"
                    placeholder="Enter your current password"
                    required
                />
                <div class="error" id="currentPasswordError"></div>
            </div>
            <div class="form-group">
                <label for="resetNewPassword">New Password</label>
                <input
                    type="password"
                    id="resetNewPassword"
                    placeholder="Enter your new password"
                    required
                />
                <div class="error" id="newPasswordError"></div>
            </div>
            <div class="form-group">
                <label for="resetConfirmPassword">Confirm Password</label>
                <input
                    type="password"
                    id="resetConfirmPassword"
                    placeholder="Confirm your new password"
                    required
                />
                <div class="error" id="resetConfirmPasswordError"></div>
            </div>
            <button type="submit" class="btn">Reset Password</button>
        </form>
        <button
            id="backToProfileButton3"
            class="logout-btn back-button"
            onclick="backToProfile()"
        >
            Back
        </button>
    </div>
</div>

    <!-- Add Book Modal -->
    <div id="addBookModal" class="modal">
        <!-- ... (your existing code for add book modal) ... -->
    </div>

    <!-- Scripts -->
    <script src="librarian-Script.js"></script>
    <script>
// Edit Profile Modal


// Section show/hide
function editProfile() {
    document.getElementById('viewProfile').classList.add('hidden')
    document.getElementById('editProfile').classList.remove('hidden')
}
function changeName() {
    document.getElementById('viewProfile').classList.add('hidden')
    document.getElementById('changeName').classList.remove('hidden')
}
function resetPassword() {
    document.getElementById('viewProfile').classList.add('hidden')
    document.getElementById('resetPassword').classList.remove('hidden')
}
function backToProfile() {
    document.getElementById('viewProfile').classList.remove('hidden')
    document.getElementById('editProfile').classList.add('hidden')
    document.getElementById('changeName').classList.add('hidden')
    document.getElementById('resetPassword').classList.add('hidden')
    clearAllErrorMessages()
}

// Error clear
function clearAllErrorMessages() {
    // Edit Profile errors
    document.getElementById('nameError').innerText = ''
    document.getElementById('oldPasswordError').innerText = ''
    document.getElementById('newPasswordError').innerText = ''
    document.getElementById('confirmPasswordError').innerText = ''
    // Change Name errors
    document.getElementById('newNameError').innerText = ''
    document.getElementById('passwordError').innerText = ''
    // Reset Password errors
    document.getElementById('currentPasswordError').innerText = ''
    document.getElementById('resetConfirmPasswordError').innerText = ''
}

// Show notification (simple implementation)
function showNotification(message, type) {
    // You can replace with a more sophisticated notification system
    alert(message)
}

// Update Profile Form
document.getElementById('updateProfileForm').addEventListener('submit', function (e) {
    e.preventDefault()
    clearAllErrorMessages()
    let name = document.getElementById('name').value.trim()
    let oldPassword = document.getElementById('oldPassword').value
    let newPassword = document.getElementById('newPassword').value
    let confirmPassword = document.getElementById('confirmPassword').value
    let isValid = true

    // Name validation
    if (name === "") {
        document.getElementById('nameError').innerText = '*Name cannot be empty.'
        isValid = false
    } else if (!/^[a-zA-Z\s]{2,}$/.test(name)) {
        document.getElementById('nameError').innerText = '*Please enter a valid name (at least 2 letters, letters and spaces only).'
        isValid = false
    }
    // Old Password
    if (oldPassword === "") {
        document.getElementById('oldPasswordError').innerText = '*Old password cannot be empty.'
        isValid = false
    }
    // New Password
    if (newPassword === "") {
        document.getElementById('newPasswordError').innerText = '*New password cannot be empty.'
        isValid = false
    } else if (newPassword.length < 6) {
        document.getElementById('newPasswordError').innerText = '*Password must be at least 6 characters long.'
        isValid = false
    } else if (!/[A-Z]/.test(newPassword) || !/[a-z]/.test(newPassword) || !/[0-9]/.test(newPassword) || !/[\W_]/.test(newPassword)) {
        document.getElementById('newPasswordError').innerText = '*Password must contain uppercase, lowercase, digit, and special character.'
        isValid = false
    }
    // Confirm Password
    if (confirmPassword === "") {
        document.getElementById('confirmPasswordError').innerText = '*Please confirm your password.'
        isValid = false
    } else if (newPassword !== confirmPassword) {
        document.getElementById('confirmPasswordError').innerText = '*Passwords do not match.'
        isValid = false
    }
    // New password != Old password
    if (oldPassword === newPassword && oldPassword !== "") {
        document.getElementById('newPasswordError').innerText = '*New password must be different from old password.'
        isValid = false
    }
    if (isValid) {
        document.querySelector('.profile-name').textContent = name
        showNotification('Profile updated successfully!', 'success')
        this.reset()
        setTimeout(() => { backToProfile() }, 1500)
    }
})

// Change Name Form
document.getElementById('changeNameForm').addEventListener('submit', function (e) {
    e.preventDefault()
    clearAllErrorMessages()
    let newName = document.getElementById('newName').value.trim()
    let password = document.getElementById('password').value
    let isValid = true

    // Name validation
    if (newName === "") {
        document.getElementById('newNameError').innerText = '*Name cannot be empty.'
        isValid = false
    } else if (!/^[a-zA-Z\s]{2,}$/.test(newName)) {
        document.getElementById('newNameError').innerText = '*Please enter a valid name (at least 2 letters, letters and spaces only).'
        isValid = false
    }
    // Password validation
    if (password === "") {
        document.getElementById('passwordError').innerText = '*Password cannot be empty.'
        isValid = false
    }
    if (isValid) {
        document.querySelector('.profile-name').textContent = newName
        showNotification(`Name changed to "${newName}" successfully!`, 'success')
        this.reset()
        setTimeout(() => { backToProfile() }, 1500)
    }
})

// Reset Password Form
document.getElementById('resetPasswordForm').addEventListener('submit', function (e) {
    e.preventDefault()
    clearAllErrorMessages()
    let currentPassword = document.getElementById('currentPassword').value
    let resetNewPassword = document.getElementById('resetNewPassword').value
    let resetConfirmPassword = document.getElementById('resetConfirmPassword').value
    let isValid = true

    // Current Password
    if (currentPassword === "") {
        document.getElementById('currentPasswordError').innerText = '*Current password cannot be empty.'
        isValid = false
    }
    // New Password
    if (resetNewPassword === "") {
        document.getElementById('newPasswordError').innerText = '*New password cannot be empty.'
        isValid = false
    } else if (resetNewPassword.length < 6) {
        document.getElementById('newPasswordError').innerText = '*Password must be at least 6 characters long.'
        isValid = false
    } else if (!/[A-Z]/.test(resetNewPassword) || !/[a-z]/.test(resetNewPassword) || !/[0-9]/.test(resetNewPassword) || !/[\W_]/.test(resetNewPassword)) {
        document.getElementById('newPasswordError').innerText = '*Password must contain uppercase, lowercase, digit, and special character.'
        isValid = false
    }
    // Confirm Password
    if (resetConfirmPassword === "") {
        document.getElementById('resetConfirmPasswordError').innerText = '*Please confirm your password.'
        isValid = false
    } else if (resetNewPassword !== resetConfirmPassword) {
        document.getElementById('resetConfirmPasswordError').innerText = '*Passwords do not match.'
        isValid = false
    }
    // New password != Current password
    if (currentPassword === resetNewPassword && currentPassword !== "") {
        document.getElementById('newPasswordError').innerText = '*New password must be different from current password.'
        isValid = false
    }
    if (isValid) {
        showNotification('Password reset successfully!', 'success')
        this.reset()
        setTimeout(() => { backToProfile() }, 1500)
    }
})

function logout() {
    if (confirm('Are you sure you want to logout?')) {
        alert('Logged out successfully!')
    }
}
    </script>
</body>
</html>
