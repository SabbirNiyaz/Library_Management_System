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
            <!-- User List -->
    <div id="userSection" style="height: 80vh; overflow-y: auto;">
        <div>
            <button class="btn" onclick="window.location.href='../../Authentication/addUsers-Librarian.php'" style="margin-bottom: 15px;">
                Add New Student
            </button>
        </div>

        <h2 style="margin-bottom: 10px;">Manage Users</h2>
        <table class="user-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <!-- User rows will be populated here -->
            </tbody>
        </table>
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
</body>
</html>
