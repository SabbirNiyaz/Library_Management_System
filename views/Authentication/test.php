<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$response = array();

// Handle AJAX profile update request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_profile') {
    $user_email = $_SESSION['email'];
    $new_name = trim($_POST['name']);
    $new_password = $_POST['newPassword'];
    $confirm_password = $_POST['confirmPassword'];
    $old_password = $_POST['oldPassword'];
    
    // Validation
    $errors = array();
    
    // Validate name
    if (empty($new_name)) {
        $errors['name'] = "Name is required";
    } elseif (strlen($new_name) < 2) {
        $errors['name'] = "Name must be at least 2 characters";
    } elseif (strlen($new_name) > 50) {
        $errors['name'] = "Name must be less than 50 characters";
    }
    
    // Validate passwords
    if (empty($new_password)) {
        $errors['newPassword'] = "New password is required";
    } elseif (strlen($new_password) < 6) {
        $errors['newPassword'] = "Password must be at least 6 characters";
    } elseif (strlen($new_password) > 100) {
        $errors['newPassword'] = "Password must be less than 100 characters";
    }
    
    if (empty($confirm_password)) {
        $errors['confirmPassword'] = "Please confirm your password";
    } elseif ($new_password !== $confirm_password) {
        $errors['confirmPassword'] = "Passwords do not match";
    }
    
    if (empty($old_password)) {
        $errors['oldPassword'] = "Current password is required";
    }
    
    // If no validation errors, proceed with database operations
    if (empty($errors)) {
        // Verify current password
        $stmt = $conn->prepare("SELECT password FROM all_users WHERE email = ?");
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user && password_verify($old_password, $user['password'])) {
            // Check if new name already exists (excluding current user)
            $check_name = $conn->prepare("SELECT name FROM all_users WHERE name = ? AND email != ?");
            $check_name->bind_param("ss", $new_name, $user_email);
            $check_name->execute();
            $name_result = $check_name->get_result();
            
            if ($name_result->num_rows > 0) {
                $errors['name'] = "This name is already taken by another user";
            } else {
                // Update user profile
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_stmt = $conn->prepare("UPDATE all_users SET name = ?, password = ? WHERE email = ?");
                $update_stmt->bind_param("sss", $new_name, $hashed_password, $user_email);
                
                if ($update_stmt->execute()) {
                    $_SESSION['name'] = $new_name; // Update session
                    $response['success'] = true;
                    $response['message'] = "Profile updated successfully!";
                } else {
                    $response['success'] = false;
                    $response['message'] = "Database error: " . $conn->error;
                }
            }
        } else {
            $errors['oldPassword'] = "Current password is incorrect";
        }
    }
    
    if (!empty($errors)) {
        $response['success'] = false;
        $response['errors'] = $errors;
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// Get current user data
$stmt = $conn->prepare("SELECT name, email, role FROM all_users WHERE email = ?");
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
$current_user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile - Library Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .profile-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            backdrop-filter: blur(10px);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #667eea;
        }

        .profile-header h2 {
            color: #2c3e50;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .profile-header p {
            color: #666;
            font-size: 1rem;
        }

        .current-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 4px solid #667eea;
        }

        .current-info h3 {
            color: #495057;
            margin-bottom: 15px;
            font-size: 1.2rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: 600;
            color: #666;
        }

        .info-value {
            font-weight: 500;
            color: #333;
        }

        .role-badge {
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .role-admin { background: #dc3545; color: white; }
        .role-librarian { background: #17a2b8; color: white; }
        .role-student { background: #28a745; color: white; }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #495057;
            font-size: 0.95rem;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input.error {
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        .form-group input.success {
            border-color: #28a745;
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
        }

        .error {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 5px;
            font-weight: 500;
            display: none;
        }

        .error.show {
            display: block;
        }

        .btn {
            width: 100%;
            padding: 14px 25px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .btn:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn .loading {
            display: none;
        }

        .btn.loading .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .alert {
            padding: 15px 20px;
            margin-bottom: 25px;
            border-radius: 10px;
            font-weight: 600;
            display: none;
            animation: slideIn 0.5s ease;
        }

        .alert.show {
            display: block;
        }

        .alert.success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert.error {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .password-strength {
            margin-top: 5px;
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            transition: all 0.3s ease;
            width: 0%;
        }

        .strength-weak { background: #dc3545; width: 25%; }
        .strength-fair { background: #ffc107; width: 50%; }
        .strength-good { background: #17a2b8; width: 75%; }
        .strength-strong { background: #28a745; width: 100%; }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .profile-container {
                padding: 30px 20px;
                margin: 10px;
            }
            
            .profile-header h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h2>Update Profile</h2>
            <p>Manage your account information</p>
        </div>

        <!-- Current User Info -->
        <div class="current-info">
            <h3>Current Information</h3>
            <div class="info-item">
                <span class="info-label">Name:</span>
                <span class="info-value"><?php echo htmlspecialchars($current_user['name']); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Email:</span>
                <span class="info-value"><?php echo htmlspecialchars($current_user['email']); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Role:</span>
                <span class="role-badge role-<?php echo $current_user['role']; ?>">
                    <?php echo ucfirst($current_user['role']); ?>
                </span>
            </div>
        </div>

        <!-- Alert Message -->
        <div id="alertMessage" class="alert"></div>

        <!-- Update Form -->
        <form id="updateProfileForm" autocomplete="off" novalidate>
            <div class="form-group">
                <label for="name">New Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Enter your name"
                    value="<?php echo htmlspecialchars($current_user['name']); ?>"
                    required
                />
                <div class="error" id="nameError"></div>
            </div>
            
            <div class="form-group">
                <label for="newPassword">New Password</label>
                <input
                    type="password"
                    id="newPassword"
                    name="newPassword"
                    placeholder="Enter a new password"
                    required
                />
                <div class="password-strength">
                    <div class="password-strength-bar" id="strengthBar"></div>
                </div>
                <div class="error" id="newPasswordError"></div>
            </div>
            
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input
                    type="password"
                    id="confirmPassword"
                    name="confirmPassword"
                    placeholder="Confirm password"
                    required
                />
                <div class="error" id="confirmPasswordError"></div>
            </div>
            
            <div class="form-group">
                <label for="oldPassword">Current Password</label>
                <input
                    type="password"
                    id="oldPassword"
                    name="oldPassword"
                    placeholder="Enter your current password"
                    required
                />
                <div class="error" id="oldPasswordError"></div>
            </div>
            
            <button type="submit" class="btn" id="updateBtn">
                <div class="loading"></div>
                <span class="btn-text">Update Profile</span>
            </button>
        </form>

        <div class="back-link">
            <a href="javascript:history.back()">&larr; Back to Dashboard</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('updateProfileForm');
            const nameField = document.getElementById('name');
            const newPasswordField = document.getElementById('newPassword');
            const confirmPasswordField = document.getElementById('confirmPassword');
            const oldPasswordField = document.getElementById('oldPassword');
            const updateBtn = document.getElementById('updateBtn');
            const strengthBar = document.getElementById('strengthBar');
            const alertMessage = document.getElementById('alertMessage');

            // Password strength checker
            function checkPasswordStrength(password) {
                let strength = 0;
                if (password.length >= 6) strength++;
                if (password.match(/[a-z]/)) strength++;
                if (password.match(/[A-Z]/)) strength++;
                if (password.match(/[0-9]/)) strength++;
                if (password.match(/[^A-Za-z0-9]/)) strength++;
                
                return strength;
            }

            // Update password strength bar
            newPasswordField.addEventListener('input', function() {
                const password = this.value;
                const strength = checkPasswordStrength(password);
                
                strengthBar.className = 'password-strength-bar';
                
                if (password.length === 0) {
                    strengthBar.style.width = '0%';
                } else if (strength <= 1) {
                    strengthBar.classList.add('strength-weak');
                } else if (strength <= 2) {
                    strengthBar.classList.add('strength-fair');
                } else if (strength <= 3) {
                    strengthBar.classList.add('strength-good');
                } else {
                    strengthBar.classList.add('strength-strong');
                }
            });

            // Real-time validation
            function validateField(field, errorElement, validationFunc) {
                field.addEventListener('blur', function() {
                    const error = validationFunc(this.value);
                    if (error) {
                        this.classList.add('error');
                        this.classList.remove('success');
                        errorElement.textContent = error;
                        errorElement.classList.add('show');
                    } else {
                        this.classList.remove('error');
                        this.classList.add('success');
                        errorElement.classList.remove('show');
                    }
                });

                field.addEventListener('input', function() {
                    if (this.classList.contains('error')) {
                        const error = validationFunc(this.value);
                        if (!error) {
                            this.classList.remove('error');
                            this.classList.add('success');
                            errorElement.classList.remove('show');
                        }
                    }
                });
            }

            // Validation functions
            validateField(nameField, document.getElementById('nameError'), function(value) {
                if (!value.trim()) return 'Name is required';
                if (value.trim().length < 2) return 'Name must be at least 2 characters';
                if (value.trim().length > 50) return 'Name must be less than 50 characters';
                return null;
            });

            validateField(newPasswordField, document.getElementById('newPasswordError'), function(value) {
                if (!value) return 'New password is required';
                if (value.length < 6) return 'Password must be at least 6 characters';
                if (value.length > 100) return 'Password must be less than 100 characters';
                return null;
            });

            validateField(confirmPasswordField, document.getElementById('confirmPasswordError'), function(value) {
                if (!value) return 'Please confirm your password';
                if (value !== newPasswordField.value) return 'Passwords do not match';
                return null;
            });

            validateField(oldPasswordField, document.getElementById('oldPasswordError'), function(value) {
                if (!value) return 'Current password is required';
                return null;
            });

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Clear previous errors
                document.querySelectorAll('.error').forEach(error => error.classList.remove('show'));
                document.querySelectorAll('input').forEach(input => {
                    input.classList.remove('error', 'success');
                });

                // Show loading state
                updateBtn.classList.add('loading');
                updateBtn.disabled = true;

                // Prepare form data
                const formData = new FormData();
                formData.append('action', 'update_profile');
                formData.append('name', nameField.value.trim());
                formData.append('newPassword', newPasswordField.value);
                formData.append('confirmPassword', confirmPasswordField.value);
                formData.append('oldPassword', oldPasswordField.value);

                // Submit form
                fetch('', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('Profile updated successfully! 🎉', 'success');
                        form.reset();
                        
                        // Update current info display
                        document.querySelector('.info-value').textContent = nameField.value.trim();
                        
                        // Reset password strength bar
                        strengthBar.style.width = '0%';
                        strengthBar.className = 'password-strength-bar';
                        
                        // Optionally redirect after success
                        setTimeout(() => {
                            // window.location.href = 'dashboard.php';
                        }, 2000);
                    } else {
                        if (data.errors) {
                            // Show field-specific errors
                            Object.keys(data.errors).forEach(field => {
                                const errorElement = document.getElementById(field + 'Error');
                                const inputElement = document.getElementById(field === 'newPassword' ? 'newPassword' : field);
                                
                                if (errorElement && inputElement) {
                                    errorElement.textContent = data.errors[field];
                                    errorElement.classList.add('show');
                                    inputElement.classList.add('error');
                                }
                            });
                        } else {
                            showAlert(data.message || 'An error occurred. Please try again.', 'error');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Network error. Please try again.', 'error');
                })
                .finally(() => {
                    // Hide loading state
                    updateBtn.classList.remove('loading');
                    updateBtn.disabled = false;
                });
            });

            // Show alert function
            function showAlert(message, type) {
                alertMessage.textContent = message;
                alertMessage.className = `alert ${type} show`;
                
                // Auto-hide after 5 seconds
                setTimeout(() => {
                    alertMessage.classList.remove('show');
                }, 5000);
            }

            console.log('🎉 Profile Update System Loaded Successfully!');
        });
    </script>
</body>
</html>