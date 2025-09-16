<?php
include 'config.php';

// Helper function to redirect safely
function redirect($page = '') {
    // Redirect to the given page relative to current file
    header("Location: " . $page);
    exit;
}

// ==================== ADD BOOK ====================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title'], $_POST['author'], $_POST['category'], $_POST['copies'])) {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $category = trim($_POST['category']);
    $copies = (int) $_POST['copies'];
    
    if (!empty($title) && !empty($author) && !empty($category) && $copies > 0) {
        $stmt = $conn->prepare("INSERT INTO books (title, author, category, copies) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $title, $author, $category, $copies);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Book added successfully!';
            redirect('librarian-Dashboard.php'); // Same folder redirect
        } else {
            $_SESSION['message'] = 'Error adding book: ' . $conn->error;
            redirect('librarian-Dashboard.php');
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = 'Please fill all fields with valid data';
        redirect('librarian-Dashboard.php');
    }
}

// ==================== EDIT BOOK ====================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_book_id'])) {
    $id = (int) $_POST['edit_book_id'];
    $title = trim($_POST['edit_title']);
    $author = trim($_POST['edit_author']);
    $category = trim($_POST['edit_category']);
    $copies = (int) $_POST['edit_copies'];
    
    if (!empty($title) && !empty($author) && !empty($category) && $copies > 0) {
        $stmt = $conn->prepare("UPDATE books SET title=?, author=?, category=?, copies=? WHERE id=?");
        $stmt->bind_param("sssii", $title, $author, $category, $copies, $id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Book updated successfully!';
            redirect('librarian-Dashboard.php');
        } else {
            $_SESSION['message'] = 'Error updating book: ' . $conn->error;
            redirect('librarian-Dashboard.php');
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = 'Please fill all fields with valid data';
        redirect('librarian-Dashboard.php');
    }
}

// ==================== DELETE BOOK ====================
if (isset($_GET['delete_id'])) {
    $id = (int) $_GET['delete_id'];
    
    $check_stmt = $conn->prepare("SELECT id FROM books WHERE id=?");
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("DELETE FROM books WHERE id=?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Book deleted successfully!';
        } else {
            $_SESSION['message'] = 'Error deleting book: ' . $conn->error;
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = 'Book not found!';
    }
    $check_stmt->close();
    
    redirect('librarian-Dashboard.php'); // Always redirect to the same folder
}





<?php
// manageBooks.php
include '..\Authentication\config.php';

// ==================== ADD BOOK ====================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title'], $_POST['author'], $_POST['category'], $_POST['copies'])) {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $category = trim($_POST['category']);
    $copies = (int) $_POST['copies'];
    
    if (!empty($title) && !empty($author) && !empty($category) && $copies > 0) {
        $stmt = $conn->prepare("INSERT INTO books (title, author, category, copies) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $title, $author, $category, $copies);
        
        if ($stmt->execute()) {
            echo "<script>alert('Book added successfully!'); window.location.href='librarian-Dashboard.php';</script>";
        } else {
            echo "<script>alert('Error adding book: " . $conn->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please fill all fields with valid data');</script>";
    }
}

// ==================== EDIT BOOK ====================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_book_id'])) {
    $id = (int) $_POST['edit_book_id'];
    $title = trim($_POST['edit_title']);
    $author = trim($_POST['edit_author']);
    $category = trim($_POST['edit_category']);
    $copies = (int) $_POST['edit_copies'];
    
    if (!empty($title) && !empty($author) && !empty($category) && $copies > 0) {
        $stmt = $conn->prepare("UPDATE books SET title=?, author=?, category=?, copies=? WHERE id=?");
        $stmt->bind_param("sssii", $title, $author, $category, $copies, $id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Book updated successfully!'); window.location.href='librarian-Dashboard.php';</script>";
        } else {
            echo "<script>alert('Error updating book: " . $conn->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please fill all fields with valid data');</script>";
    }
}

// ==================== DELETE BOOK ====================
if (isset($_GET['delete_id'])) {
    $id = (int) $_GET['delete_id'];
    
    // Check if book exists and if it's currently borrowed
    $check_stmt = $conn->prepare("SELECT id FROM books WHERE id=?");
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Optional: Check if book is currently borrowed before deleting
        $borrow_check = $conn->prepare("SELECT id FROM borrowed_books WHERE book_id=? AND return_date IS NULL");
        $borrow_check->bind_param("i", $id);
        $borrow_check->execute();
        $borrow_result = $borrow_check->get_result();
        
        if ($borrow_result->num_rows > 0) {
            echo "<script>alert('Cannot delete book - it is currently borrowed!'); window.location.href='librarian-Dashboard.php';</script>";
        } else {
            $stmt = $conn->prepare("DELETE FROM books WHERE id=?");
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                echo "<script>alert('Book deleted successfully!'); window.location.href='librarian-Dashboard.php';</script>";
            } else {
                echo "<script>alert('Error deleting book: " . $conn->error . "');</script>";
            }
            $stmt->close();
        }
        $borrow_check->close();
    } else {
        echo "<script>alert('Book not found!'); window.location.href='librarian-Dashboard.php';</script>";
    }
    $check_stmt->close();
}
?>

<!-- Books Management Section -->
<div id="books" class="content-section">
    <div id="manageBooks" class="content-section">

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
</div>

<script>
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
</script>