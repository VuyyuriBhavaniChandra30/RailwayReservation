<?php
    session_start();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Form</title>
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    
    <style>
        /* Your existing styles remain unchanged */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            font-size: 20px;
        }

        body {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgb(244, 251, 251);
        }

        .container {
            width: 750px;
            height: 500px;
            border: 1px solid;
            background-color: white;
            display: flex;
            flex-direction: column;
            padding: 40px;
            justify-content: space-around;
        }

        .container h1 {
            text-align: center;
        }
        .container h3{
            text-align:left;
        }
        .first-row {
            display: flex;
        }

        .cvv {
            width: 45%;
        }

        .owner,
        .card-number
        
         {
            width: 100%;
            margin-right: 40px;
            position: relative; /* Add position relative to the parent */
        }
        

        .input-field {
            position: relative; /* Add position relative to the parent */
            border: 1px solid #999;
            display: flex;
            align-items: center;
        }

        .input-field i {
            position: absolute;
            left: 10px;
        }

        .input-field input {
            width: calc(100% - 30px);
            border: none;
            outline: none;
            padding: 10px;
            height: 45px;
            padding-left: 40px; /* Adjusted padding to start writing after the logo */
        }

        .selection {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height:60%;
        }

        .selection select {
            padding: 10px 20px;
        }

        .cards {
            display: flex;
            align-items: center;
        }

        .cards img {
            width: 120px;
            margin-right: 10px; /* Adjusted margin to separate the logo and text */
            height:80px;
            border:2px solid black;
            padding:4px;

           
        }
        
        a {
            background-color: blueviolet;
            color: white;
            text-align: center;
            text-transform: uppercase;
            text-decoration: none;
            padding: 10px;
            font-size: 18px;
            transition: 0.5s;
        }

        a:hover {
            background-color: dodgerblue;
        }

        .error-message {
            color: red;
            margin-top: 5px;
        }
        #expiry-date{
            padding-left: 20px;
            width:140px;
            height:45px;
        }

        /* Styles for the modal */
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            width: 600px;
            height: 200px;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 2px solid blueviolet;
            z-index: 1000;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            width: 500px;
            height: 4oopx;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 2px solid #6c5ce7;
            z-index: 1000;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            text-align: center;
            border-radius: 10px;
        }

        .modal h2 {
            color: #27ae60;
            font-size: 30px;
        }

        .modal p {
            color: #333;
        }

        .modal button {
            background-color: #6c5ce7;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }

        .modal button:hover {
            background-color: #4834d4;
        }

        /* Styles to overlay the background when the modal is active */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        .b {
            width: 100px;
            height: 50px;
            background-color: #6c5ce7;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }

        .b:hover {
            background-color: #4834d4;
        }
        .h{
            font-size:30px;
        }
        
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        #transaction {
            border: 2px solid #333;
            border-radius: 10px;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 3px 3px 5px #888888;
            max-width: 400px;
            margin: 0 auto;
        }

        #transaction h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        #booking-id, #amount-payable {
            font-size: 18px;
            margin: 20px 0;
        }

        #booking-id::before {
            content: "Booking ID: ";
            font-weight: bold;
        }

        #amount-payable::before {
            content: "Amount Payable: Rs. ";
            font-weight: bold;
        }

    </style>
</head>
<body>
    <div id="transactionpage">
    <div id="transaction">
            <?php
        $dbHost = "127.0.0.1";
        $dbUser = "vbc";
        $dbPassword = "root";
        $dbName = "railway";
        $conn = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);
        $totalfare = mysqli_real_escape_string($conn, $_GET["fare"]);
        if (!$conn) {
            die("Connection error: " . mysqli_connect_error());
        }
        $insertBookingSQL = "INSERT INTO bookings (booking_date, total_fare) VALUES (NOW(), ?)";
$stmt = mysqli_prepare($conn, $insertBookingSQL);

