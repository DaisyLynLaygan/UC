<?php
session_start();
include 'db.php';

// Prevent access if not logged in or not a student
if (!isset($_SESSION["userName"]) || $_SESSION["role"] !== "student") {
header("Location: login.php");
exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Dashboard</title>
</head>
<body>
<h2>Welcome, <?php echo $_SESSION["userName"]; ?>!</h2>
<p>You are logged in as a student.</p>

<a href="athlete_form.php">
<button>Fill Out Athlete Application Form</button>
</a>

<br><br>
<a href="logout.php">Logout</a>
</body>
</html>