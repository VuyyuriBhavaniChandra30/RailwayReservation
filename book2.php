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
        }

        #timeduration {
            display: flex;
            font-weight: bold;
            align-items: center;
            margin-left: 30%;
        }

        #from,
        #to {
            font-size: 20px;
            font-weight: bold;
            color: orange;
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
            margin: 10px;
            padding-left: 5%;
            justify-content: center;
        }

        #availability {
            font-weight: bold;
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

        /* Add more CSS styles as needed */
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
        $from = mysqli_real_escape_string($conn, $_GET['from']);
        $to = mysqli_real_escape_string($conn, $_GET['to']);

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
        echo '<div id="bookingdate">DATE:' . $_SESSION["date"] . '</div>';
        echo '<div id="bookingclass">CLASS:' . $classname . '[' . $class . '] </div>';
        echo '<div id="availability">AVAILABLE-' . $availability . '</div>';
        echo '<div id="bookingtype">TYPE:' . $_SESSION["type"] . '</div>';
        echo '</div>';
        ?>
    </div>

    <div id="passengerdetails">
        <h1>Passenger Details</h1>
        <form method="post" onsubmit="return false;">
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

            <a href="#" id="addPassengerLink">Add Passenger</a>
            <button type="submit" name="calculateFare" id="calculateFareButton">Calculate Fare</button>
        </form>
    </div>

    <div id="fare-details">
        <h2>Fare Details</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["calculateFare"])) {
            $passengers = [];
            $totalFare = 0;
            $discountfare = 0;

            for ($i = 0; $i < count($_POST['name']); $i++) {
                if (isset($_POST["name"][$i]) && isset($_POST["age"][$i]) && isset($_POST["gender"][$i]) && isset($_POST["type"][$i])) {
                    $passengerName = $_POST["name"][$i];
                    $passengerAge = intval($_POST["age"][$i]);
                    $passengerType = $_POST["type"][$i];
                    $discount = 0;
                    $personfare = 0;

                    // Query the discount for the passenger type
                    $sql5 = "SELECT discount FROM discounts WHERE type='$passengerType'";
                    $r5 = mysqli_query($conn, $sql5);

                    if (mysqli_num_rows($r5) > 0) {
                        $row5 = mysqli_fetch_assoc($r5);
                        $discount = $row5['discount'];
                    }

                    if ($passengerType === "LADIES" && $_POST["gender"][$i] !== "FEMALE") {
                        $discount = 0;
                        echo '<script>alert("LADIES DISCOUNT WILL BE APPLIED ONLY FOR FEMALES")</script>';
                    } elseif ($passengerType === "LOWER BERTH/SR.CITIZEN" && $passengerAge <= 60) {
                        $discount = 0;
                        echo '<script>alert("Sr.CITIZEN DISCOUNT WILL BE APPLIED ONLY FOR AGE ABOVE 60")</script>';
                    }

                    // Query the fare for the class
                    $sql6 = "SELECT fare FROM class WHERE classcode='$class'";
                    $r6 = mysqli_query($conn, $sql6);

                    if (mysqli_num_rows($r6) > 0) {
                        $row6 = mysqli_fetch_assoc($r6);
                        $fare = $row6['fare'];
                    }

                    $personfare = $fare * $row["distance"];
                    $totalFare += $personfare;

                    // Calculate the passenger's discount and fare
                    $passengerFare = $personfare * $discount / 100;
                    $discountfare += $passengerFare;

                    $passengers[] = [
                        "name" => $passengerName,
                        "age" => $passengerAge,
                        "type" => $passengerType,
                        "fare" => $personfare,
                        "finalfare" => $personfare - $passengerFare,
                    ];
                }
            }
            echo "<p>Total Fare: $totalFare</p>";
            echo "<p>Concession Fare: $discountfare</p>";
            echo "<p>Final Fare: " . ($totalFare - $discountfare) . "</p>";
        }
        ?>
    </div>

    <script>
        const maxPassengers = 6;
        let passengerCount = 1; // Initial passenger count

        const addPassengerLink = document.getElementById("addPassengerLink");
        const calculateFareButton = document.getElementById("calculateFareButton");
        const passengerForm = document.getElementById("passengerForm");

        addPassengerLink.addEventListener("click", function (e) {
            e.preventDefault();

            if (passengerCount < maxPassengers) {
                // Clone the last passenger row and add it to the form
                const lastPassengerRow = document.querySelector(".passenger-row");
                const newPassengerRow = lastPassengerRow.cloneNode(true);
                passengerForm.appendChild(newPassengerRow);

                // Clear values in the cloned row
                const inputFields = newPassengerRow.querySelectorAll("input, select");
                inputFields.forEach((input) => (input.value = ""));

                passengerCount++;
            } else {
                alert("You can add up to 6 passengers.");
            }
        });
    </script>
</body>

</html>