if ($stmt) {
    // Bind the parameter and execute the statement
    mysqli_stmt_bind_param($stmt, "d", $totalfare);  // "d" is for a double, adjust the type as needed
    if (mysqli_stmt_execute($stmt)) {
        $bookingID = mysqli_insert_id($conn);
    } else {
        echo "Error executing prepared statement: " . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Error preparing statement: " . mysqli_error($conn);
}
        $_SESSION["fbookingid"]=$bookingID;
        $_SESSION["ffare"]=$totalfare;
        mysqli_close($conn);
        ?>
        <h2>TRANSACTION DETAILS</h2>
        <div id="booking-id"><?php echo $bookingID; ?></div>
        <div id="amount-payable"><?php echo $totalfare; ?></div>
    </div><br>
    <div class="container">
        <h1 class="h">Confirm Your Payment</h1>
        <div class="first-row">
            <div class="owner">
                <h3>Account Holder Name</h3>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" id="account-holder-name" placeholder="Enter Account Holder Name">
                </div>
            </div>
            <div class="cvv">
                <h3>CVV</h3>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="text" name="q" id="cvv" class="input" placeholder="000" maxlength="3">
                    <span class="error-message" id="cvv-error"></span>
                </div>
            </div>
        </div>
        <div class="second-row">
            <div class="card-number">
                <h3>Card Number</h3>
                <div class="input-field">
                    <input type="text" name="p" id="card-number" class="input" placeholder="0000-0000-0000" maxlength="14">
                    <i class="far fa-credit-card"></i>
                </div>
                <!-- Separate the error message from the input field -->
                <span class="error-message" id="card-number-error"></span>
            </div>
        </div>

        <div class="amount">
    <h3>Amount</h3>
    <div class="input-field">
        <i class="fas fa-rupee-sign"></i>
        <input type="text" id="total-fare" value="<?php echo $totalfare; ?>" disabled>
    </div>
</div>

        <div class="third-row">
            <h3>Expiry Date</h3>
            <div class="selection">
                <div class="date">
                    
                    <input type="text" name="expiry-data" id="expiry-date" class="input" placeholder="MM / YY" maxlength="5">
                    <i class="far fa-calender"></i>
                </div>
                
              
                <div class="cards">
                    <img class="a1" src="data:image/png;base64,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" alt="">
                 <img class="a2" src="data:image/png;base64,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">
                  <img  class="a3" src="data:image/png;base64,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" alt="">
                    
    
                  
                    
                </div>
            </div>    
        </div>
        <a href="#" onclick="validateForm()">Confirm</a>
    </div>

    <!-- Modal and overlay HTML -->
    <div class="overlay" id="overlay"></div>
    <div class="modal" id="modal">
        <h2>Payment Successful!</h2>
        <button class="b" onclick="closeModal()">Close</button>
    </div>
    
    <script>
        $("input[name='expiry-data']").mask("00 / 00");
        $("input[name='p']").mask("0000-0000-0000");
        $("input[name='q']").mask("000");
    
        function validateForm() {
            var cvv = document.getElementById('cvv').value;
            var cardNumber = document.getElementById('card-number').value.replace(/-/g, ''); // Remove hyphens
    
            var cvvError = document.getElementById('cvv-error');
            var cardNumberError = document.getElementById('card-number-error');
    
            // Clear previous error messages
            cvvError.innerText = '';
            cardNumberError.innerText = '';
    
            if (!/^\d{3}$/.test(cvv)) {
                cvvError.innerText = 'CVV must be a 3-digit number';
                return;
            }
    
            if (!/^\d{12}$/.test(cardNumber)) {
                cardNumberError.innerText = 'Card Number must be a 12-digit number';
                return;
            }
            displayModal();
        }
        function displayModal() {
            // Display the overlay and modal
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('modal').style.display = 'block';
        }

        function closeModal() {
            // Hide the overlay and modal
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('modal').style.display = 'none';
            window.location.href = 'ticket.php';a
        }
        setTimeout(function() {
        <?php
        if (!isset($_SESSION['payment_successful']) || !$_SESSION['payment_successful']) {
            echo 'alert("Session expired. Please try again.");';
        }
        ?>
        window.location.href = 'in.html';
    }, 50000);
    </script>
    <?php
$_SESSION['timeout'] = time() + 50;
?>
</div>
    
</body>
</html>