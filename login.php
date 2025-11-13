<?php
session_start();
include 'db.php';

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $username = $_POST["userName"];
        $password = $_POST["password"];

        $sql = "SELECT * FROM Registration WHERE userName = '$username' AND password = '$password'";
        $result = $conn->query($sql); 

        if($result->num_rows > 0){
            $user = $result->fetch_assoc();

            $_SESSION["userName"] = $user["userName"];
            $_SESSION["role"] = $user["role"];
            
            //role-based redirection
        switch($user["role"]){
            case "admin":
                header("Location: admin.php");
                break;
            case "student":
                header("Location: student.php");
                break;
            case "coach":
                header("Location: coach.php");
                break;
            case "manager":
                header("Location: manager.php");
                break;
            case "dean":
                header("Location: dean.php");
                break;
            default :
            echo"Invalid role.";
            break;
        }
        exit();

        }else{
            echo "Incorrect username or password.<br>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <h1>Login Page</h1>
    <form method="POST" action="">
        <label>Username:</label><br>
        <input type="text" name="userName" required><br><br>

        <label> Password:</label><br>
        <input type="text" name="password" required><br><br>

        <input type="submit" value ="Login">
    </form>
    
    <p>Don't have an account? <a href="index.php">Register here</a></p>

</body>
</html>