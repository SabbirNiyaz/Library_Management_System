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

        