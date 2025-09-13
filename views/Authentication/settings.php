<?php
// session_start();
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