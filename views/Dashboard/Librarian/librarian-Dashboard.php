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
    <link rel="stylesheet" href="../../assets/css/dashboard-style/librarian-Style.css">
    <!-- <style>
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


    </style> -->
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
</body>
</html>
