<?php
session_start();
$dbHost = "127.0.0.1";
        $dbUser = "vbc";
        $dbPassword = "root";
        $dbName = "railway";
        $conn = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);
        if (!$conn) {
            die("Connection error: " . mysqli_connect_error());
        }
$trainno = $_SESSION["ftrainno"];
$class = $_SESSION["fclass"];
$date = $_SESSION["fdate"];
$classcode = $_SESSION["fclasscode"];
$from = $_SESSION["from"];
$to = $_SESSION["to"];
$bookingid = $_SESSION["fbookingid"];
$sourceTime = $_SESSION["fsrctime"];
$destTime = $_SESSION["fdesttime"];
$passengerCount = $_SESSION["pcount"];
$html = "
<!DOCTYPE html>
<html>
<head>
    <title>Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
        }
        .ticket {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        h1 {
            font-size: 24px;
            margin: 0;
        }
        h2 {
            font-size: 20px;
            margin: 20px 0 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
        }
        tr{
            text-align:center;
        }
        .home-button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class='ticket'>
        <h1>Ticket Information</h1>
        <p><strong>Train Number:</strong> $trainno</p>
        <p><strong>Class:</strong> $class</p>
        <p><strong>Date:</strong> $date</p>
        <p><strong>From:</strong> $from</p>
        <p><strong>To:</strong> $to</p>
        <p><strong>Source Time:</strong> $sourceTime</p>
        <p><strong>Destination Time:</strong> $destTime</p>
        <p><strong>Booking ID:</strong> $bookingid</p>
        
        <h2>Seat Numbers:</h2>
        <table>
            <tr>
                <th>Seat Number</th>
            </tr>";

            for ($i = 1; $i <= $passengerCount; $i++) {
                // Replace 'your_table_name' with the actual table name where seat numbers are stored
                $query = "SELECT seat_number FROM reservation WHERE bookingid = '$bookingid'";
                
                $result = mysqli_query($conn, $query);
            
                if (mysqli_num_rows($result)>0) {
                    while($row = mysqli_fetch_assoc($result)){
                        $seatNumber =$class . '-' . $row['seat_number'];
                    $html .= "
                        <tr>
                            <td>$seatNumber</td>
                        </tr>";
                    }
                } else {
                }
            }
            

$html .= "
        </table>
    </div>
    <button class='home-button' onclick='goHome()'>Home</button>
    <script>
        function goHome() {
            // Redirect to the home page or desired location
            window.location.href = 'in.html';
        }
    </script>
</body>
</html>
";

header('Content-Type: text/html');
echo $html;
?>
