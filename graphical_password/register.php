<!DOCTYPE html>
<!-- register.php -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .error-message {
            color: red;
            font-size: 12px;
            display: none;
        }
    </style>
</head>
<body>
    <h1>Register</h1>
    <form id="registerForm" method="POST" action="register_handler.php">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        
        <label>Password:</label>
        <input type="password" name="password" id="password" required><br>
        
        <span id="passwordError" class="error-message"></span><br>

        <h3>Select Points on the Images:</h3>
        <div id="image-grid">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <div class="image-container">
                    <img src="images/img<?= $i ?>.jpg" class="clickable-image" data-index="<?= $i ?>">
                    <div class="grid-overlay">
                        <?php for ($j = 0; $j < 16; $j++): ?>
                            <div></div> <!-- Each div represents a grid cell -->
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        
        <input type="hidden" name="selected_points" id="selectedPoints">
        <button type="submit" id="submitBtn">Register</button> <!-- Register button -->
    </form>

    <script>
        const passwordInput = document.getElementById('password');
        const passwordError = document.getElementById('passwordError');
        const submitBtn = document.getElementById('submitBtn');
        let points = {}; // Object to store selected points for each image

        // Password validation function
        function validatePassword(password) {
            const hasLower = /[a-z]/.test(password);
            const hasUpper = /[A-Z]/.test(password);
            const hasSpecial = /[\W_]/.test(password);
            const hasNumber = /[0-9]/.test(password);

            let errorMessages = [];

            if (!hasLower) {
                errorMessages.push("Password must contain at least one lowercase letter.");
            }
            if (!hasUpper) {
                errorMessages.push("Password must contain at least one uppercase letter.");
            }
            if (!hasSpecial) {
                errorMessages.push("Password must contain at least one special character.");
            }
            if (!hasNumber) {
                errorMessages.push("Password must contain at least one number.");
            }

            // Display the errors
            if (errorMessages.length > 0) {
                passwordError.style.display = 'inline';
                passwordError.innerHTML = errorMessages.join('<br>');
                submitBtn.disabled = true; // Disable submit button
            } else {
                passwordError.style.display = 'none'; // Hide error message if valid
                submitBtn.disabled = false; // Enable submit button
            }
        }

        // Event listener for password input
        passwordInput.addEventListener('input', function() {
            validatePassword(passwordInput.value);
        });

        // Initially, disable the submit button until the password is valid
        submitBtn.disabled = true;

        // Event listener for image click
        document.querySelectorAll('.clickable-image').forEach(img => {
            img.addEventListener('click', function(e) {
                const imgIndex = this.dataset.index;
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;  // Correct the offsetX
                const y = e.clientY - rect.top;   // Correct the offsetY

                points[imgIndex] = { x, y };
                document.getElementById('selectedPoints').value = JSON.stringify(points);
            });
        });
    </script>
</body>
</html>
