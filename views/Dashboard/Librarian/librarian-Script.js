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

        // Edit Profile Modal
       
// // Function to clear all error messages
// function clearAllErrorMessages() {
//    // Clear errors from Edit Profile form
//    document.getElementById('nameError').innerText = ''
//    document.getElementById('oldPasswordError').innerText = ''
//    document.getElementById('newPasswordError').innerText = ''
//    document.getElemen tById('confirmPasswordError').innerText = ''
   
//    // Clear errors from Change Name form
//    document.getElementById('newNameError').innerText = ''
   
//    // Clear errors from Reset Password form
//    document.getElementById('currentPasswordError').innerText = ''
//    document.getElementById('resetConfirmPasswordError').innerText = ''
// }

// // Update Profile Functionality
// document
//    .getElementById('updateProfileForm')
//    .addEventListener('submit', function (e) {
//       e.preventDefault()

//       // Clear previous errors
//       const nameError = document.getElementById('nameError')
//       nameError.innerText = ''
//       const oldPasswordError = document.getElementById('oldPasswordError')
//       oldPasswordError.innerText = ''
//       const newPasswordError = document.getElementById('newPasswordError')
//       newPasswordError.innerText = ''
//       const confirmPasswordError = document.getElementById('confirmPasswordError')
//       confirmPasswordError.innerText = ''

//       // Get input values
//       let name = document.getElementById('name').value.trim()
//       let oldPassword = document.getElementById('oldPassword').value
//       let newPassword = document.getElementById('newPassword').value
//       let confirmPassword = document.getElementById('confirmPassword').value
//       let isValid = true

//       // Name validation
//       if (name === "") {
//          nameError.innerText = '*Name cannot be empty.'
//          isValid = false
//       } else if (!/^[a-zA-Z\s]{2,}$/.test(name)) {
//          nameError.innerText = '*Please enter a valid name (at least 2 letters, letters and spaces only).'
//          isValid = false
//       }

//       // Old Password validation
//       if (oldPassword === "") {
//          oldPasswordError.innerText = '*Old password cannot be empty.'
//          isValid = false
//       }

//       // New Password validation
//       if (newPassword === "") {
//          newPasswordError.innerText = '*New password cannot be empty.'
//          isValid = false
//       } else if (newPassword.length < 6) {
//          newPasswordError.innerText = '*Password must be at least 6 characters long.'
//          isValid = false
//       } else if (!/[A-Z]/.test(newPassword) || !/[a-z]/.test(newPassword) || !/[0-9]/.test(newPassword) || !/[\W_]/.test(newPassword)) {
//          newPasswordError.innerText = '*Password must contain uppercase, lowercase, digit, and special character.'
//          isValid = false
//       }

//       // Confirm Password validation
//       if (confirmPassword === "") {
//          confirmPasswordError.innerText = '*Please confirm your password.'
//          isValid = false
//       } else if (newPassword !== confirmPassword) {
//          confirmPasswordError.innerText = '*Passwords do not match.'
//          isValid = false
//       }

//       // Check if new password is same as old password
//       if (oldPassword === newPassword && oldPassword !== "") {
//          newPasswordError.innerText = '*New password must be different from old password.'
//          isValid = false
//       }

//       if (isValid) {
//          // Update profile name in the view
//          document.querySelector('.profile-name').textContent = name

//          console.log('Updated Profile:', {
//             name,
//             oldPassword,
//             newPassword,
//             confirmPassword,
//          })

//          // Show success notification
//          showNotification('Profile updated successfully!', 'success')

//          // Clear form
//          this.reset()

//          // Go back to profile
//          setTimeout(() => {
//             backToProfile()
//          }, 1500)
//       }
//    })

// // Change Name Form Functionality
// document
//    .getElementById('changeNameForm')
//    .addEventListener('submit', function (e) {
//       e.preventDefault()

//       // Clear previous errors
//       const newNameError = document.getElementById('newNameError')
//       newNameError.innerText = ''
//       // Note: There's no passwordError element in changeName form, so removing that line

//       // Get input values
//       let newName = document.getElementById('newName').value.trim()
//       let password = document.getElementById('password').value
//       let isValid = true

//       // Name validation
//       if (newName === "") {
//          newNameError.innerText = '*Name cannot be empty.'
//          isValid = false
//       } else if (!/^[a-zA-Z\s]{2,}$/.test(newName)) {
//          newNameError.innerText = '*Please enter a valid name (at least 2 letters, letters and spaces only).'
//          isValid = false
//       }

//       // Password validation - Note: No error element exists for password in changeName form

