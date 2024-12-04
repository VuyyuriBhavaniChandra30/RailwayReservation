<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train Booking</title>
    <style>
        #trainname {
            font-size: 30px;
            font-weight: bold;
            display: inline-block;
            margin-left: 20px;
            margin-top: 15px;
            margin-bottom: 0;
        }

        #working {
            margin-left: 800px;
            display: inline-block;
            margin-bottom: 0;
        }

        #fromto {
            display: flex;
            align-items: center;
            margin-left: 10%;
            font-size:24px;
        }

        #timeduration {
            display: flex;
            font-weight: bold;
            align-items: center;
            margin-left:25%;
            font-size:24px;
        }

        #from,
        #to {
            font-size: 20px;
            font-weight: bold;
            color: orange;
            font-size:24px;
        }

        #fromto hr,
        #timeduration hr {
            width: 40px;
            margin: 0;
        }

        #distance {
            background-color: white;
            align-items: center;
            padding: 1px;
            font-weight: bold;
        }

        #rowdetails {
            display: flex;
        }

        #bookingtrain {
            border: 1px solid black;
            border-radius: 3px;
        }

        #bookingsdata {
            display: flex;
            justify-content: center;
            margin:10px;
        }

        #availability {
            font-weight: bold;
            font-size:24px;
            color: green;
            margin-left: 10px;
            margin-right: 10px;
        }

        #bookingclass {
            margin-left: 10px;
            margin-right: 10px;
        }

        .passenger-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        #passengerdetails{
            border:1px solid black;
            border-radius:3px;
            margin-top:5px;
        }
        #passengerdetails h1{
            margin-left:10px;
        }
        #passengerdetails label{
            font-weight:bold;
            margin-left:35px;
            font-size:20px;
        }
        #passengerdetails input,#passengerdetails select{
            width:15%;
            margin-left:5px;
            height:28px;
            font-size:18px;
            padding:3px;
        }
        #passengerdetails select{
            height:38px;
        }
        #passengerdetails button{
            margin:8px;
            margin-left:15px;
            padding:5px;
            width:10%;
            font-size:16px;
            background-color:orange;
            border-radius:3px;
            font-weight:bold;
            border-color:orange;
            color:white;
        }
        #bookingdate,#bookingclass{
            font-size:24px;
            color:blue;
            margin-left:25px;
        }
        #bookingdate label,#bookingclass label{
            font-weight:bold;
            font-size:24px;
            color:black;
        }
    </style>
</head>

