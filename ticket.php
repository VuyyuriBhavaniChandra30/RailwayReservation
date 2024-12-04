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
$pcount=$_SESSION["pcount"];

// You should add error handling for database queries
$sql1 = "SELECT MAX(seat_number) AS max_seat FROM reservation WHERE trainno = '$trainno' AND class = '$class' AND bookingfor = '$date'";
$res1 = mysqli_query($conn, $sql1);
$row = mysqli_fetch_assoc($res1);
$maxSeatNumber = $row['max_seat'];

$sql2 = "SELECT * FROM stops WHERE trainno = '$trainno' AND stopid >= (SELECT stopid FROM stops WHERE stopname = '$from' AND trainno = '$trainno') AND stopid <= (SELECT stopid FROM stops WHERE stopname = '$to' AND trainno = '$trainno')";
$res2 = mysqli_query($conn, $sql2);

while ($r2 = mysqli_fetch_assoc($res2)) {
    $stop_capacity = $r2[$classcode];
    $stop_id = $r2['stopid'];

    $seatsToAllocate = $pcount;

    $updateSql = "UPDATE stops SET $classcode = $stop_capacity - $seatsToAllocate WHERE trainno = '$trainno' AND stopid = $stop_id";
    if(mysqli_query($conn, $updateSql)){
    } else {
        echo "Error updating availability count for stop {$r2['stopname']}: " . mysqli_error($conn) . "<br>";
    }
}

$nextSeatNumber = $maxSeatNumber + 1;

for($i=0;$i<$pcount;$i++){
    $ticketNumber = $class . '-' . $nextSeatNumber;
    
    // Add the seat number to the passenger array
    $passenger['seat_number'] = $ticketNumber;
    
    $insertSql = "INSERT INTO reservation (bookingid, `from`, `to`, bookingfor, reserveddate, trainno, class, seat_number)
    VALUES ('$bookingid', '$from', '$to', '$date', NOW(), '$trainno', '$class', '$nextSeatNumber')";

    if (mysqli_query($conn, $insertSql)) {
        $nextSeatNumber++; // Increment the seat number for the next passenger
    } else {
        echo "Error allocating the ticket: " . mysqli_error($conn) . "<br>";
    }
}
header('Location: ticket2.php');
exit;
mysqli_close($conn);
?>
