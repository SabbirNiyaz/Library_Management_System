// Sample book data
const books = [
   {
      id: 1,
      title: 'The Great Gatsby',
      author: 'F. Scott Fitzgerald',
      status: 'available',
   },
   {
      id: 2,
      title: 'To Kill a Mockingbird',
      author: 'Harper Lee',
      status: 'issued',
   },
   { id: 3, title: '1984', author: 'George Orwell', status: 'available' },
   { id: 4, title: 'Clean Code', author: 'Robert Martin', status: 'available' },
   { id: 5, title: 'Clean Code 2', author: 'Robert Martin', status: 'available' },
   { id: 6, title: 'Clean Code 3', author: 'Robert Martin', status: 'available' },
   { id: 7, title: 'Clean Code 4', author: 'Robert Martin', status: 'available' },
   { id: 8, title: 'Clean Code 5', author: 'Robert Martin', status: 'available' },
   { id: 9, title: 'Clean Code 6', author: 'Robert Martin', status: 'available' },
   { id: 10, title: 'Clean Code 7', author: 'Robert Martin', status: 'available' },
   { id: 11, title: 'Clean Code 8', author: 'Robert Martin', status: 'available' },
   { id: 12, title: 'Clean Code 9', author: 'Robert Martin', status: 'available' },
   {
      id: 13,
      title: 'Harry Potter',
      author: 'J.K. Rowling',
      status: 'unavailable',
   },
]

// My issued books
const myBooks = [
   {
      title: 'JavaScript: The Good Parts',
      dueDate: '2025-08-28',
      overdue: false,
   },
   { title: 'Clean Code', dueDate: '2025-08-29', overdue: false },
   { title: 'Design Patterns', dueDate: '2025-08-25', overdue: true },
]

// Load books on page start
document.addEventListener('DOMContentLoaded', function () {
   loadBooks()
   loadMyBooks()
   setupSearch()
})

function loadBooks(bookList = books) {
   const booksGrid = document.getElementById('booksGrid')
   booksGrid.innerHTML = ''

   bookList.forEach((book) => {
      const bookCard = document.createElement('div')
      bookCard.className = 'book-card'

      bookCard.innerHTML = `
         <div class="book-title">${book.title}</div>
         <div class="book-author">by ${book.author}</div>
         <div class="book-status ${
            book.status
         }">${book.status.toUpperCase()}</div>
         <button class="request-btn" 
                 onclick="requestBook(${book.id})" 
                 ${book.status !== 'available' ? 'disabled' : ''}>
            ${book.status === 'available' ? 'Request Book' : 'Not Available'}
         </button>
      `
      booksGrid.appendChild(bookCard)
   })
}

function loadMyBooks() {
   const myBooksContainer = document.getElementById('myBooks')
   myBooksContainer.innerHTML = ''

   myBooks.forEach((book) => {
      const bookDiv = document.createElement('div')
      bookDiv.className = 'my-book'

      bookDiv.innerHTML = `
         <div class="book-name">${book.title}</div>
         <div class="due-date ${book.overdue ? 'overdue' : ''}">
            Due: ${book.dueDate} ${book.overdue ? '(OVERDUE)' : ''}
         </div>
      `
      myBooksContainer.appendChild(bookDiv)
   })
}

function setupSearch() {
   const searchInput = document.getElementById('searchInput')
   searchInput.addEventListener('input', function (e) {
      const searchTerm = e.target.value.toLowerCase()
      const filteredBooks = books.filter(
         (book) =>
            book.title.toLowerCase().includes(searchTerm) ||
            book.author.toLowerCase().includes(searchTerm)
      )
      loadBooks(filteredBooks)
   })
}

function requestBook(bookId) {
   const book = books.find((b) => b.id === bookId)
   if (book && book.status === 'available') {
      book.status = 'requested'
      loadBooks()
      showNotification(`Request sent for "${book.title}"`, 'success')
   }
}

function showNotification(message, type = '') {
   const notifications = document.getElementById('notifications')
   const notification = document.createElement('div')
   notification.className = `notification ${type}`
   notification.textContent = message
   notifications.insertBefore(notification, notifications.firstChild)
}

