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
    <link rel="stylesheet" href="librarian-Style.css">
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
            <!-- ... (your existing code for settings section) ... -->
        </div>
    </div>

    <!-- Add Book Modal -->
    <div id="addBookModal" class="modal">
        <!-- ... (your existing code for add book modal) ... -->
    </div>

    <!-- Scripts -->
    <script src="librarian-Script.js"></script>
</body>
</html>
