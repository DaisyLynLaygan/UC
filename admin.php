<?php
session_start();
include 'db.php';

// Only allow admin access
if(!isset($_SESSION["role"]) || $_SESSION["role"] != "admin"){
header("location: login.php");
exit();
}

// Handle Add/Edit/Delete/Search
$message = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
// Add department
if(isset($_POST['add'])){
$deptID = $_POST["deptID"];
$deptName = $_POST["deptName"];
$check = $conn->query("SELECT * FROM department WHERE deptID = '$deptID'");
if($check->num_rows > 0){
$message = "Department ID already exists.";
} else {
$sql_insert = "INSERT INTO department (deptID, deptName) VALUES ('$deptID', '$deptName')";
$message = $conn->query($sql_insert) === TRUE ? "Department added successfully." : "Error: " . $conn->error;
}
}

// Edit department
if(isset($_POST['edit'])){
$deptID = $_POST["deptID"];
$deptName = $_POST["deptName"];
$sql_update = "UPDATE department SET deptName='$deptName' WHERE deptID='$deptID'";
$message = $conn->query($sql_update) === TRUE ? "Department updated successfully." : "Error: " . $conn->error;
}

// Delete department
if(isset($_POST['delete'])){
$deptID = $_POST["deptID"];
$sql_delete = "DELETE FROM department WHERE deptID='$deptID'";
$message = $conn->query($sql_delete) === TRUE ? "Department deleted successfully." : "Error: " . $conn->error;
}
}

// Handle search
$searchQuery = "";
if(isset($_GET['search'])){
$searchTerm = $_GET['search'];
$searchQuery = "WHERE deptID LIKE '%$searchTerm%' OR deptName LIKE '%$searchTerm%'";
}

$result = $conn->query("SELECT * FROM department $searchQuery ORDER BY deptID");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
</head>
<body>
<h2>Admin Dashboard</h2>
<p>Welcome, <?php echo $_SESSION["userName"]; ?>! (<a href="logout.php">Logout</a>)</p>

<?php if($message) echo "<p style='color:green;'>$message</p>"; ?>

<h3>Add / Edit / Delete Department</h3>
<form method="POST" action="">
<label>Department ID:</label><br>
<input type="number" name="deptID" required><br><br>

<label>Department Name:</label><br>
<input type="text" name="deptName" required><br><br>

<input type="submit" name="add" value="Add Department">
<input type="submit" name="edit" value="Edit Department">
<input type="submit" name="delete" value="Delete Department">
</form>

<h3>Search Departments</h3>
<form method="GET" action="">
<input type="text" name="search" placeholder="Search by ID or Name">
<input type="submit" value="Search">
</form>

<h3>Existing Departments</h3>
<table border="1" cellpadding="5">
<tr>
<th>Department ID</th>
<th>Department Name</th>
</tr>
<?php
if($result->num_rows > 0){
while($row = $result->fetch_assoc()){
echo "<tr>
<td>".$row['deptID']."</td>
<td>".$row['deptName']."</td>
</tr>";
}
} else {
echo "<tr><td colspan='2'>No departments found.</td></tr>";
}
?>
</table>
</body>
</html>