// Navigation tab switching
        function showSection(sectionId) {
            document.querySelectorAll('.content-section').forEach(function(sec) {
                sec.classList.remove('active');
            });
            document.getElementById(sectionId).classList.add('active');
            document.querySelectorAll('.nav-tab').forEach(function(tab) {
                tab.classList.remove('active');
            });
            document.querySelector('.nav-tab[onclick="showSection(\'' + sectionId + '\')"]').classList.add('active');
        }

        // Modal functions
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Dummy logout function
        function logout() {
            alert('Logging out...');
            // Redirect or perform logout logic here
        }

// User management
// function showManageUser() {
//     document.getElementById('userSection').style.display = 'none';
//     document.getElementById('addUserSection').style.display = 'block';
// }
// function showBackUser() {
//     document.getElementById('userSection').style.display = 'block';
//     document.getElementById('addUserSection').style.display = 'none';
    
// }

        // Edit Profile Modal

// edit button functions // Section show/hide
function showEditProfile() {
    document.getElementById('editProfile').style.display = 'block';
    document.getElementById('changeName').style.display = 'none';
    document.getElementById('resetPassword').style.display = 'none';
    document.getElementById('viewProfile').style.display = 'none';
}

function showChangeName() {
    document.getElementById('changeName').style.display = 'block';
    document.getElementById('editProfile').style.display = 'none';
    document.getElementById('resetPassword').style.display = 'none';
    document.getElementById('viewProfile').style.display = 'none';
}

function showResetPassword() {
    document.getElementById('resetPassword').style.display = 'block';
    document.getElementById('editProfile').style.display = 'none';
    document.getElementById('changeName').style.display = 'none';
    document.getElementById('viewProfile').style.display = 'none';
}
function backToProfile() {
    document.getElementById('resetPassword').style.display = 'none';
    document.getElementById('editProfile').style.display = 'none';
    document.getElementById('changeName').style.display = 'none';
    document.getElementById('viewProfile').style.display = 'block';
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
