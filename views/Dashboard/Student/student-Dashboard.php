<?php
session_start();
include '../../Authentication/bookViewStudent.php';
if (!isset($_SESSION['email'])) {
    header("Location: ../../Authentication/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Student Dashboard - Library System</title>
      <link rel="stylesheet" href="../../assets/css/dashboard-style/student-Style.css" />
      <style>
         /* Main Content */
.main-content {
   display: grid;
   grid-template-columns: 1fr;
   gap: 18px;

}

.section {
   background: white;
   padding: 20px;
   border-radius: 8px;
   box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
   min-height: 90vh;
   max-height: 100vh;
   /* overflow: auto; */
 
}
.section2 {
   background: white;
   padding: 20px;
   border-radius: 8px;
   box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
   height:auto;
   max-height: 90vh;
   overflow: auto;
 
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
/* Update Profile */
/* .update-profile-container {
   background: #fff;
   padding: 50px;
   border-radius: 12px;
   box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
   width: 100%;
   height: 100%;
} */

/* Container Section */
#allBooks {
    padding: 20px;
    background-color: #f9f9f9;
}

/* Section Title */
#allBooks .section-title {
    font-size: 1.5rem;
    margin-bottom: 15px;
    color: #333;
}

/* Search Form */
#allBooks .search-form {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
    align-items: center;
}

/* Search Input */
#allBooks .search-box {
    flex: 1 1 200px;
    padding: 8px 12px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
}

/* Category Select */
#allBooks .category-filter {
    padding: 8px 12px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
    background-color: #fff;
    cursor: pointer;
}

/* Search Button */
#allBooks .search-btn {
    padding: 8px 16px;
    background-color: #4caf50;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

#allBooks .search-btn:hover {
    background-color: #45a049;
}

/* Books Grid */
#allBooks .books-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 20px;
}

/* Book Card */
#allBooks .book-card {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* Book Details */
#allBooks .book-title {
    font-size: 1.2rem;
    margin-bottom: 5px;
    color: #222;
}

#allBooks .book-author,
#allBooks .book-category,
#allBooks .book-copies,
#allBooks .book-date {
    font-size: 0.9rem;
    margin-bottom: 3px;
    color: #555;
}

/* Request Button */
#allBooks .request-btn {
    margin-top: 10px;
    padding: 7px 12px;
    border: none;
    border-radius: 5px;
    background-color: #2196f3;
    color: white;
    font-size: 0.9rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

#allBooks .request-btn:hover:not([disabled]) {
    background-color: #0b7dda;
}

#allBooks .request-btn[disabled] {
    background-color: #aaa;
    cursor: not-allowed;
}

