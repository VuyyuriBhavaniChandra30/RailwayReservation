<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Booking</title>
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
        #passenger-details {
            border: 1px solid black;
            border-radius: 3px;
            margin-top:10px;
            padding: 10px;
        }
        table {
        border-collapse: collapse;
        width: 100%;
    }
    th{
        padding:8px;
        text-align:left;
    }
    td {
        padding: 8px;
        text-align:left;
    }
    #total-details {
            border: 1px solid black;
            border-radius: 3px;
            margin-top:10px;
            padding:10px;
        }
        #total-price,#concession-price,#final-price,#transaction-charge {
            font-weight: bold;
            font-size: 20px;
        }

        #pay-now-button {
            margin: 10px;
            padding: 10px;
            font-size: 18px;
            background-color: orange;
            border-radius: 3px;
            font-weight: bold;
            border-color: orange;
            color: white;
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

        $trainNo = mysqli_real_escape_string($conn, $_GET["trainno"]);
        $class = mysqli_real_escape_string($conn, $_GET["class"]);
        $from = mysqli_real_escape_string($conn, $_GET['from']);
        $to = mysqli_real_escape_string($conn, $_GET['to']);

        $_SESSION["ftrainno"]=$trainNo;
        $_SESSION["fclass"]=$class;
        $_SESSION["ffrom"]=$from;
        $_SESSION["to"]=$to;

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
        $_SESSION["fsrctime"]=$row["sourcetime"];
        $_SESSION["fdesttime"]=$row["desttime"];
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
    <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["calculateFare"])) {
            $passengers = [];
            $totalFare = 0;
            $discountfare = 0;
            $_SESSION["pcount"]=count($_POST['name']);
            for ($i = 0; $i < count($_POST['name']); $i++) {
                if (isset($_POST["name"][$i]) && isset($_POST["age"][$i]) && isset($_POST["gender"][$i]) && isset($_POST["type"][$i])) {
                    $passengerName = $_POST["name"][$i];
                    $passengerAge = intval($_POST["age"][$i]);
                    $passengerGender = $_POST["gender"][$i];
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
                        "gender" => $passengerGender,
                        "type" => $passengerType,
                        "fare" => $personfare,
                        "finalfare" => $personfare - $passengerFare,
                    ];
                }
            }
        }
        $_SESSION['passenger'] = $passengers;
        ?>
    <div id="passenger-details">
        <h1>Passenger Details</h1>
        <?php
        if (isset($passengers)) {
            echo '<table>';
            echo '<tr><th>Name</th><th>Age</th><th>Gender</th><th>Type</th><th>Price</th><th>Concession Price</th><th>Final Price</th></tr>';
            foreach ($passengers as $passenger) {
                echo '<tr>';
                echo '<td>' . $passenger["name"] . '</td>';
                echo '<td>' . $passenger["age"] . '</td>';
                echo '<td>' . $passenger["gender"] . '</td>';
                echo '<td>' . $passenger["type"] . '</td>';
                echo '<td>' . $passenger["fare"] . '</td>';
                echo '<td>' . $passenger["fare"]-$passenger["finalfare"] . '</td>';
                echo '<td>' . $passenger["finalfare"] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }
        ?>
        </div>
    <div id="total-details">
        <h2>Total Fare Details</h2>
        <?php
if (isset($totalFare) && isset($discountfare)) {
    // Calculate the transaction charges per passenger
    $transactionCharge = 25;
    
    // Calculate the final price for each passenger including transaction charges
    $finalPrice = ($totalFare - $discountfare) + ($transactionCharge * count($passengers));

    echo '<div id="total-price">Total Price: Rs.' . $totalFare . '</div>';
    echo '<div id="concession-price">Concession Price: Rs.' . $discountfare . '</div>';
    echo '<div id="transaction-charge">Transaction Charges: Rs.' . ($transactionCharge * count($passengers)) . '</div>';
    echo '<div id="final-price">Final Price: Rs.' . $finalPrice . '</div>';
}
?>
    </div>

    <form action="payment.php?fare=<?php echo $finalPrice;?>" method="post">
        <button type="submit" id="pay-now-button" name="payNow">Pay Now</button>
    </form>
</body>

</html>
