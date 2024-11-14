<!-- login_success.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Successful</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        // This script automatically redirects the user to homepage.php after 2 seconds
        setTimeout(function() {
            window.location.href = "homepage.php";
        }, 3000); // 3000 milliseconds = 3 seconds
    </script>
</head>
<body>
    <div class="success-container">
        <h1>🎉 Login Successful!</h1>
        <?php $username = htmlspecialchars($_GET['username']); ?>
        <p>Welcome back, <strong><?= $username ?></strong>! You have successfully logged in.</p>
        <p>Redirecting you to the homepage...</p>
    </div>
</body>
</html>