/* No Books Found */
#allBooks .no-books {
    text-align: center;
    color: #777;
    padding: 40px 0;
}

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
               <div class="student-avatar" 
               onclick="viewProfile()"

            style=" width: 45px;
            height: 45px;
            background: #3D74B6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            cursor: pointer;" 

               >S</div>
               <div>
                  <strong><?= $_SESSION['name']; ?></strong><br/>
                  <small><?= $_SESSION['email']; ?></small>
               </div>
               <button class="logout-btn" onclick="window.location.href='../../Authentication/logout.php'">Logout</button>
            </div>
         </div>

         <!-- Stats -->
         <!-- <div class="stats">
            <div class="stat-card">
               <div class="stat-number">1000</div>
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
         </div> -->

         <!-- Main Content -->
               <!-- All Books -->
               <div id="allBooks" class="section">
                  <!-- Search and Filter Section -->
         <h3 class="section-title">All Books</h3>
    <!-- Search Form -->
    <form method="GET" action="" class="search-form">
        <input type="text" 
               name="search" 
               class="search-box"
               placeholder="Search by title or author..." 
               value="<?php echo htmlspecialchars($search); ?>">

        <button type="submit" class="search-btn">Search</button>

        <select name="category" class="category-filter">
            <option value="">All Categories</option>
            <?php foreach($categories as $cat): ?>
                <option value="<?php echo htmlspecialchars($cat['category']); ?>" 
                        <?php echo ($category == $cat['category']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($cat['category']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
                
            </form>
            <div class="section2">
            <!-- Books Display -->
            <div class="books-grid">
                <?php if (count($books) > 0): ?>
                    <?php foreach($books as $book): ?>
                        <div class="book-card">
                            <h4 class="book-title"><?php echo htmlspecialchars($book['title']); ?></h4>
                            <div class="book-author">by <?php echo htmlspecialchars($book['author']); ?></div>
                            <div class="book-category"><?php echo htmlspecialchars($book['category']); ?></div>
                            <div class="book-copies"><?php echo $book['copies']; ?> copies available</div>
                            <div class="book-date">Added: <?php echo date('M d, Y', strtotime($book['created_at'])); ?></div>
                            
                            <?php if ($book['copies'] > 0): ?>
                                <button class="request-btn" onclick="requestBook(<?php echo $book['id']; ?>)">
                                    Request Book
                                </button>
                            <?php else: ?>
                                <button class="request-btn" disabled>
                                    Out of Stock
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-books">
                        <h3>📚 No books found</h3>
                        <p>Try adjusting your search terms</p>
                    </div>
                <?php endif; ?>
            </div>
            </div>


               </div>

               <!-- View Profile -->
               <div id="viewProfile" class="view-profile-container hidden">
                  <img
                     class="profile-picture"
                     src="../../assets/images/profile-picture.png"
                     alt=""
                  />
                  <p class="profile-name"><?= $_SESSION['name']; ?></p>
                  <p class="profile-email"> Gmail: <strong><?= $_SESSION['email']; ?></strong></p>

         <!-- Edit Profile Buttons -->
                  <button
                     id="editProfileButton"
                     class="action-btn2"
                     onclick="editProfile()"
                  >
                     Edit Profile
                  </button>
                  
                  <button
                     id="changeNameButton"
                     class="action-btn2"
                     onclick="changeName()"
                  >
                     Change Name
                  </button>
                  <button
                     id="resetPasswordButton"
                     class="action-btn2"
                     onclick="resetPassword()"
                  >
                     Reset Password
                  </button>
                  <button
                     class="logout-btn back-button"
                     onclick="viewAllBooks()"
                  >
                     Back
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
            <div class="my-info" style="display:none">
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
               </div> 

                  </div>
               </div>
            </div>
         </div>
      </div>

      <script src="../../assets/app/dashboard-Script/student-Script.js"></script>

      <!-- JS Live Filtering -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.querySelector(".search-box");
    const categorySelect = document.querySelector(".category-filter");
    const bookCards = document.querySelectorAll(".book-card");

    function filterBooks() {
        const searchText = searchInput.value.toLowerCase();
        const selectedCategory = categorySelect.value;

        bookCards.forEach(card => {
            const title = card.querySelector(".book-title").innerText.toLowerCase();
            const author = card.querySelector(".book-author").innerText.toLowerCase();
            const category = card.querySelector(".book-category").innerText;

            const matchesSearch = title.includes(searchText) || author.includes(searchText);
            const matchesCategory = selectedCategory === "" || category === selectedCategory;

            card.style.display = (matchesSearch && matchesCategory) ? "block" : "none";
        });
    }

    searchInput.addEventListener("input", filterBooks);
    categorySelect.addEventListener("change", filterBooks);
});
</script>

      <!-- view books -->
       <script>
        function requestBook(bookId) {
            if (confirm('Are you sure you want to request this book?')) {
                const formData = new FormData();
                formData.append('action', 'request_book');
                formData.append('book_id', bookId);
                formData.append('student_id', <?php echo $student_id; ?>); // Replace with actual session student_id
                
                fetch('', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload(); // Refresh page to update button state
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    alert('Error occurred while requesting book');
                });
            }
        }
    </script>

   </body>
</html>
