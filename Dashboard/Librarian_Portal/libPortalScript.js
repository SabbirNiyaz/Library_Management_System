// Navigation tab switching
        function showSection(sectionId) {
            document.querySelectorAll('.content-section').forEach(function(sec) {
                sec.classList.remove('active');
            });
            document.getElementById(sectionId).classList.add('active');
            document.querySelectorAll('.nav-tab').forEach(function(tab) {
                tab.classList.remove('active');
            });
            document.querySelector('.nav-tab[onclick="showSection(\'' + sectionId + '\')"]').classList.add('active');
        }

        // Modal functions
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Dummy logout function
        function logout() {
            alert('Logging out...');
            // Redirect or perform logout logic here
        }

        // Dummy functions for buttons
        function lookupStudent() {
            document.getElementById('studentInfo').style.display = 'block';
            document.getElementById('studentInfo').innerHTML = '<strong>Student Name:</strong> Jane Smith<br><strong>Class:</strong> 10A';
        }
        function issueBook() {
            alert('Book issued!');
        }
        function returnBook() {
            alert('Book returned!');
        }
        function viewStudentBooks() {
            document.getElementById('returnInfo').style.display = 'block';
            document.getElementById('returnInfo').innerHTML = '<strong>Books Issued:</strong> 2<br><strong>Due Date:</strong> 2024-06-15';
        }
        function importBooks() {
            alert('Import books functionality not implemented.');
        }
        function exportBooks() {
            alert('Export inventory functionality not implemented.');
        }
        function manageUsersReminders() {
            alert('Reminders sent!');
        }
        function collectFine() {
            alert('Fine collected!');
        }
        function generateFineReport() {
            alert('Fine report generated!');
        }
        function generateReport(type) {
            alert('Report generated: ' + type);
        }

        // Add Book Form Submission
        document.getElementById('addBookForm').onsubmit = function(e) {
            e.preventDefault();
            alert('Book added!');
            closeModal('addBookModal');
        };

// // Sample data
//         const books = [
//             { isbn: '978-0-7432-7356-5', title: 'The Great Gatsby', author: 'F. Scott Fitzgerald', genre: 'fiction', status: 'available', location: 'A-101' },
//             { isbn: '978-0-06-112008-4', title: 'To Kill a Mockingbird', author: 'Harper Lee', genre: 'fiction', status: 'issued', location: 'A-102' },
//             { isbn: '978-0-452-28423-4', title: '1984', author: 'George Orwell', genre: 'fiction', status: 'available', location: 'A-103' },
//             { isbn: '978-0-13-235088-4', title: 'Clean Code', author: 'Robert C. Martin', genre: 'technology', status: 'available', location: 'T-201' },
//             { isbn: '978-0-06-231609-7', title: 'Sapiens', author: 'Yuval Noah Harari', genre: 'history', status: 'issued', location: 'H-301' }
//         ];

//         const transactions = [
//             { time: '09:15', type: 'Issue', studentId: 'STU001', studentName: 'John Smith', bookTitle: 'Clean Code', dueDate: '2025-09-11', status: 'Active' },
//             { time: '10:30', type: 'Return', studentId: 'STU002', studentName: 'Jane Doe', bookTitle: 'The Great Gatsby', dueDate: '-', status: 'Returned' },
//             { time: '11:45', type: 'Issue', studentId: 'STU003', studentName: 'Bob Johnson', bookTitle: '1984', dueDate: '2025-09-11', status: 'Active' },
//             { time: '14:20', type: 'Return', studentId: 'STU004', studentName: 'Alice Brown', bookTitle: 'Sapiens', dueDate: '-', status: 'Returned' }
//         ];

//         const overdueBooks = [
//             { studentId: 'STU005', studentName: 'Charlie Davis', bookTitle: 'JavaScript Guide', dueDate: '2025-08-15', daysOverdue: 13, fineAmount: '$13.00', contact: 'charlie@student.edu' },
//             { studentId: 'STU006', studentName: 'Diana Wilson', bookTitle: 'Python Cookbook', dueDate: '2025-08-20', daysOverdue: 8, fineAmount: '$8.00', contact: 'diana@student.edu' },
//             { studentId: 'STU007', studentName: 'Edward Miller', bookTitle: 'Data Structures', dueDate: '2025-08-10', daysOverdue: 18, fineAmount: '$18.00', contact: 'edward@student.edu' }
//         ];

//         // Initialize dashboard
//         document.addEventListener('DOMContentLoaded', function() {
//             loadBooks();
//             loadTransactions();
//             loadOverdueBooks();
//             setupEventListeners();
//         });

//         function showSection(sectionName) {
//             // Hide all sections
//             document.querySelectorAll('.content-section').forEach(section => {
//                 section.classList.remove('active');
//             });
            
//             // Remove active class from all tabs
//             document.querySelectorAll('.nav-tab').forEach(tab => {
//                 tab.classList.remove('active');
//             });
            
//             // Show selected section
//             document.getElementById(sectionName).classList.add('active');
            
//             // Add active class to clicked tab
//             event.target.classList.add('active');
//         }

//         function loadBooks() {
//             const tbody = document.getElementById('booksTable');
//             if (!tbody) return;
            
//             tbody.innerHTML = '';
//             books.forEach(book => {
//                 const row = document.createElement('tr');
//                 row.innerHTML = `
//                     <td>${book.isbn}</td>
//                     <td>${book.title}</td>
//                     <td>${book.author}</td>
//                     <td>${book.genre.charAt(0).toUpperCase() + book.genre.slice(1)}</td>
//                     <td><span class="status-badge status-${book.status}">${book.status.toUpperCase()}</span></td>
//                     <td>${