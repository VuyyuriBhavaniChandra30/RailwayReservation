<!DOCTYPE html>
<html ng-app="validationApp">

<head>
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh; /* Set a minimum height to cover the viewport */
    margin: 0;
    font-family: 'Roboto', sans-serif;
    background-color: #f0f0f0; /* Light Gray Background */
}


        form {
            max-width: 450px;
            width: 80%;
            padding-top: 10px;
            padding-left: 40px;
            padding-right: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            height: 70%;
        }

        h2 {
            text-align: center;
            color: #333; /* Dark Gray Text */
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon input {
            padding-left: 30px; /* Space for the icon */
        }

        .input-with-icon i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #001f3f; /* Navy Blue Color */
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #001f3f; /* Navy Blue Color */
            border-radius: 5px;
            background-color: #f0f8ff; /* Light Blue Background */
            font-size: 14px;
        }

        .gender-label {
            margin-bottom: 16px;
            display:flex;
            align-items: center;
        }

        .gender-label input {
            margin-right: 5px;
        }

        .error-message {
            color: red;
            margin-top: 4px;
            font-size: 12px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            width: 100%; /* Set button width to 100% */
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
        }

        .signin-button {
            background-color: #4CAF50;
            color: white;
            padding: 8px; /* Set smaller padding for smaller button */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 90px;
            height: 40px;
            font-size: 14px; /* Set smaller font size */
            text-align: center;
        }

        .signin-button:hover {
            background-color: #45a049;
        }

        button:hover {
            background-color: #45a049;
        }

        p {
            text-align: center;
            margin-top: 16px;
            color: #666;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        .logo {
            width: 230px;
            margin-left: 90px;
        
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body ng-controller="ValidationController">
    
        <!-- ... (head section remains unchanged) -->

<body ng-controller="ValidationController">
    <form name="validationForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <img src="LOGO.png" class="logo" alt="Railbook Logo">
        <h2>Registration Form</h2>

        <div class="input-with-icon">
            <i class="fas fa-user" style="margin-top:5px;"></i>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" ng-model="user.username" ng-maxlength="20" required ng-pattern="/^[A-Z][a-zA-Z0-9]*$/" ng-class="{ 'error-border': validationForm.username.$touched && validationForm.username.$invalid }">
            <div class="error-message" ng-show="validationForm.username.$touched && validationForm.username.$error.required">Username is required.</div>
            <div class="error-message" ng-show="validationForm.username.$touched && validationForm.username.$error.maxlength">Username should be at most 20 characters long.</div>
            <div class="error-message" ng-show="validationForm.username.$touched && validationForm.username.$error.pattern">Username should start with an uppercase letter.</div>
        </div>

        <div class="input-with-icon">
            <i class="fas fa-envelope" style="margin-top:5px;"></i>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" ng-model="user.email" required ng-pattern="/@gmail\.com$/" ng-class="{ 'error-border': validationForm.email.$touched && validationForm.email.$invalid }">
            <div class="error-message" ng-show="validationForm.email.$touched && validationForm.email.$error.required">Email is required.</div>
            <div class="error-message" ng-show="validationForm.email.$touched && validationForm.email.$error.pattern">Invalid email format</div>
        </div>

        <div class="input-with-icon">
            <i class="fas fa-phone" style="margin-top:5px;"></i>
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" ng-model="user.phone" required ng-pattern="/^\d{10}$/" ng-class="{ 'error-border': validationForm.phone.$touched && validationForm.phone.$invalid }">
            <div class="error-message" ng-show="validationForm.phone.$touched && validationForm.phone.$error.required">Phone number is required.</div>
            <div class="error-message" ng-show="validationForm.phone.$touched && validationForm.phone.$error.pattern">Invalid phone 
            number format. (Should be a 10-digit number)</div>
        </div>

        <div class="input-with-icon">
            <i class="fas fa-address-card" style="margin-top:5px;"></i>
            <label for="address">Address</label>
            <input type="text" id="address" name="address" ng-model="user.address" required ng-class="{ 'error-border': validationForm.address.$touched && validationForm.address.$invalid }">
            <div class="error-message" ng-show="validationForm.address.$touched && validationForm.address.$error.required">Address is required.</div>
        </div>

        <div class="gender-label">
            <label>Gender</label><br>
            <input type="radio" id="male" name="male"  ng-model="user.gender" value="male" required>
            <label for="male">Male</label>
            <input type="radio" id="female" name="female"  ng-model="user.gender" value="female" required><br>
            <label for="female">Female</label>
            <input type="radio" id="other" name="other"  ng-model="user.gender" value="other" required>
            <label for="other">Other</label>
        </div>

        <div class="error-message" ng-show="validationForm.gender.$touched && validationForm.gender.$error.required">Gender is required.</div>

        <div class="input-with-icon">
            <i class="fas fa-lock" style="margin-top:5px;"></i>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" ng-model="user.password" ng-minlength="6" ng-maxlength="20" required ng-class="{ 'error-border': validationForm.password.$touched && validationForm.password.$invalid }">
           
            <div class="error-message" ng-show="validationForm.password.$touched && validationForm.password.$error.required">Password is required.</div>
           
            <div class="error-message" ng-show="validationForm.password.$touched && (validationForm.password.$error.minlength || validationForm.password.$error.maxlength)">Password should be between 6 and 20 characters long.</div>
            <div class="error-message" ng-show="validationForm.password.$touched && validationForm.password.$error.pattern">Password should contain at least one uppercase letter, one special character, and one number.</div>
        </div>

        <button ng-disabled="validationForm.$invalid" ng-click="submit()">Register</button>
        <p class="b">Already a user? <button class="signin-button" onclick="location.href='ulogin.php'">Sign In</button></p>

    </form>
    <script>
        angular.module('validationApp', [])
            .controller('ValidationController', function ($scope, $http) {
                $scope.user = {
                    username: '',
                    email: '',
                    phone: '',
                    address: '',
                    gender: 'male',
                    password: ''
                };

                // Custom validation functions
                $scope.isPhoneNumberValid = function () {
                    // Check if phone number is a 10-digit number
                    return /^\d{10}$/.test($scope.user.phone);
                };

                $scope.isEmailValid = function () {
                    // Check if email ends with @gmail.com
                    return /@gmail\.com$/.test($scope.user.email);
                };

                $scope.isPasswordValid = function () {
                    // Check if password is 6-20 characters and contains one special character, one digit, and lowercase letters only
                    return /^(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,20}$/.test($scope.user.password);
                };

                $scope.submit = function () {
                    if ($scope.validationForm.$valid && $scope.isPhoneNumberValid() && $scope.isEmailValid() && $scope.isPasswordValid()) {
                        // Make an HTTP request to insert data into the database
                        $http.post('<?php echo $_SERVER['PHP_SELF']; ?>', {
                            username: $scope.user.username,
                            email: $scope.user.email,
                            phone: $scope.user.phone,
                            address: $scope.user.address,
                            gender: $scope.user.gender,
                            password: $scope.user.password
                        }).then(function (response) {
                            if (response.data.trim() === 'success') {
                                // Data inserted successfully
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Registration successful',
                                    text: 'You can now log in.',
                                    confirmButtonColor: '#4CAF50',
                                    confirmButtonText: 'OK'
                                }).then(function () {
                                    window.location.href = 'ulogin.php';
                                });
                            } else {
                                // Error inserting data
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Registration failed. Please try again later.',
                                    confirmButtonColor: '#4CAF50',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                };
            });
    </script>

    <?php
    // ... (your existing code)

    // PHP code for handling registration logic
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
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        $gender = $_POST["gender"];
        $password = $_POST["password"];

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO reg (username, email, phone, address, gender, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $username, $email, $phone, $address, $gender, $password);

        // Execute the statement
        if ($stmt->execute()) {
            // Data inserted successfully
            echo "<script>alert('Registration successful!');</script>";
        } else {
            // Error inserting data
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
        // Close the database connection
        $conn->close();
    }
    ?>

</body>

</html>