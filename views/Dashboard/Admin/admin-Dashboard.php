<?php
include '../../Authentication/crud.php';
// session_start();
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
    <title>Admin Dashboard - Library Management System</title>
    <link rel="stylesheet" href="../../assets/css/dashboard-style/admin-Style.css">
    <style>
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
        
        .btnE {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
            padding: 5px 10px;
        }
        
        /* .btnE:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
         */
        .btnEdit {
            background-color: #FFC900;
            color: white;
        }
        
        .btnEdit:hover {
            background-color: #FF9B00;
        }
        
        .btnDelete {
            background-color: #FB4141;
            color: white;
        }
        
        .btnDelete:hover {
            background-color: #B12C00;
        }
        
        .btnProtected {
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
            align-items: center;
        }
        
        .role-admin { 
            background-color: #dc3545; 
            color: white; 
        }
        .role-librarian { 
            background-color: #28a745; 
            color: white; 
        }
        .role-student { 
            background-color: #17a2b8;  
            color: white; 
        }
        
        .modal {
            display: none;
            /* position: fixed; */
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }
        
        .modalContent {
            background-color: white;
            margin: 10% auto;
            top: 0%;
            padding: 25px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        #editUserBtn{
            background-color: #4a90e2;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s ease;
            display: block;
            width: 30%;
            margin:15px auto 0px auto;
        }
        #editUserBtn:hover {
            background-color: #357abd;

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
            text-align: center;
            color: red;
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
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <h2>📚 Library Management System</h2>
                <p>Administrator Dashboard</p>
            </div>
            <div class="admin-info">
                <div class="admin-avatar">A</div>
                <div>
                    <strong><?= $_SESSION['name']; ?></strong><br>
                    <small>System Administrator</small>
                </div>
                <button class="logout-btn" 
                onclick="window.location.href='../../Authentication/logout.php'">Logout</button>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="stats-grid">
            <div class="stat-card users">
                <div class="stat-number" id="totalUsers">156</div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-card books">
                <div class="stat-number" id="totalBooks">1,247</div>
                <div class="stat-label">Total Books</div>
            </div>
            <div class="stat-card issued">
                <div class="stat-number" id="issuedBooks">89</div>
                <div class="stat-label">Books Issued</div>
            </div>
            <div class="stat-card overdue">
                <div class="stat-number" id="overdueBooks">12</div>
                <div class="stat-label">Overdue Books</div>
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
    
    <!-- User List -->
    <div id="userSection" style="height: 80vh; overflow-y: auto;">
        <div>
            <button class="btn" onclick="window.location.href='../../Authentication/addUsers-Admin.php'" style="margin-bottom: 15px;">
                Add New User
            </button>
        </div>

        <h2 style="margin-bottom: 10px;">Manage Users</h2>

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
                    echo "<button class='btnE btnEdit' onclick='editUser(" . $row['id'] . ", \"" . addslashes($row['name']) . "\",
                     \"" . addslashes($row['email']) . "\", \"" . $row['role'] . "\")'> Edit</button>";
                    
                    if ($row['email'] !== 'sabbir@gmail.com') {
                        echo "<button class='btnE btnDelete' onclick='deleteUser(" . $row['id'] . ", \"" . addslashes($row['name']) . "\")'> Delete</button>";
                    } else {
                        echo "<button class='btnE btnProtected' title='Super Admin - Cannot be deleted'> Protected</button>";
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
    <div class="modalContent">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h3>Edit User </h3>
        <form action="" method="post" id="editForm">
            <input type="hidden" name="edit_id" id="edit_id">

            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" name="edit_name" id="edit_name" required>
                <span id="editNameError" class="error-message" style="color:red;"></span>
            </div>

            <div class="form-group">
                <label>Email Address:</label>
                <input type="email" name="edit_email" id="edit_email" required>
                <span id="editEmailError" class="error-message" style="color:red;"></span>
            </div>

            <div class="form-group">
                <label>Password (Leave blank to keep current):</label>
                <input type="password" name="edit_password" id="edit_password" minlength="6">
                <small style="color: #666; font-size: 12px;">Only enter if you want to change the password</small>
                <span id="editPasswordError" class="error-message" style="color:red;"></span>
            </div>

            <div class="form-group">
                <label>User Role:</label>
                <select name="edit_role" id="edit_role" required>
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="librarian">Librarian</option>
                    <option value="student">Student</option>
                </select>
                <span id="editRoleError" class="error-message" style="color:red;"></span>
            </div>

            <input type="submit" id="editUserBtn" value=" Update User">
        </form>
    </div>
</div>

    </div>
</div>


           


      <!-- Settings Section -->
<div id="settings" class="content-section">
    <!-- View Profile -->
    <div id="viewProfile" class="view-profile-container">
        <img
            class="profile-picture"
            src="../../assets/images/profile-picture.png"
            alt="Profile Picture"
        />
        <p class="profile-name"><?= $_SESSION['name']; ?></p>
        <p class="profile-email"> Gmail: <strong><?= $_SESSION['email']; ?></strong></p>

        <!-- Edit Profile Buttons -->
        <button
            id="editProfileButton"
            class="action-btn"
            onclick="showEditProfile()"
        >
            Edit Profile
        </button>
        <button
            id="changeNameButton"
            class="action-btn"
            onclick="showChangeName()"
        >
            Change Name
        </button>
        <button
            id="resetPasswordButton"
            class="action-btn"
            onclick="showResetPassword()"
        >
            Reset Password
        </button>
    </div>

    <!-- Update Profile -->
    <div
        id="editProfile"
        class="update-profile-container section hidden"
        style="display:none;"
    >
        <h2>Edit Name and Password</h2>
        <form id="updateProfileForm" autocomplete="off" novalidate>
            <div class="form-group">
                <label for="name">New Name</label>
                <input
                    type="text"
                    id="name"
                    placeholder="Enter your name"
                    required
                />
                <div class="error" id="nameError"></div>
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
            <div class="form-group">
                <label for="oldPassword">Current Password</label>
                <input
                    type="password"
                    id="oldPassword"
                    placeholder="Enter your old password"
                    required
                />
                <div class="error" id="oldPasswordError"></div>
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
        style="display:none;"
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
                <label for="password">Current Password</label>
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
        style="display:none;"
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

   <script src="../../assets/app/dashboard-Script/admin-Script.js"></script>

<script>
// Show user list and hide the add-user form
function showManageUsers() {
    document.getElementById('userSection').style.display = 'block';
    document.getElementById('addUserSection').style.display = 'none';
}

// Show add-user form and hide the user list
function showRegisterForm() {
    document.getElementById('userSection').style.display = 'none';
    document.getElementById('addUserSection').style.display = 'block';
}
</script>

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

        // Edit Form Validation with inline error messages
    document.getElementById('editForm').addEventListener('submit', function(e) {
        let isValid = true;

        // Get input values
        const name = document.getElementById('edit_name').value.trim();
        const email = document.getElementById('edit_email').value.trim();
        const password = document.getElementById('edit_password').value;
        const role = document.getElementById('edit_role').value;

        // Get error spans
        const nameError = document.getElementById('editNameError');
        const emailError = document.getElementById('editEmailError');
        const passwordError = document.getElementById('editPasswordError');
        const roleError = document.getElementById('editRoleError');

        // Clear previous errors
        nameError.innerText = '';
        emailError.innerText = '';
        passwordError.innerText = '';
        roleError.innerText = '';

        // Name validation
    if (name === "") {
        nameError.innerText = '*Name cannot be empty.';
        isValid = false;
    } else if (!/^[a-zA-Z\s]{2,}$/.test(name)) {
        nameError.innerText = '*Please enter a valid name (at least 2 letters, letters and spaces only).';
        isValid = false;
    }

    // Email validation
    if (email === "") {
        emailError.innerText = '*Email cannot be empty.';
        isValid = false;
    } else if (!/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(email)) {
        emailError.innerText = '*Please enter a valid email address.';
        isValid = false;
    }

    // Password validation (optional if left blank)
    if (password !== "") {
        if (password.length < 6) {
            passwordError.innerText = '*Password must be at least 6 characters long.';
            isValid = false;
        } else if (!/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password) || !/[\W_]/.test(password)) {
            passwordError.innerText = '*Password must contain uppercase, lowercase, digit, and special character.';
            isValid = false;
        }
    }

    // Role validation
    if (role === "") {
        roleError.innerText = '*Please select a role.';
        isValid = false;
    }

    // Only prevent form submission if validation fails
    if (!isValid) {
        e.preventDefault();
    }
});

    console.log('User Management System Loaded Successfully!');
    </script>

</body>
</html>


               