//       if (password === "") {
//          passwordError.innerText = '*Password cannot be empty.'
//          isValid = false
//       }

//       if (isValid) {
//          // Update profile name in the view
//          document.querySelector('.profile-name').textContent = newName

//          console.log('Changed Name:', {
//             newName,
//             password,
//          })

//          // Show success notification
//          showNotification(`Name changed to "${newName}" successfully!`, 'success')

//          // Clear form
//          this.reset()

//          // Go back to profile
//          setTimeout(() => {
//             backToProfile()
//          }, 1500)
//       }
//    })

// // Reset Password Form Functionality
// document
//    .getElementById('resetPasswordForm')
//    .addEventListener('submit', function (e) {
//       e.preventDefault()

//       // Clear previous errors
//       document.getElementById('currentPasswordError').innerText = ''
//       // Fixed: using correct ID
//       document.getElementById('newPasswordError').innerText = ''
//       document.getElementById('resetConfirmPasswordError').innerText = ''

//       // Get input values
//       let currentPassword = document.getElementById('currentPassword').value
//       let resetNewPassword = document.getElementById('resetNewPassword').value
//       let resetConfirmPassword = document.getElementById('resetConfirmPassword').value
//       let isValid = true

//       // Current Password validation
//       if (currentPassword === "") {
//          document.getElementById('currentPasswordError').innerText = '*Current password cannot be empty.'
//          isValid = false
//       }

//       // New Password validation - Fixed: using correct error element ID
//       if (resetNewPassword === "") {
//          document.getElementById('newPasswordError').innerText = '*New password cannot be empty.'
//          isValid = false
//       } else if (resetNewPassword.length < 6) {
//          document.getElementById('newPasswordError').innerText = '*Password must be at least 6 characters long.'
//          isValid = false
//       } else if (!/[A-Z]/.test(resetNewPassword) || !/[a-z]/.test(resetNewPassword) || !/[0-9]/.test(resetNewPassword) || !/[\W_]/.test(resetNewPassword)) {
//          document.getElementById('newPasswordError').innerText = '*Password must contain uppercase, lowercase, digit, and special character.'
//          isValid = false
//       }

//       // Confirm Password validation
//       if (resetConfirmPassword === "") {
//          document.getElementById('resetConfirmPasswordError').innerText = '*Please confirm your password.'
//          isValid = false
//       } else if (resetNewPassword !== resetConfirmPassword) {
//          document.getElementById('resetConfirmPasswordError').innerText = '*Passwords do not match.'
//          isValid = false
//       }

//       // Check if new password is same as current password
//       if (currentPassword === resetNewPassword && currentPassword !== "") {
//          document.getElementById('newPasswordError').innerText = '*New password must be different from current password.'
//          isValid = false
//       }

//       if (isValid) {
//          console.log('Password Reset:', {
//             currentPassword,
//             resetNewPassword,
//             resetConfirmPassword,
//          })

//          // Show success notification
//          showNotification('Password reset successfully!', 'success')

//          // Clear form
//          this.reset()

//          // Go back to profile
//          setTimeout(() => {
//             backToProfile()
//          }, 1500)
//       }
//    })

// function logout() {
//    if (confirm('Are you sure you want to logout?')) {
//       alert('Logged out successfully!')
//    }
// }



        // // Dummy functions for buttons
        // function lookupStudent() {
        //     document.getElementById('studentInfo').style.display = 'block';
        //     document.getElementById('studentInfo').innerHTML = '<strong>Student Name:</strong> Jane Smith<br><strong>Class:</strong> 10A';
        // }
        // function issueBook() {
        //     alert('Book issued!');
        // }
        // function returnBook() {
        //     alert('Book returned!');
        // }
        // function viewStudentBooks() {
        //     document.getElementById('returnInfo').style.display = 'block';
        //     document.getElementById('returnInfo').innerHTML = '<strong>Books Issued:</strong> 2<br><strong>Due Date:</strong> 2024-06-15';
        // }
        // function importBooks() {
        //     alert('Import books functionality not implemented.');
        // }
        // function exportBooks() {
        //     alert('Export inventory functionality not implemented.');
        // }
        // function manageUsersReminders() {
        //     alert('Reminders sent!');
        // }
        // function collectFine() {
        //     alert('Fine collected!');
        // }
        // function generateFineReport() {
        //     alert('Fine report generated!');
        // }
        // function generateReport(type) {
        //     alert('Report generated: ' + type);
        // }

        // // Add Book Form Submission
        // document.getElementById('addBookForm').onsubmit = function(e) {
        //     e.preventDefault();
        //     alert('Book added!');
        //     closeModal('addBookModal');
        // };

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
