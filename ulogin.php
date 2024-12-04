<!DOCTYPE html>
<html>

<head>
    <title>Login to Railbook</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            max-width: 350px;
            width: 100%;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            text-align: center;
        }

        img {
            width: 100%;
            max-width: 350px;
            display: block;
            margin: 0 auto 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #008CBA;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50; /* Green Color */
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            text-align: center;
            color: #333;
            margin-top: 16px;
        }

        button {
            background-color: #008CBA;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
        .logo {
            width: 200px;
            margin: 0 auto; /* Center the logo */
            display: block; /* Ensure it's on its own line */
            margin-bottom: 0px; /* Add some space below the logo */
        }
        
    </style>
</head>

<body>
<form method="post" action="ulogin.php">
        <img src="LOGO.png" class="logo" alt="Railbook Logo">
        <h2>Login to RailConnect</h2>

        <div class="input-with-icon">
            <label for="username"><i class="fas fa-user"></i> Username</label>
            <input type="text" id="username" name="username" required><br>
        </div>

        <div class="input-with-icon">
            <label for="password"><i class="fas fa-lock"></i> Password</label>
            <input type="password" id="password" name="password" required><br>
        </div>

        <input type="submit" value="Login">
        <p>Don't have an account? <button onclick="location.href='uregistration.php'" style="background-color: #4CAF50;"><i class="fas fa-user-plus"></i> Sign up</button></p>
    </form>


    <?php
    $destination = "uregistration.php";
    // PHP code for handling login logic
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $db_host = "127.0.0.1"; // Change to your database host
        $db_username = "vbc"; // Change to your database username
        $db_password = "root"; // Change to your database password
        $db_name = "railway"; // Change to your database name

        // Create a database connection
        $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

        // Check for connection errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $username = $_POST["username"];
        $password = $_POST["password"];

        $sql = "SELECT * FROM reg WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            echo "<script>alert('Login successful!');</script>";
            header("Location:homepage.html");
        } else {
            echo "<script>alert('Invalid username or Password');</script>";
            header("Location: uregistration.php");
            exit();
            //echo '<a href="' . $destination . '">Register</a>';
        }

        $conn->close();
    }
    ?>
</body>

</html>