<?php
// verify.php
require 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];
$selected_points = json_decode($_POST['selected_points'], true);

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    $stored_points = json_decode($user['img_points'], true);
    $match = true;

    // Check if selected points match the stored points
    foreach ($stored_points as $imgIndex => $point) {
        $storedX = $point['x'];
        $storedY = $point['y'];

        // Checking the threshold for selecting points within a 10px range
        if (!isset($selected_points[$imgIndex]) || 
            abs($selected_points[$imgIndex]['x'] - $storedX) > 10 || 
            abs($selected_points[$imgIndex]['y'] - $storedY) > 10) {
            $match = false;
            break;
        }
    }

    if ($match) {
        // Redirect to login_success.php
        header("Location: login_success.php?username=" . urlencode($username));
        exit;
    } else {
        echo "<script>alert('Incorrect points selected'); window.location.href='login.php';</script>";
    }
} else {
    echo "<script>alert('Invalid username or password'); window.location.href='login.php';</script>";
}
?>
