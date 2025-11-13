<?php
    include 'db.php';

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"];
        $role = $_POST["role"];

        //password match checker
        if($password != $confirmPassword){
            echo"Password does not match.<br>";
        }
        //password validation
        elseif(!preg_match("/^(?=.[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)){
            echo"Password must be  atleast 8 characters long and include atleast one letter one number and one special character.<br>";
        }else{

            //check if username already exist
            $check = $conn->query("SELECT * FROM Registration WHERE userName = '$username'");
            if($check->num_rows > 0 ){
                echo"Username already exist.<br>";
            }else{
                //INSERT INTO TABLE
                $sql = "INSERT INTO Registration(userName,password,confirmPassword,role)
                VALUES('$username','$password','$confirmPassword','$role')";

                if($conn->query($sql)== TRUE){
                    echo "Registration successful. <a href='login.php'>Login here</a><br>";
                }else{
                    echo"Error: " . $conn->error;
                }

            }
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <h2>Registration Page</h2>
    <form method="POST" action="">
        <label>Username:</label><br>
        <input type = "text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type = "text" name="password" required><br><br>

        <label>ConfirmPassword:</label><br>
        <input type = "text" name="confirmPassword"><br><br>

        <label>Role:</label><br>
        <select name="role" required>
            <option value="">--Select Role--</option>
            <option value="admin">Admin</option>
            <option value="student">Student</option>
            <option value="coach">Coach</option>
            <option value="manager">Manager</option>
            <option value="dean">Dean</option>
        </select><br><br> 

        <input type="submit" value="Register">
    </form>

    <already have an account> <p><a href="login.php">Login here</a></p>

</body>
</html>