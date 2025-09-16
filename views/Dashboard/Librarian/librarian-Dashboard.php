<?php
include '../../Authentication/crud.php';
include '../../Authentication/manageBooks.php';
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
    <title>Librarian Dashboard - Library Management System</title>
    <link rel="stylesheet" href="../../assets/css/dashboard-style/librarian-Style.css">
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
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .btn-reset {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-reset:hover {
            background-color: #c82333;
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

        /* Add User Form */
        /* Form container */
#userForm {
    width: 50%;
    height: 50%;
    margin: 30px auto;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}
h3{
    color:green;
    margin-bottom:10px; 
}

/* Rows layout */
.form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
}

/* Each field container */
.form-row > div {
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* Labels */
#userForm label {
    font-weight: bold;
    margin-bottom: 6px;
    color: #333;
}

/* Inputs & select */
#userForm input[type="text"],
#userForm input[type="email"],
#userForm input[type="password"],
#userForm select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
    transition: border-color 0.3s;
}

/* Focus effect */
#userForm input:focus,
#userForm select:focus {
    border-color: #007BFF;
    outline: none;
    box-shadow: 0 0 4px rgba(0, 123, 255, 0.2);
}

/* Error message */
.error {
    color: red;
    font-size: 13px;
    margin-top: 4px;
    margin-bottom: 6px;
    height: 16px; /* Reserve space so layout doesn’t jump */
}

/* Submit and back buttons */
#userForm input[type="submit"],
#userForm button {
    padding: 10px 20px;
    display:block;
    margin: 0 auto;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: bold;
}
/* Add User button */
#userForm input[type="submit"] {
    background: #28a745;
    color: white;
    transition: background 0.3s;
}
#userForm input[type="submit"]:hover {
    background: #218838;
}

