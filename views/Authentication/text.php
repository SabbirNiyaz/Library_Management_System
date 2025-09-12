<?php
session_start();
require_once 'config.php';

// Handle Delete User
if (isset($_POST['delete_id'])) {
    $user_id = intval($_POST['delete_id']);
    
    // Prevent deletion of the super admin (sabbir@gmail.com)
    $check_super_admin = $conn->prepare("SELECT email FROM all_users WHERE id = ?");
    $check_super_admin->bind_param("i", $user_id);
    $check_super_admin->execute();
    $result = $check_super_admin->get_result();
    $user_to_delete = $result->fetch_assoc();
    
    if ($user_to_delete && $user_to_delete['email'] === 'sabbir@gmail.com') {
        echo "<script>alert('Cannot delete super admin account!');</script>";
    } else {
        $stmt = $conn->prepare("DELETE FROM all_users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        
        if ($stmt->execute()) {
            echo "<script>alert('User deleted successfully!');</script>";
        } else {
            echo "<script>alert('Delete error: " . $conn->error . "');</script>";
        }
    }
}

// Handle Add User
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['role'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    
    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT email FROM all_users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();
    
    if ($result->num_rows > 0) {
        echo "<script>alert('Email is already registered!');</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO all_users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $role);
        
        if ($stmt->execute()) {
            echo "<script>alert('New user created successfully!');</script>";
        } else {
            echo "<script>alert('Data insert error: " . $conn->error . "');</script>";
        }
    }
}

// Handle Update User
if (isset($_POST['edit_id']) && isset($_POST['edit_name']) && isset($_POST['edit_email']) && isset($_POST['edit_role'])) {
    $user_id = intval($_POST['edit_id']);
    $name = trim($_POST['edit_name']);
    $email = trim($_POST['edit_email']);
    $role = $_POST['edit_role'];
    
    // Check if email already exists (excluding current user)
    $checkEmail = $conn->prepare("SELECT email FROM all_users WHERE email = ? AND id != ?");
    $checkEmail->bind_param("si", $email, $user_id);
    $checkEmail->execute();
    $result = $checkEmail->get_result();
    
    if ($result->num_rows > 0) {
        echo "<script>alert('Email is already taken by another user!');</script>";
    } else {
        if (!empty($_POST['edit_password'])) {
            // Update with new password
            $password = password_hash($_POST['edit_password'], PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE all_users SET name = ?, email = ?, password = ?, role = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $name, $email, $password, $role, $user_id);
        } else {
            // Update without changing password
            $stmt = $conn->prepare("UPDATE all_users SET name = ?, email = ?, role = ? WHERE id = ?");
            $stmt->bind_param("sssi", $name, $email, $role, $user_id);
        }
        
        if ($stmt->execute()) {
            echo "<script>alert('User updated successfully!');</script>";
        } else {
            echo "<script>alert('Update error: " . $conn->error . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System - Library Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .form-container h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .form-container input, .form-container select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px 0;
            border: 2px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        
        .form-container input:focus, .form-container select:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }
        
        .form-container input[type="submit"] {
            background-color: #4a90e2;
            color: white;
            cursor: pointer;
            font-weight: bold;
            width: auto;
            padding: 12px 25px;
            margin-top: 10px;
        }
        
        .form-container input[type="submit"]:hover {
            background-color: #357abd;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .search-container {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .search-input {
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            width: 300px;
            outline: none;
            transition: border-color 0.3s ease;
        }
        
        .search-input:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }
        
        .btn-search {
            background-color: #4a90e2;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .btn-search:hover {
            background-color: #357abd;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        th {
            background-color: #4a90e2;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: middle;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #e8f4f8;
        }
        
        .operation-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .btn-edit {
            background-color: #28a745;
            color: white;
        }
        
        .btn-edit:hover {
            background-color: #218838;
        }
        
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-delete:hover {
            background-color: #c82333;
        }
        
        .btn-protected {
            background-color: #6c757d;
            color: white;
            cursor: not-allowed;
            opacity: 0.6;
        }
        
        .role-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .role-admin { 
            background-color: #dc3545; 
            color: white; 
        }
        .role-librarian { 
            background-color: #17a2b8; 
            color: white; 
        }
        .role-student { 
            background-color: #28a745; 
            color: white; 
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }
        
        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 25px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close:hover {
            color: black;
        }
        
        .modal h3 {
            color: #333;
            margin-bottom: 20px;
        }
        
        .modal .form-group {
            margin-bottom: 15px;
        }
        
        .modal label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        
        .modal input, .modal select {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .modal input:focus, .modal select:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }
        
        .header-title {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            text-align: center;
        }
        
        .header-title h2 {
            color: #4a90e2;
            margin: 0;
            font-size: 24px;
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #4a90e2;
        }
        
        .stat-label {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }
        
        @media (max-width: 768px) {
            body {
                margin: 10px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .search-container {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-input {
                width: 100%;
                margin-bottom: 10px;
            }
            
            .operation-buttons {
                flex-direction: column;
            }
            
            table {
                font-size: 12px;
            }
            
            th, td {
                padding: 8px 6px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header-title">
        <h2>User Management System</h2>
        <p>Library Management System - Manage Users Efficiently</p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-container">
        <?php
        // Get user statistics
        $total_users = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM all_users"));
        $total_admins = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM all_users WHERE role='admin'"));
        $total_librarians = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM all_users WHERE role='librarian'"));
        $total_students = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM all_users WHERE role='student'"));
        ?>
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_users; ?></div>
            <div class="stat-label">Total Users</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_admins; ?></div>
            <div class="stat-label">Admins</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_librarians; ?></div>
            <div class="stat-label">Librarians</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_students; ?></div>
            <div class="stat-label">Students</div>
        </div>
    </div>

    <!-- Add User Form -->
    <div class="form-container">
        <h3>➕ Add New User</h3>
        <form action="" method="post">
            <div class="form-row">
                <div>
                    <label>Full Name:</label>
                    <input type="text" name="name" placeholder="Enter full name" required>
                </div>
                <div>
                    <label>Email Address:</label>
                    <input type="email" name="email" placeholder="Enter email address" required>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label>Password:</label>
                    <input type="password" name="password" placeholder="Enter password" required minlength="6">
                </div>
                <div>
                    <label>User Role:</label>
                    <select name="role" required>
                        <option value="">Select Role</option>
                        <option value="admin">Admin</option>
                        <option value="librarian">Librarian</option>
                        <option value="student">Student</option>
                    </select>
                </div>
            </div>
            <input type="submit" value="Add User">
        </form>
    </div>

    <!-- Search Container -->
    <div class="search-container">
        <input type="text" class="search-input" id="searchInput" placeholder="Search by name, email, or role...">
        <button class="btn-search" onclick="searchTable()"> Search</button>
    </div>

    <!-- Users Table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $display_sql = "SELECT * FROM all_users ORDER BY id DESC";
            $result = mysqli_query($conn, $display_sql);
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td><strong>#" . sprintf("%03d", $row['id']) . "</strong></td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td><span class='role-badge role-" . $row['role'] . "'>" . ucfirst($row['role']) . "</span></td>";
                    echo "<td>";
                    echo "<div class='operation-buttons'>";
                    echo "<button class='btn btn-edit' onclick='editUser(" . $row['id'] . ", \"" . addslashes($row['name']) . "\", \"" . addslashes($row['email']) . "\", \"" . $row['role'] . "\")'> Edit</button>";
                    
                    if ($row['email'] !== 'sabbir@gmail.com') {
                        echo "<button class='btn btn-delete' onclick='deleteUser(" . $row['id'] . ", \"" . addslashes($row['name']) . "\")'> Delete</button>";
                    } else {
                        echo "<button class='btn btn-protected' title='Super Admin - Cannot be deleted'>🔒 Protected</button>";
                    }
                    
                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align: center; padding: 30px; color: #666;'> No users found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Edit User Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h3>Edit User Details</h3>
            <form action="" method="post" id="editForm">
                <input type="hidden" name="edit_id" id="edit_id">
                
                <div class="form-group">
                    <label>Full Name:</label>
                    <input type="text" name="edit_name" id="edit_name" required>
                </div>
                
                <div class="form-group">
                    <label>Email Address:</label>
                    <input type="email" name="edit_email" id="edit_email" required>
                </div>
                
                <div class="form-group">
                    <label>Password (Leave blank to keep current):</label>
                    <input type="password" name="edit_password" id="edit_password" minlength="6">
                    <small style="color: #666; font-size: 12px;">Only enter if you want to change the password</small>
                </div>
                
                <div class="form-group">
                    <label>User Role:</label>
                    <select name="edit_role" id="edit_role" required>
                        <option value="admin">Admin</option>
                        <option value="librarian">Librarian</option>
                        <option value="student">Student</option>
                    </select>
                </div>
                
                <input type="submit" value=" Update User">
            </form>
        </div>
    </div>

    <script>
        function editUser(id, name, email, role) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;
            document.getElementById('edit_password').value = '';
            document.getElementById('editModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
        
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        function deleteUser(id, name) {
            if (confirm(' Are you sure you want to delete this user?\n\nName: ' + name + '\n\nThis action cannot be undone!')) {
                const form = document.createElement('form');
                form.method = 'post';
                form.innerHTML = '<input type="hidden" name="delete_id" value="' + id + '">';
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        function searchTable() {
            const searchInput = document.getElementById('searchInput');
            const searchTerm = searchInput.value.toLowerCase();
            const table = document.querySelector('table tbody');
            const rows = table.getElementsByTagName('tr');
            
            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                if (row.cells.length > 1) {
                    const name = row.cells[1].textContent.toLowerCase();
                    const email = row.cells[2].textContent.toLowerCase();
                    const role = row.cells[3].textContent.toLowerCase();
                    
                    if (name.includes(searchTerm) || email.includes(searchTerm) || role.includes(searchTerm) || searchTerm === '') {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        }
        
        // Real-time search as user types
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', searchTable);
        });
        
        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target == modal) {
                closeEditModal();
            }
        }
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeEditModal();
            }
        });
        
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = this.querySelector('input[name="password"]').value;
            if (password.length < 6) {
                e.preventDefault();
                alert(' Password must be at least 6 characters long!');
                return false;
            }
        });
        
        document.getElementById('editForm').addEventListener('submit', function(e) {
            const password = document.getElementById('edit_password').value;
            if (password && password.length < 6) {
                e.preventDefault();
                alert(' Password must be at least 6 characters long!');
                return false;
            }
        });

        console.log('User Management System Loaded Successfully!');
    </script>
</body>
</html>