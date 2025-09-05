<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Student Dashboard - Library System</title>
      <link rel="stylesheet" href="student-Style.css" />
       <style>
         

       </style>
   </head>
      <body>
      <div class="container">
         <!-- Header -->
         <div class="header">
            <div class="logo">
               <h2>📚 Library System</h2>
               <p>Student Dashboard</p>
            </div>
            <div class="user-info">
               <div>
                  <strong>John Smith</strong><br />
                  <small>Student ID: STU001</small>
               </div>
               <button class="logout-btn" onclick="window.location.href='../../Authentication/logout.php'">Logout</button>
            </div>
         </div>

         <!-- Stats -->
         <div class="stats">
            <div class="stat-card">
               <div class="stat-number">1,247</div>
               <div class="stat-label">Total Books</div>
            </div>
            <div class="stat-card">
               <div class="stat-number">3</div>
               <div class="stat-label">My Books</div>
            </div>
            <div class="stat-card">
               <div class="stat-number">1</div>
               <div class="stat-label">Due Soon</div>
            </div>
         </div>

         <!-- Main Content -->
         <div class="main-content">
            <!-- Left: All Books -->
            <div>
               <!-- All Books -->
               <div id="allBooks" class="section">
                  <h3 class="section-title">Search Books</h3>
                  <input
                     type="text"
                     class="search-box"
                     placeholder="Search by title or author..."
                     id="searchInput"
                  />

                  <div class="books-grid" id="booksGrid">
                     <!-- Books will load here -->
                  </div>
               </div>

               <!-- View Profile -->
               <div id="viewProfile" class="view-profile-container hidden">
                  <img
                     class="profile-picture"
                     src="images/profile-picture.png"
                     alt=""
                  />
                  <p class="profile-name">John Smith</p>
                  <p class="profile-email">leomessi@gmail.com</p>

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
               <!-- edit profile block -->
                  <h2>Edit Name and Password</h2>
                  <form id="updateProfileForm">
                     <div class="form-group">
                        <label for="name">Name</label>
                        <input
                           type="text"
                           id="name"
                           placeholder="Enter your name"
                           required
                        />
                     </div>
                     <div class="error" id="nameError"></div>
                     <div class="form-group">
                        <label for="oldPassword">Old Password</label>
                        <input
                           type="password"
                           id="oldPassword"
                           placeholder="Enter your old password"
                           required
                        />
                     </div>
                     <div class="error" id="oldPasswordError"></div>
                     <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input
                           type="password"
                           id="newPassword"
                           placeholder="Enter a new password"
                           required
                        />
                     </div>
                     <div class="error" id="newPasswordError"></div>
                     <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <input
                           type="password"
                           id="confirmPassword"
                           placeholder="Confirm password"
                           required
                        />
                     </div>
                     <div class="error" id="confirmPasswordError"></div>
                     <button type="submit" class="btn">Update</button>
                  </form>

                  <!-- Back Button -->
                  <button
                     id="backToProfileButton"
                     class="logout-btn back-button"
                     onclick="backToProfile()"
                  >
                     Back
                  </button>
               </div>
            
            <!-- change name -->
               <div
                  id="changeName"
                  class="update-profile-container section hidden"
               >
               <!-- edit profile block -->
                  <h2>Change Name</h2>
                  <form id="changeNameForm">
                     <div class="form-group">
                        <label for="newName">New Name</label>
                        <input
                           type="text"
                           id="newName"
                           placeholder="Enter your new full name"
                           required
                        />
                     </div>
                     <div class="error" id="newNameError"></div>
                     <div class="form-group">
                        <label for="password">Password</label>
                        <input
                           type="password"
                           id="password"
                           placeholder="Enter your password"
                           required
                        />
                     </div>
                     <div class="error" id="passwordError"></div>
                     <button type="submit" class="btn">Update</button>
                  </form>

                  <!-- Back Button -->
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
               <!-- reset password block -->
                  <h2>Reset Password</h2>
                  <form id="resetPasswordForm">
                     <div class="form-group">
                        <label for="currentPassword">Current Password</label>
                        <input
                           type="password"
                           id="currentPassword"
                           placeholder="Enter your current password"
                           required
                        />
                     </div>
                     <div class="error" id="currentPasswordError"></div>
                     <div class="form-group">
                        <label for="resetNewPassword">New Password</label>
                        <input
                           type="password"
                           id="resetNewPassword"
                           placeholder="Enter your new password"
                           required
                        />
                     </div>
                     <div class="error" id="newPasswordError"></div>
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

                  <!-- Back Button -->
                  <button
                     id="backToProfileButton3"
                     class="logout-btn back-button"
                     onclick="backToProfile()"
                  >
                     Back
                  </button>
               </div>
            </div>
            
            <!-- Right: My Info -->
            <div class="my-info">
               <!-- Quick Actions -->
               <div class="section">
                  <h3 class="section-title">Quick Actions</h3>
                  <div class="quick-actions">
                     <button
                        id="viewAllBooksButton"
                        class="action-btn"
                        onclick="viewAllBooks()"
                     >
                        All Books
                     </button>
                     <!-- <button class="action-btn" onclick="viewMyBooks()">
                        📚 View My Books
                     </button> -->
                     <button
                        id="viewProfileButton"
                        class="action-btn"
                        onclick="viewProfile()"
                     >
                        My Profile
                     </button>
                  </div>
               </div>

               <!-- My Current Books -->
               <div class="section">
                  <h3 class="section-title">My Current Books</h3>
                  <div class="my-books" id="myBooks">
                     <!-- Current books will load here -->
                  </div>
               </div>

               <!-- Notifications -->
               <div class="section notifications-section">
                  <h3 class="section-title">Notifications</h3>
                  <div class="notifications-container" id="notifications">
                     <!-- Notification will load here -->
                  </div>
               </div>
            </div>
         </div>
      </div>

      <script src="student-Script.js"></script>

   </body>
</html>