function viewAllBooks() {
   document.getElementById('viewProfile').classList.add('hidden')
   document.getElementById('allBooks').classList.remove('hidden')
   document.getElementById('editProfile').classList.add('hidden')
   document.getElementById('changeName').classList.add('hidden')
   document.getElementById('resetPassword').classList.add('hidden')
   document.getElementById('viewAllBooksButton').classList.add('toggle-btn')
   document.getElementById('viewProfileButton').classList.remove('toggle-btn')
}

function viewProfile() {
   document.getElementById('allBooks').classList.add('hidden')
   document.getElementById('viewProfile').classList.remove('hidden')
   document.getElementById('editProfile').classList.add('hidden')
   document.getElementById('changeName').classList.add('hidden')
   document.getElementById('resetPassword').classList.add('hidden')
   document.getElementById('viewProfileButton').classList.add('toggle-btn')
   document.getElementById('viewAllBooksButton').classList.remove('toggle-btn')
}

function editProfile() {
   document.getElementById('viewProfile').classList.add('hidden')
   document.getElementById('editProfile').classList.remove('hidden')
}

function changeName() {
   document.getElementById('viewProfile').classList.add('hidden')
   document.getElementById('changeName').classList.remove('hidden')
}

function resetPassword() {
   document.getElementById('viewProfile').classList.add('hidden')
   document.getElementById('resetPassword').classList.remove('hidden')
}

// Back To Profile Button Functionality
function backToProfile() {
   document.getElementById('viewProfile').classList.remove('hidden')
   document.getElementById('editProfile').classList.add('hidden')
   document.getElementById('changeName').classList.add('hidden')
   document.getElementById('resetPassword').classList.add('hidden')
   
   // Clear all error messages
   clearAllErrorMessages()
}

// Function to clear all error messages
function clearAllErrorMessages() {
   // Clear errors from Edit Profile form
   document.getElementById('nameError').innerText = ''
   document.getElementById('oldPasswordError').innerText = ''
   document.getElementById('newPasswordError').innerText = ''
   document.getElementById('confirmPasswordError').innerText = ''
   
   // Clear errors from Change Name form
   document.getElementById('newNameError').innerText = ''
   
   // Clear errors from Reset Password form
   document.getElementById('currentPasswordError').innerText = ''
   document.getElementById('resetConfirmPasswordError').innerText = ''
}

// Update Profile Functionality
document
   .getElementById('updateProfileForm')
   .addEventListener('submit', function (e) {
      e.preventDefault()

      // Clear previous errors
      const nameError = document.getElementById('nameError')
      nameError.innerText = ''
      const oldPasswordError = document.getElementById('oldPasswordError')
      oldPasswordError.innerText = ''
      const newPasswordError = document.getElementById('newPasswordError')
      newPasswordError.innerText = ''
      const confirmPasswordError = document.getElementById('confirmPasswordError')
      confirmPasswordError.innerText = ''

      // Get input values
      let name = document.getElementById('name').value.trim()
      let oldPassword = document.getElementById('oldPassword').value
      let newPassword = document.getElementById('newPassword').value
      let confirmPassword = document.getElementById('confirmPassword').value
      let isValid = true

      // Name validation
      if (name === "") {
         nameError.innerText = '*Name cannot be empty.'
         isValid = false
      } else if (!/^[a-zA-Z\s]{2,}$/.test(name)) {
         nameError.innerText = '*Please enter a valid name (at least 2 letters, letters and spaces only).'
         isValid = false
      }

      // Old Password validation
      if (oldPassword === "") {
         oldPasswordError.innerText = '*Old password cannot be empty.'
         isValid = false
      }

      // New Password validation
      if (newPassword === "") {
         newPasswordError.innerText = '*New password cannot be empty.'
         isValid = false
      } else if (newPassword.length < 6) {
         newPasswordError.innerText = '*Password must be at least 6 characters long.'
         isValid = false
      } else if (!/[A-Z]/.test(newPassword) || !/[a-z]/.test(newPassword) || !/[0-9]/.test(newPassword) || !/[\W_]/.test(newPassword)) {
         newPasswordError.innerText = '*Password must contain uppercase, lowercase, digit, and special character.'
         isValid = false
      }

      // Confirm Password validation
      if (confirmPassword === "") {
         confirmPasswordError.innerText = '*Please confirm your password.'
         isValid = false
      } else if (newPassword !== confirmPassword) {
         confirmPasswordError.innerText = '*Passwords do not match.'
         isValid = false
      }

      // Check if new password is same as old password
      if (oldPassword === newPassword && oldPassword !== "") {
         newPasswordError.innerText = '*New password must be different from old password.'
         isValid = false
      }

      if (isValid) {
         // Update profile name in the view
         document.querySelector('.profile-name').textContent = name

         console.log('Updated Profile:', {
            name,
            oldPassword,
            newPassword,
            confirmPassword,
         })

         // Show success notification
         showNotification('Profile updated successfully!', 'success')

         // Clear form
         this.reset()

         // Go back to profile
         setTimeout(() => {
            backToProfile()
         }, 1500)
      }
   })

