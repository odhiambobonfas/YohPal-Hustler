          // Function to show popup
          function showPopup() {
            document.getElementById('successPopup').style.display = 'flex';
        }

        // Function to close popup
        function closePopup() {
            document.getElementById('successPopup').style.display = 'none';
        }

        // Close popup when clicking outside of it
        document.getElementById('successPopup').addEventListener('click', function (e) {
            if (e.target === this) {
                closePopup();
            }
        });

        // Handle form submission
        document.getElementById('forgotPasswordForm').addEventListener('submit', function (e) {
            const email = document.getElementById('emailInput').value;
            if (email) {
                this.submit(); // Allow form submission
            }
        });