/* Back button */
#userForm button {
    background: #6c757d;
    color: white;
    transition: background 0.3s;
}
#userForm button:hover {
    background: #5a6268;
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
                <div class="librarian-avatar">L</div>
                <div>
                    <strong><?= $_SESSION['name']; ?></strong><br>
                    <small>Senior Librarian</small>
                </div>
                <button class="logout-btn" onclick="window.location.href='../../Authentication/logout.php'">Logout</button>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="stats-grid">
        <?php
        // Get user and  book statistics
        $total_students = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM all_users WHERE role='student'"));
        ?>
            <div class="stat-card manageUsers">
                <div class="stat-number" id="manageUsersNumber"><?php echo $total_students?> </div>
                <div class="stat-label">Total Students</div>
            </div>
            <div class="stat-card books">
                <div class="stat-number" id="totalBooks">1,000</div>
                <div class="stat-label">Total Books</div>
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
            <!-- <h1>hello</h1>        
    <div id="manageBooks" class="content-section">
         <h1>hello</h1>  -->

        <!-- Book List -->
        <div id="bookSection" style="height: 80vh; overflow-y: auto;">
            <div>
                <button class="btn" 
                onclick="showAddBookForm()" 
                style="margin-bottom: 15px;">
                    Add New Book
                </button>
            </div>

            <h2 style="margin-bottom: 10px;">Manage Books</h2>

            <!-- Wrapper -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin: 15px 0;">

                <!-- Search Container -->
                <div class="search-container" style="display: flex; align-items: center; gap: 10px;">
                    <input type="text" class="search-input" id="searchBookInput" 
                           placeholder="Search by title, author, or category..." 
                           style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                           onkeyup="searchBooks()">
                    <button class="btn-search" onclick="searchBooks()" 
                            style="padding: 8px 12px;">Search</button>
                </div>

                <!-- Filter Container -->
                <div class="filter-container" style="display: flex; align-items: center; gap: 10px;">
                    <label for="categoryFilter" style="font-weight: bold;">Filter by Category:</label>
                    <select id="categoryFilter" class="category-dropdown" onchange="filterByCategory()" 
                            style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; background: white;">
                        <option value="all">All Books</option>
                        <option value="fiction">Fiction</option>
                        <option value="nonfiction">Non-Fiction</option>
                        <option value="science">Science</option>
                        <option value="history">History</option>
                    </select>
                    <button class="btn-reset" onclick="resetBookFilters()" 
                            style="padding: 8px 12px;">Reset</button>
                </div>

            </div>

            <!-- Books Table -->
            <table id="booksTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Available Copies</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody id="bookTableBody">
                    <?php
                    $display_books = "SELECT * FROM books ORDER BY id DESC";
                    $result_books = mysqli_query($conn, $display_books);
                    if(mysqli_num_rows($result_books) > 0) {
                        while($row = mysqli_fetch_assoc($result_books)) {
                            echo "<tr class='book-row' data-category='" . strtolower($row['category']) . "'>";
                            echo "<td><strong>#" . sprintf("%03d", $row['id']) . "</strong></td>";
                            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['author']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['copies']) . "</td>";
                            echo "<td>";
                            echo "<div class='operation-buttons'>";
                            echo "<button class='btnE btnEdit' onclick='editBook(" . $row['id'] . ", \"" . htmlspecialchars(addslashes($row['title'])) . "\", \"" . htmlspecialchars(addslashes($row['author'])) . "\", \"" . htmlspecialchars(addslashes($row['category'])) . "\", " . $row['copies'] . ")'> Edit</button>";
                            echo "<button class='btnE btnDelete' onclick='deleteBook(" . $row['id'] . ", \"" . htmlspecialchars(addslashes($row['title'])) . "\")'> Delete</button>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' style='text-align: center; padding: 30px; color: #666;'> No books found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Edit Book Modal -->
            <div id="editBookModal" class="modal" style="display: none;">
                <div class="modalContent">
                    <span class="close" onclick="closeEditBookModal()">&times;</span>
                    <h3>Edit Book</h3>
                    <form action="" method="post" id="editBookForm">
                        <input type="hidden" name="edit_book_id" id="edit_book_id">

                        <div class="form-group">
                            <label>Title:</label>
                            <input type="text" name="edit_title" id="edit_title" required>
                        </div>

                        <div class="form-group">
                            <label>Author:</label>
                            <input type="text" name="edit_author" id="edit_author" required>
                        </div>

                        <div class="form-group">
                            <label>Category:</label>
                            <input type="text" name="edit_category" id="edit_category" required>
                        </div>

                        <div class="form-group">
                            <label>Available Copies:</label>
                            <input type="number" name="edit_copies" id="edit_copies" min="1" required>
                        </div>

                        <input type="submit" id="editBookBtn" value="Update Book">
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Book Form -->
        <div class="form-container" id="addBookSection" style="display:none;">
            <button class="logout-btn back-button" type="button" onclick="showManageBooks()">Back</button>
            <form action="" method="post" id="bookForm">
                <h3>Add New Book</h3>
                <div class="form-row">
                    <div>
                        <label>Title:</label>
                        <input type="text" name="title" placeholder="Enter book title" required>
                    </div>
                    <div>
                        <label>Author:</label>
                        <input type="text" name="author" placeholder="Enter author name" required>
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        <label>Category:</label>
                        <input type="text" name="category" placeholder="Enter category" required>
                    </div>
                    <div>
                        <label>Available Copies:</label>
                        <input type="number" name="copies" placeholder="Enter number of copies" required min="1">
                    </div>
                </div>
                <input type="submit" value="Add Book">
            </form>
        </div>            

        </div>

        <!-- Manage Users & Fines Section -->

        <div id="manageUsers" class="content-section">
            <!-- User List -->
        <div id="userSection" style="height: 80vh; overflow-y: auto;">
        <div>
            <!-- <button class="btn" 
            onclick="window.location.href='../../Authentication/addUsers-Admin.php'" 
            style="margin-bottom: 15px;">
                Add New User
            </button> -->
            <button class="btn" 
            onclick="showRegisterForm()" 
            style="margin-bottom: 15px;">
                Add New Student
            </button>
        </div>

        <h2 style="margin-bottom: 10px;">Manage Users</h2>

               <!-- Wrapper -->
<div style="display: flex; justify-content: space-between; align-items: center; margin: 15px 0;">

    <!-- Search Container -->
    <div class="search-container" style="display: flex; align-items: center; gap: 10px;">
        <input type="text" class="search-input" id="searchInput" 
               placeholder="Search by name, email, or role..." 
               style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        <button class="btn-search" onclick="searchTable()" 
                style="padding: 8px 12px;">Search</button>
    </div>

    <!-- Filter Container -->
    <div class="filter-container" style="display: flex; align-items: center; gap: 10px;">
        <label for="roleFilter" style="font-weight: bold;">Filter by Role:</label>
        <select id="roleFilter" class="role-dropdown" onchange="filterByRole()" 
                style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; background: white;">
            <option value="all">All Users</option>
            <option value="student">Student</option>
            <!-- <option value="librarian">Librarian</option>
            <option value="admin">Admin</option> -->
        </select>
        <button class="btn-reset" onclick="resetFilters()" 
                style="padding: 8px 12px;">Reset</button>
    </div>

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

                    if($row['role'] == 'student'){
                    echo "<tr>";
                    echo "<td><strong>#" . sprintf("%03d", $row['id']) . "</strong></td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td><span class='role-badge role-" . $row['role'] . "'>" . ucfirst($row['role']) . "</span></td>";
                    echo "<td>";
                    echo "<div class='operation-buttons'>";
                    if ($row['role'] !== 'admin') {
                        echo "<button class='btnE btnEdit' onclick='editUser(" . $row['id'] . ", \"" . addslashes($row['name']) . "\",
                     \"" . addslashes($row['email']) . "\", \"" . $row['role'] . "\")'> Edit</button>";
                    } else {
                        echo "<button class='btnE btnProtected' title='Admin - Cannot be editable'> Protected</button>";
                    }
                    
                    if ($row['role'] !== 'admin') {
                        echo "<button class='btnE btnDelete' onclick='deleteUser(" . $row['id'] . ", \"" . addslashes($row['name']) . "\")'> Delete</button>";
                    } else {
                        echo "<button class='btnE btnProtected' title='Admin - Cannot be deleted'> Protected</button>";
                    }
                    
                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";
                    }

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
                    <!-- <option value="admin">Admin</option>
                    <option value="librarian">Librarian</option> -->
                    <option value="student">Student</option>
                </select>
                <span id="editRoleError" class="error-message" style="color:red;"></span>
            </div>

            <input type="submit" id="editUserBtn" value=" Update User">
        </form>
    </div>
 </div>
</div>
<!-- Add User Form -->
    <div class="form-container" id="addUserSection" style="display:none;">
        <button class="logout-btn back-button" type="submit" onclick="showManageUsers()">Back</button>
        <form action="" method="post" id="userForm">
            <h3>Add New User</h3>
    <div class="form-row">
        <div>
            <label>Full Name:</label>
            <input type="text" name="name" placeholder="Enter full name" required>
            <span class="error" id="nameError"></span>
        </div>
        <div>
            <label>Email Address:</label>
            <input type="email" name="email" placeholder="Enter email address" required>
            <span class="error" id="emailError"></span>
        </div>
    </div>
    <div class="form-row">
        <div>
            <label>Password:</label>
            <input type="password" name="password" placeholder="Enter password" required minlength="6">
            <span class="error" id="passwordError"></span>
        </div>
        <div>
            <label>User Role:</label>
            <select name="role" required>
                <option value="">Select Role</option>
                <!-- <option value="admin">Admin</option>
                <option value="librarian">Librarian</option> -->
                <option value="student">Student</option>
            </select>
            <span class="error" id="roleError"></span>
        </div>
    </div>
    <input type="submit" value="Add">
</form>
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

    <script src="../../assets/app/dashboard-Script/librarian-Script.js"></script>
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
            if (confirm(' Are you sure you want to delete this user?\n\nName: ' + name + '\n\nIf you click "Ok" then this action cannot be do!')) {
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

// Add user form
document.getElementById('userForm').addEventListener('submit', function(e) {
    let isValid = true;

    // Get values
    const name = document.getElementsByName('name')[0].value.trim();
    const email = document.getElementsByName('email')[0].value.trim();
    const password = document.getElementsByName('password')[0].value;
    const role = document.getElementsByName('role')[0].value;

    // Get error spans
    const nameError = document.getElementById('nameError');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');
    const roleError = document.getElementById('roleError');

    // Clear old errors
    nameError.innerText = '';
    emailError.innerText = '';
    passwordError.innerText = '';
    roleError.innerText = '';

    // Name validation
    if (name === "") {
        nameError.innerText = '*Name cannot be empty.';
        isValid = false;
    } else if (!/^[a-zA-Z\s]{2,}$/.test(name)) {
        nameError.innerText = '*Please enter a valid name (at least 2 letters, only letters & spaces).';
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

    // Password validation
    if (password === "") {
        passwordError.innerText = '*Password cannot be empty.';
        isValid = false;
    } else if (password.length < 6) {
        passwordError.innerText = '*Password must be at least 6 characters long.';
        isValid = false;
    } else if (!/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password) || !/[\W_]/.test(password)) {
        passwordError.innerText = '*Password must contain uppercase, lowercase, digit, and special character.';
        isValid = false;
    }

    // Role validation
    if (role === "") {
        roleError.innerText = '*Please select a role.';
        isValid = false;
    }

    // Stop form submission if invalid
    if (!isValid) {
        e.preventDefault();
    }
});

console.log('Add Users Successfully!');
    </script>
        <!-- Dropdown bar -->
    <script>
// Function to filter table by role
function filterByRole() {
    const selectedRole = document.getElementById('roleFilter').value;
    const tableRows = document.querySelectorAll('#tableBody .user-row');
    
    tableRows.forEach(row => {
        const rowRole = row.getAttribute('data-role');
        
        if (selectedRole === 'all' || rowRole === selectedRole) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update table display message if no rows are visible
    updateTableMessage();
}

// Function to reset all filters
function resetFilters() {
    document.getElementById('roleFilter').value = 'all';
    document.getElementById('searchInput').value = '';
    
    const tableRows = document.querySelectorAll('#tableBody .user-row');
    tableRows.forEach(row => {
        row.style.display = '';
    });
    
    updateTableMessage();
}

// Function to update table message when no results found
function updateTableMessage() {
    const visibleRows = document.querySelectorAll('#tableBody .user-row:not([style*="display: none"])');
    const messageRow = document.querySelector('#tableBody .no-results-message');
    
    if (visibleRows.length === 0) {
        if (!messageRow) {
            const tbody = document.getElementById('tableBody');
            const newRow = document.createElement('tr');
            newRow.className = 'no-results-message';
            newRow.innerHTML = '<td colspan="5" style="text-align: center; padding: 30px; color: #666;">No users found matching the selected criteria</td>';
            tbody.appendChild(newRow);
        }
    } else {
        if (messageRow) {
            messageRow.remove();
        }
    }
}

// Enhanced search function that works with role filter
function searchTable() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const selectedRole = document.getElementById('roleFilter').value;
    const tableRows = document.querySelectorAll('#tableBody .user-row');
    
    tableRows.forEach(row => {
        const name = row.cells[1].textContent.toLowerCase();
        const email = row.cells[2].textContent.toLowerCase();
        const role = row.getAttribute('data-role');
        const roleText = row.cells[3].textContent.toLowerCase();
        
        const matchesSearch = name.includes(searchInput) || 
                            email.includes(searchInput) || 
                            roleText.includes(searchInput);
        
        const matchesRole = selectedRole === 'all' || role === selectedRole;
        
        if (matchesSearch && matchesRole) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    updateTableMessage();
}
</script>  
<!-- manage books -->
 
<!-- <script>
// ===================== SEARCH =====================
function searchBooks() {
    const input = document.getElementById("searchBookInput").value.toLowerCase();
    const rows = document.querySelectorAll("#booksTable tbody tr");
    
    rows.forEach(row => {
        // Skip the "No books found" row
        if (row.cells.length < 6) return;
        
        const title = row.cells[1].innerText.toLowerCase();
        const author = row.cells[2].innerText.toLowerCase();
        const category = row.cells[3].innerText.toLowerCase();
        
        if (title.includes(input) || author.includes(input) || category.includes(input)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

// ===================== FILTER =====================
function filterByCategory() {
    const filterValue = document.getElementById("categoryFilter").value.toLowerCase();
    const rows = document.querySelectorAll("#booksTable tbody tr");
    
    rows.forEach(row => {
        // Skip the "No books found" row
        if (!row.dataset.category) return;
        
        const category = row.dataset.category.toLowerCase();
        if (filterValue === "all" || category === filterValue) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

function resetBookFilters() {
    document.getElementById("searchBookInput").value = "";
    document.getElementById("categoryFilter").value = "all";
    
    // Show all rows
    const rows = document.querySelectorAll("#booksTable tbody tr");
    rows.forEach(row => {
        row.style.display = "";
    });
}

// ===================== ADD / BACK =====================
function showAddBookForm() {
    document.getElementById("bookSection").style.display = "none";
    document.getElementById("addBookSection").style.display = "block";
}

function showManageBooks() {
    document.getElementById("bookSection").style.display = "block";
    document.getElementById("addBookSection").style.display = "none";
}

// ===================== EDIT MODAL =====================
function editBook(id, title, author, category, copies) {
    document.getElementById("edit_book_id").value = id;
    document.getElementById("edit_title").value = title;
    document.getElementById("edit_author").value = author;
    document.getElementById("edit_category").value = category;
    document.getElementById("edit_copies").value = copies;
    document.getElementById("editBookModal").style.display = "block";
}

function closeEditBookModal() {
    document.getElementById("editBookModal").style.display = "none";
}

// ===================== DELETE CONFIRM =====================
function deleteBook(id, title) {
    if (confirm("Are you sure you want to delete the book: " + title + "?")) {
        // Use the same page with GET parameter
        window.location.href = "librarian-Dashboard.php?delete_id=" + id;
    }
}

// ===================== MODAL CLOSE CLICK OUTSIDE =====================
window.onclick = function(event) {
    const modal = document.getElementById("editBookModal");
    if (event.target === modal) {
        closeEditBookModal();
    }
}

// ===================== FORM VALIDATION =====================
document.getElementById("bookForm").addEventListener("submit", function(e) {
    const title = document.querySelector('input[name="title"]').value.trim();
    const author = document.querySelector('input[name="author"]').value.trim();
    const category = document.querySelector('input[name="category"]').value.trim();
    const copies = parseInt(document.querySelector('input[name="copies"]').value);
    
    if (!title || !author || !category || copies < 1) {
        e.preventDefault();
        alert("Please fill all fields with valid data");
    }
});

document.getElementById("editBookForm").addEventListener("submit", function(e) {
    const title = document.getElementById("edit_title").value.trim();
    const author = document.getElementById("edit_author").value.trim();
    const category = document.getElementById("edit_category").value.trim();
    const copies = parseInt(document.getElementById("edit_copies").value);
    
    if (!title || !author || !category || copies < 1) {
        e.preventDefault();
        alert("Please fill all fields with valid data");
    }
});
</script> -->
<script>
// ===================== SEARCH =====================
function searchBooks() {
    const input = document.getElementById("searchBookInput").value.toLowerCase();
    const rows = document.querySelectorAll("#booksTable tbody tr");
    
    rows.forEach(row => {
        if (row.cells.length < 6) return;
        
        const title = row.cells[1].innerText.toLowerCase();
        const author = row.cells[2].innerText.toLowerCase();
        const category = row.cells[3].innerText.toLowerCase();
        
        if (title.includes(input) || author.includes(input) || category.includes(input)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

// ===================== FILTER =====================
function filterByCategory() {
    const filterValue = document.getElementById("categoryFilter").value.toLowerCase();
    const rows = document.querySelectorAll("#booksTable tbody tr");
    
    rows.forEach(row => {
        if (!row.dataset.category) return;
        
        const category = row.dataset.category.toLowerCase();
        if (filterValue === "all" || category === filterValue) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

function resetBookFilters() {
    document.getElementById("searchBookInput").value = "";
    document.getElementById("categoryFilter").value = "all";
    
    const rows = document.querySelectorAll("#booksTable tbody tr");
    rows.forEach(row => {
        row.style.display = "";
    });
}

// ===================== ADD / BACK =====================
function showAddBookForm() {
    document.getElementById("bookSection").style.display = "none";
    document.getElementById("addBookSection").style.display = "block";
}

function showManageBooks() {
    document.getElementById("bookSection").style.display = "block";
    document.getElementById("addBookSection").style.display = "none";
}

// ===================== EDIT MODAL =====================
function editBook(id, title, author, category, copies) {
    document.getElementById("edit_book_id").value = id;
    document.getElementById("edit_title").value = title;
    document.getElementById("edit_author").value = author;
    document.getElementById("edit_category").value = category;
    document.getElementById("edit_copies").value = copies;
    document.getElementById("editBookModal").style.display = "block";
}

function closeEditBookModal() {
    document.getElementById("editBookModal").style.display = "none";
}

// ===================== DELETE CONFIRM =====================
function deleteBook(id, title) {
    if (confirm("Are you sure you want to delete the book: " + title + "?")) {
        window.location.href = "librarian-Dashboard.php?delete_id=" + id;
    }
}

// ===================== MODAL CLOSE CLICK OUTSIDE =====================
window.onclick = function(event) {
    const modal = document.getElementById("editBookModal");
    if (event.target === modal) {
        closeEditBookModal();
    }
}

// ===================== FORM VALIDATION + ALERT =====================

// Add Book form
document.getElementById("bookForm").addEventListener("submit", function(e) {
    const title = document.querySelector('input[name="title"]').value.trim();
    const author = document.querySelector('input[name="author"]').value.trim();
    const category = document.querySelector('input[name="category"]').value.trim();
    const copies = parseInt(document.querySelector('input[name="copies"]').value);
    
    if (!title || !author || !category || copies < 1) {
        e.preventDefault();
        alert("Please fill all fields with valid data");
    } else {
        alert("Book will be added successfully!");
    }
});

// Edit Book form
document.getElementById("editBookForm").addEventListener("submit", function(e) {
    const title = document.getElementById("edit_title").value.trim();
    const author = document.getElementById("edit_author").value.trim();
    const category = document.getElementById("edit_category").value.trim();
    const copies = parseInt(document.getElementById("edit_copies").value);
    
    if (!title || !author || !category || copies < 1) {
        e.preventDefault();
        alert("Please fill all fields with valid data");
    } else {
        alert("Book will be updated successfully!");
    }
});
</script>


</body>
</html>