// Change Name Form Functionality
document
   .getElementById('changeNameForm')
   .addEventListener('submit', function (e) {
      e.preventDefault()

      // Clear previous errors
      const newNameError = document.getElementById('newNameError')
      newNameError.innerText = ''
      // Note: There's no passwordError element in changeName form, so removing that line

      // Get input values
      let newName = document.getElementById('newName').value.trim()
      let password = document.getElementById('password').value
      let isValid = true

      // Name validation
      if (newName === "") {
         newNameError.innerText = '*Name cannot be empty.'
         isValid = false
      } else if (!/^[a-zA-Z\s]{2,}$/.test(newName)) {
         newNameError.innerText = '*Please enter a valid name (at least 2 letters, letters and spaces only).'
         isValid = false
      }

      // Password validation - Note: No error element exists for password in changeName form

      if (password === "") {
         passwordError.innerText = '*Password cannot be empty.'
         isValid = false
      }

      if (isValid) {
         // Update profile name in the view
         document.querySelector('.profile-name').textContent = newName

         console.log('Changed Name:', {
            newName,
            password,
         })

         // Show success notification
         showNotification(`Name changed to "${newName}" successfully!`, 'success')

         // Clear form
         this.reset()

         // Go back to profile
         setTimeout(() => {
            backToProfile()
         }, 1500)
      }
   })

// Reset Password Form Functionality
document
   .getElementById('resetPasswordForm')
   .addEventListener('submit', function (e) {
      e.preventDefault()

      // Clear previous errors
      document.getElementById('currentPasswordError').innerText = ''
      // Fixed: using correct ID
      document.getElementById('newPasswordError').innerText = ''
      document.getElementById('resetConfirmPasswordError').innerText = ''

      // Get input values
      let currentPassword = document.getElementById('currentPassword').value
      let resetNewPassword = document.getElementById('resetNewPassword').value
      let resetConfirmPassword = document.getElementById('resetConfirmPassword').value
      let isValid = true

      // Current Password validation
      if (currentPassword === "") {
         document.getElementById('currentPasswordError').innerText = '*Current password cannot be empty.'
         isValid = false
      }

      // New Password validation - Fixed: using correct error element ID
      if (resetNewPassword === "") {
         document.getElementById('newPasswordError').innerText = '*New password cannot be empty.'
         isValid = false
      } else if (resetNewPassword.length < 6) {
         document.getElementById('newPasswordError').innerText = '*Password must be at least 6 characters long.'
         isValid = false
      } else if (!/[A-Z]/.test(resetNewPassword) || !/[a-z]/.test(resetNewPassword) || !/[0-9]/.test(resetNewPassword) || !/[\W_]/.test(resetNewPassword)) {
         document.getElementById('newPasswordError').innerText = '*Password must contain uppercase, lowercase, digit, and special character.'
         isValid = false
      }

      // Confirm Password validation
      if (resetConfirmPassword === "") {
         document.getElementById('resetConfirmPasswordError').innerText = '*Please confirm your password.'
         isValid = false
      } else if (resetNewPassword !== resetConfirmPassword) {
         document.getElementById('resetConfirmPasswordError').innerText = '*Passwords do not match.'
         isValid = false
      }

      // Check if new password is same as current password
      if (currentPassword === resetNewPassword && currentPassword !== "") {
         document.getElementById('newPasswordError').innerText = '*New password must be different from current password.'
         isValid = false
      }

      if (isValid) {
         console.log('Password Reset:', {
            currentPassword,
            resetNewPassword,
            resetConfirmPassword,
         })

         // Show success notification
         showNotification('Password reset successfully!', 'success')

         // Clear form
         this.reset()

         // Go back to profile
         setTimeout(() => {
            backToProfile()
         }, 1500)
      }
   })

function logout() {
   if (confirm('Are you sure you want to logout?')) {
      alert('Logged out successfully!')
   }
}