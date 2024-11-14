<?php
// register_handler.php
require 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];
$selected_points = $_POST['selected_points'];

// Password validation: must contain at least one lowercase, one uppercase, and one special character
if (!preg_match('/[a-z]/', $password) || !preg_match('/[A-Z]/', $password) || !preg_match('/[\W_]/', $password)) {
    echo "<script>
            alert('Password must contain at least one lowercase letter, one uppercase letter, and one special character.');
            window.location.href='register.php';  // Redirect back to the registration page
          </script>";
    exit;
}

$password = password_hash($password, PASSWORD_BCRYPT);

try {
    $stmt = $conn->prepare("INSERT INTO users (username, password, img_points) VALUES (?, ?, ?)");
    $stmt->execute([$username, $password, $selected_points]);

    // Success message with a styled button
    echo "
    <div style='
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        text-align: center;
    '>
        <h1 style='color: #4CAF50;'>Registration Successful!</h1>
        <p style='color: #333;'>Your account has been created. Click the button below to go to the login page.</p>
        <button onclick='location.href=\"login.php\"' style='
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        '>
            Go to Login
        </button>
    </div>
    ";
} catch (Exception $e) {
    echo "<div style='color: red; text-align: center;'>Error: " . $e->getMessage() . "</div>";
}
?>