<body>
    <div id="bookingtrain">
        <?php
        $dbHost = "127.0.0.1";
        $dbUser = "vbc";
        $dbPassword = "root";
        $dbName = "railway";
        $conn = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);
        if (!$conn) {
            die("Connection error: " . mysqli_connect_error());
        }

        $trainNo = mysqli_real_escape_string($conn, $_GET["train_no"]);
        $class = mysqli_real_escape_string($conn, $_GET["class"]);
        $date = mysqli_real_escape_string($conn, $_GET["date"]);
        $from = mysqli_real_escape_string($conn, $_GET['from']);
        $to = mysqli_real_escape_string($conn, $_GET['to']);

        $_SESSION["fdate"]=$date;
        $_SESSION["fclasscode"]=$class;

        $sql1 = "SELECT * FROM route WHERE trainno='$trainNo' AND `from`='$from' AND `to`='$to'";
        $result = mysqli_query($conn, $sql1);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        }

        $sql2 = "SELECT * FROM train WHERE trainno='$trainNo'";
        $res = mysqli_query($conn, $sql2);

        if ($res && mysqli_num_rows($res) > 0) {
            while ($r = mysqli_fetch_assoc($res)) {
                echo '<div id="trainname">' . $r["trainno"] . '-' . $r["trainname"] . '</div><hr>';
            }
        }

        echo '<div id="rowdetails">';
        echo '<div id="fromto">';
        echo '<div id="from">[' . $row["from"] . ']' . $row["fromcode"] . '</div><hr>';
        echo '<div id="distance">' . $row["distance"] . 'Kms</div><hr>';
        echo '<div id="to">' . $row["tocode"] . '[' . $row["to"] . ']</div>';
        echo '</div>';
        echo '<div id="timeduration">';
        echo '<div id="from">' . $row["sourcetime"] . '</div><hr>';
        echo '<div id="duration">' . $row["duration"] . 'mins</div><hr>';
        echo '<div id="to">' . $row["desttime"] . '</div>';
        echo '</div></div><br>';
        $sql3 = "select class from class where classcode='$class'";
        $r3 = mysqli_query($conn, $sql3);
        if (mysqli_num_rows($r3) > 0) {
            $row3 = mysqli_fetch_assoc($r3);
            $classname = $row3["class"];
        }
        $sql4 = "select * from stops where trainno='$trainNo' and stopname='$from'";
        $r4 = mysqli_query($conn, $sql4);
        if (mysqli_num_rows($r4) > 0) {
            $row4 = mysqli_fetch_assoc($r4);
            $availability = $row4["$class"];
        }
        echo '<div id="bookingsdata">';
        echo '<div id="bookingdate"><label>DATE:</label>' . $_SESSION["date"] . '</div>';
        echo '<div id="bookingclass"><label>CLASS:</label>' . $classname . '[' . $class . '] </div>';
        echo '<div id="availability">AVAILABLE-' . $availability . '</div>';
        echo '</div>';
        ?>
    </div>

    <div id="passengerdetails">
        <h1>Passenger Details</h1>
        <form action="review.php?trainno=<?php echo $trainNo; ?>&from=<?php echo $from; ?>&to=<?php echo $to; ?>&class=<?php echo $class; ?>" method="post">
            <div id="passengerForm">
                <div class="passenger-row">
                    <label for="name[]">Name:</label>
                    <input type="text" name="name[]" required> 
                    <label for="age[]">Age:</label>
                    <input type="number" name="age[]" required>
                    <label for="gender[]">Gender:</label>
                    <select name="gender[]" required>
                        <option value="MALE">MALE</option>
                        <option value="FEMALE">FEMALE</option>
                        <option value="OTHER">OTHER</option>
                    </select>
                    <label for="type[]">Type:</label>
                    <select name="type[]" required>
                        <option value="GENERAL">GENERAL</option>
                        <option value="LADIES">LADIES</option>
                        <option value="LOWER BERTH/SR.CITIZEN">LOWER BERTH/SR.CITIZEN</option>
                        <option value="PERSON WITH DISABILITY">PERSON WITH DISABILITY</option>
                        <option value="DUTY PASS">DUTY PASS</option>
                        <option value="TATKAL">TATKAL</option>
                        <option value="PREMIUM TATKAL">PREMIUM TATKAL</option>
                    </select>
                </div>
            </div>

            <a href="#" id="addPassengerLink"><button>Add Passenger</button></a>
            <button type="submit" name="calculateFare" id="calculateFareButton">Calculate Fare</button>
        </form>
    </div>
    <script>
        const maxPassengers = 6;
        let passengerCount = 1; // Initial passenger count

        const addPassengerLink = document.getElementById("addPassengerLink");
        const calculateFareButton = document.getElementById("calculateFareButton");
        const passengerForm = document.getElementById("passengerForm");

        addPassengerLink.addEventListener("click", function (e) {
            e.preventDefault();

            if (passengerCount < maxPassengers && passengerCount <= <?php echo $availability; ?>){
                // Clone the last passenger row and add it to the form
                const lastPassengerRow = document.querySelector(".passenger-row");
                const newPassengerRow = lastPassengerRow.cloneNode(true);
                passengerForm.appendChild(newPassengerRow);

                // Clear values in the cloned row
                const inputFields = newPassengerRow.querySelectorAll("input, select");
                inputFields.forEach((input) => (input.value = ""));

                passengerCount++;
            } else {
                alert("You can add up to 6 passengers with in availability");
            }
        });
    </script>
</body>

</html>
