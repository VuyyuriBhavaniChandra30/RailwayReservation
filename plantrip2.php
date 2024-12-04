<?php
    session_start();
    $_SESSION["filtertime"]= isset($_POST["time"]) ? $_POST["time"] : "ALL";
    $_SESSION["sorttime"] = isset($_POST["timesort"]) ? $_POST["timesort"] : "DEPARTUREASCENDING";
    $_SESSION["filterclass"]= isset($_POST["class"]) ? $_POST["class"] : array();
    $startTime = "00:00:00";
    $endTime = "23:59:59";
    if($_SESSION["filtertime"]==="ALL"){
        $startTime = "00:00:00";
        $endTime = "23:59:59";
    }
    else if($_SESSION["filtertime"]=== "MORNING") {
        $startTime = "05:00:00";
        $endTime = "11:59:59";
    } else if ($_SESSION["filtertime"] === "AFTERNOON") {
        $startTime = "12:00:00";
        $endTime = "17:59:59";
    } else if ($_SESSION["filtertime"] === "EVENING") {
        $startTime = "18:00:00";
        $endTime = "04:59:59";
    }
    $sort="ORDER BY sourcetime ASC";
    if ($_SESSION["sorttime"] === "departureascending") {
        $sort = " ORDER BY sourcetime ASC";
    } elseif ($_SESSION["sorttime"] === "departuredescending") {
        $sort = " ORDER BY sourcetime DESC";
    } elseif ($_SESSION["sorttime"] === "durationascending") {
        $sort = " ORDER BY duration ASC";
    } elseif ($_SESSION["sorttime"] === "durationdescending") {
        $sort = " ORDER BY duration DESC";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to bottom, #007BFF, #0056B3);
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        .form-container div {
            margin: 10px;
        }

        .form-container label {
            display: block;
        }

        select, input[type="text"], input[type="date"] {
            width: 100%;
            max-width: 200px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        select {
            background-color: #f7f7f7;
        }
        #classselect select,#classselect label{
            margin-left:12px;
        }
        input[type="date"] {
            background-color: #f7f7f7;
        }

        .submit-button {
            text-align: center;
        }

        .submit-button input[type="submit"] {
            padding: 10px 20px;
            background-color: green;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        #trainslist {
            border: 1px solid black;
            border-radius: 5px;
            width:80%;
            height:220px;
            margin:0.5%;
            background-color: white;
            overflow: hidden;
        }
        #working {
            margin-left: 500px;
            display: inline-block;
            margin-bottom:0;
        }

        p {
            display: inline;
        }

        .Y {
            color: green;
            font-weight: bold;
            background-color: lightgreen;
            border-radius: 50%;
            width: 18px;
            text-align: center;
            padding:5px;
            display: inline-block;
        }

        .N {
            color: red;
            font-weight: bold;
            background-color: #FFCCCB;
            border-radius: 50%;
            width: 18px;
            text-align: center;
            padding:5px;
            display: inline-block;
        }

        #fromto {
            display: flex;
            align-items: center;
            margin-left: 5%;
        }

        #timeduration {
            display: flex;
            align-items: center;
            margin-left:25%;
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

        #seats {
            display: flex;
            margin: 0.5%;
            overflow-y: auto;
        }

        .seat-box {
            border: 1px solid black;
            margin: 0.5%;
            white-space: nowrap;
            font-weight: bold;
            border-radius: 4px;
            width: 30%;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .classname {
            font-size: 16px;
            padding: 5px;
        }
        .class-details {
            font-size: 14px;
        }

        .availability-label {
            font-weight: bold;
            padding-top: 5px;
        }

        .availability-count {
            font-weight: normal;
            color: green;
            padding-top: 5px;
        }
        
        .hr-full-width {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        #filters {
            border: 1px solid black;
            width: 20%;
            overflow-x:auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            margin:0.5%;
        }

        #display-container {
            display: flex;
        }

        fieldset {
            border: 1px solid #ccc;
            padding:5px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        fieldset legend {
            font-weight: bold;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }
        #trainname {
            font-size: 25px;
            font-weight: bold;
            display: inline-block;
            margin-left:15px;
            margin-top:15px;
            margin-bottom:0;
        }
        input[type="radio"],
        input[type="checkbox"] {
            margin-right: 5px;
        }
    </style>
</head>
<body>
<form action="plantrip.php" method="POST">
    <div class="form-container">
        <div>
            <label for="from">FROM</label>
            <input type="text" name="from" value="<?php echo $_SESSION["from"]?>">
        </div>
        <div>
            <label for="to">TO</label>
            <input type="text" name="to" value="<?php echo $_SESSION["to"]?>">
        </div>
        <div>
            <label for="date">DD/MM/YYYY</label>
            <input type="date" name="date" id="date" value="<?php echo $_SESSION["date"]; ?>">
        </div>
        <script type="text/javascript">
                        $(function(){
                            var dtToday = new Date();
                         
                            var month = (dtToday.getMonth() + 1).toString().padStart(2, '0');
                            var day = dtToday.getDate().toString().padStart(2, '0');
                            var year = dtToday.getFullYear();
                            var maxDate = year + '-' + month + '-' + day;
                            $('#date').attr('min', maxDate);
                        });
                    </script>
        <div id="classselect">
            <label for="class">CLASS</label>
            <select name="class">
                <option value="ALL" <?php if ($_SESSION['class'] === 'ALL') echo 'selected'; ?>>ALL CLASSESS </option>
                <option value="EA" <?php if ($_SESSION['class'] === 'EA') echo 'selected'; ?>>ANUBHUTI CLASS (EA)</option>
                <option value="1A" <?php if ($_SESSION['class'] === '1A') echo 'selected'; ?>>AC FIRST CLASS (1A)</option>
                <option value="EV" <?php if ($_SESSION['class'] === 'EV') echo 'selected'; ?>>VISTADOME AC (EV)</option>
                <option value="EC" <?php if ($_SESSION['class'] === 'EC') echo 'selected'; ?>>EXEC. CHAIR CAR (EC)</option>
                <option value="2A" <?php if ($_SESSION['class'] === '2A') echo 'selected'; ?>>AC 2 TIER (2A)</option>
                <option value="FC" <?php if ($_SESSION['class'] === 'FC') echo 'selected'; ?>>FIRST CLASS (FC)</option>
                <option value="3A" <?php if ($_SESSION['class'] === '3A') echo 'selected'; ?>>AC 3 TIER (3A)</option>
                <option value="3E" <?php if ($_SESSION['class'] === '3E') echo 'selected'; ?>>AC 3 ECONOMY (3E)</option>
                <option value="VC" <?php if ($_SESSION['class'] === 'VC') echo 'selected'; ?>>VISTADOME CHAIR CAR (VC)</option>
                <option value="CC" <?php if ($_SESSION['class'] === 'CC') echo 'selected'; ?>>AC CHAIR CAR (CC)</option>
                <option value="SL" <?php if ($_SESSION['class'] === 'SL') echo 'selected'; ?>>SLEEPER (SL)</option>
                <option value="VS" <?php if ($_SESSION['class'] === 'VS') echo 'selected'; ?>>VISTADOME NON AC (VS)</option>
                <option value="2S" <?php if ($_SESSION['class'] === '2S') echo 'selected'; ?>>SECOND SITTING (2S)</option>
            </select>
        </div>
        <div id="typeselect">
            <label for="type">TYPE</label>
            <select name="type">
                <option value="GENERAL" <?php if ($_SESSION['type'] === 'GENERAL') echo 'selected'; ?>>GENERAL</option>
                <option value="LADIES" <?php if ($_SESSION['type'] === 'LADIES') echo 'selected'; ?>>LADIES</option>
                <option value="LOWER BERTH/SR.CITIZEN" <?php if ($_SESSION['type'] === 'LOWER BERTH/SR.CITIZEN') echo 'selected'; ?>>LOWER BERTH/SR.CITIZEN</option>
                <option value="PERSON WITH DISABILITY" <?php if ($_SESSION['type'] === 'PERSON WITH DISABILITY') echo 'selected'; ?>>PERSON WITH DISABILITY</option>
                <option value="DUTY PASS" <?php if ($_SESSION['type'] === 'DUTY PASS') echo 'selected'; ?>>DUTY PASS</option>
                <option value="TATKAL" <?php if ($_SESSION['type'] === 'TATKAL') echo 'selected'; ?>>TATKAL</option>
                <option value="PREMIUM TATKAL" <?php if ($_SESSION['type'] === 'PREMIUM TATKAL') echo 'selected'; ?>>PREMIUM TATKAL</option>
            </select>
        </div>
        <div class="submit-button">
            <input type="submit" name="GET_TRAINS" value="GET TRAINS">
        </div>
    </div>
</form>
<div id="display-container">
    <div id="filters">
        <form action="plantrip2.php" method="POST">
            <fieldset>
                <h2>FILTER BY:</h2>
                <fieldset class="departure">
                    <legend>DEPARTURE TIME</legend>
                    <?php
    $selectedTime = $_SESSION["filtertime"];
    $times = ['ALL', 'MORNING', 'AFTERNOON', 'EVENING'];

    foreach ($times as $time) {
        $checked = ($selectedTime === $time) ? 'checked="checked"' : '';
        echo '<label><input type="radio" name="time" value="' . $time . '"' . $checked . '>' . $time . '</label><br>';
    }
    ?>
                </fieldset>
            </fieldset>
            <fieldset>
                <h2>CLASS:</h2>
                <label>
                    <input type="checkbox" name="class[]" value="ALL CLASSES" <?php if (in_array("ALL CLASSES", $_SESSION["filterclass"])) echo 'checked'; ?>> ALL CLASSES
                </label><br>
                <label>
                    <input type="checkbox" name="class[]" value="ANUBHUTI CLASS" <?php if (in_array("ANUBHUTI CLASS", $_SESSION["filterclass"])) echo 'checked'; ?>> ANUBHUTI CLASS
                </label><br>
                <label>
                    <input type="checkbox" name="class[]" value="AC FIRSTCLASS" <?php if (in_array("AC FIRSTCLASS", $_SESSION["filterclass"])) echo 'checked'; ?>> AC FIRSTCLASS
                </label><br>
                <label>
                    <input type="checkbox" name="class[]" value="VISTADOME AC" <?php if (in_array("VISTADOME AC", $_SESSION["filterclass"])) echo 'checked'; ?>> VISTADOME AC
                </label><br>
                <label>
                    <input type="checkbox" name="class[]" value="EXEC. CHAIR CAR" <?php if (in_array("EXEC. CHAIR CAR", $_SESSION["filterclass"])) echo 'checked'; ?>> EXEC. CHAIR CAR
                </label><br>
                <label>
                    <input type="checkbox" name="class[]" value="AC 2 TIER" <?php if (in_array("AC 2 TIER", $_SESSION["filterclass"])) echo 'checked'; ?>> AC 2 TIER
                </label><br>
                <label>
                    <input type="checkbox" name="class[]" value="FIRST CLASS" <?php if (in_array("FIRST CLASS", $_SESSION["filterclass"])) echo 'checked'; ?>> FIRST CLASS
                </label><br>
                <label>
                    <input type="checkbox" name="class[]" value="AC 3 TIER" <?php if (in_array("AC 3 TIER", $_SESSION["filterclass"])) echo 'checked'; ?>> AC 3 TIER
                </label><br>
                <label>
                    <input type="checkbox" name="class[]" value="AC 3 ECONOMY" <?php if (in_array("AC 3 ECONOMY", $_SESSION["filterclass"])) echo 'checked'; ?>> AC 3 ECONOMY
                </label><br>
                <label>
                    <input type="checkbox" name="class[]" value="VISTADOME CHAIR CAR" <?php if (in_array("VISTADOME CHAIR CAR", $_SESSION["filterclass"])) echo 'checked'; ?>> VISTADOME CHAIR CAR
                </label><br>
                <label>
                    <input type="checkbox" name="class[]" value="AC CHAIR CAR" <?php if (in_array("AC CHAIR CAR", $_SESSION["filterclass"])) echo 'checked'; ?>> AC CHAIR CAR
                </label><br>
                <label>
                    <input type="checkbox" name="class[]" value="SLEEPER" <?php if (in_array("SLEEPER", $_SESSION["filterclass"])) echo 'checked'; ?>> SLEEPER
                </label><br>
                <label>
                    <input type="checkbox" name="class[]" value="VISTADOME NON AC" <?php if (in_array("VISTADOME NON AC", $_SESSION["filterclass"])) echo 'checked'; ?>> VISTADOME NON AC
                </label><br>
                <label>
                    <input type="checkbox" name="class[]" value="SECOND SITTING" <?php if (in_array("SECOND SITTING", $_SESSION["filterclass"])) echo 'checked'; ?>> SECOND SITTING
                </label><br>
            </fieldset>
            <fieldset>
                <h2>SORT BY:</h2>
                <fieldset class="sort">
    <legend>DEPARTURE TIME</legend>

    <?php
    $selectedSort = $_SESSION["sorttime"];
    $sortOptions = ['DEPARTUREASCENDING', 'DEPARTUREDESCENDING'];

    foreach ($sortOptions as $sortOption) {
        $checked = ($selectedSort === $sortOption) ? 'checked="checked"' : '';
        echo '<label><input type="radio" name="timesort" value="' . $sortOption . '"' . $checked . '>' . ucfirst($sortOption) . '</label><br>';
    }
    ?>

</fieldset>

<fieldset class="sort">
    <legend>DURATION TIME</legend>

    <?php
    $selectedDurationSort = $_SESSION["sorttime"];
    $durationSortOptions = ['DURATIONASCENDING', 'DURATIONDESCENDING'];

    foreach ($durationSortOptions as $durationSortOption) {
        $checked = ($selectedDurationSort === $durationSortOption) ? 'checked="checked"' : '';
        echo '<label><input type="radio" name="durationsort" value="' . $durationSortOption . '"' . $checked . '>' . ucfirst($durationSortOption) . '</label><br>';
    }
    ?>

</fieldset>
            </fieldset>
            <center><input type="submit" name="apply" value="APPLY"></center>
        </form>
    </div>
<?php
        $dbHost = "127.0.0.1";
        $dbUser = "vbc";
        $dbPassword = "root";
        $dbName = "railway";
        $conn = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);
        if (!$conn) {
            die("Connection error: " . mysqli_connect_error());
        }
        $from =$_SESSION["from"];
        $to =$_SESSION["to"];
        $date=$_SESSION["date"];
        $class =$_SESSION["class"];
        $type =$_SESSION["type"];
        if (in_array("ALL CLASSES", $_SESSION["filterclass"])) {
            $_SESSION["filterclass"]=array(); 
        }
        $day = strtolower(date('l', strtotime($_SESSION["date"])));
        $classes = $_SESSION["filterclass"]; 
        if (!empty($classes)) {
            $classList = implode("','", $classes);
            $sql = "SELECT DISTINCT r.* FROM route AS r
                    WHERE r.`from` = '$from'
                    AND r.`to` = '$to'
                    AND TIME(r.`sourcetime`) BETWEEN TIME('$startTime') AND TIME('$endTime')
                    AND r.trainno IN (SELECT trainno FROM class WHERE class IN ('$classList'))
                    AND r.trainno NOT IN (SELECT trainno FROM cancelled WHERE date = '" . $_SESSION["date"] . "')
                    AND (
                        (SELECT `$day` FROM train WHERE trainno = r.trainno) = 'Y'
                    )
                    $sort";
        } else {
            $sql = "SELECT * FROM route AS r
                    WHERE r.`from` = '$from'
                    AND r.`to` = '$to'
                    AND TIME(r.`sourcetime`) BETWEEN TIME('$startTime') AND TIME('$endTime')
                    AND r.trainno NOT IN (SELECT trainno FROM cancelled WHERE date = '" . $_SESSION["date"] . "')
                    AND (
                        (SELECT `$day` FROM train WHERE trainno = r.trainno) = 'Y'
                    )
                    $sort";
        }        
        $result = mysqli_query($conn, $sql);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div id="trainslist">' ;
                    $train=$row['trainno'];
                    $sql2="select * from train where trainno='$train'";
                    $res=mysqli_query($conn,$sql2);
                    if(mysqli_num_rows($res)>0){
                        while ($r = mysqli_fetch_assoc($res)) {
                            echo '<div id="trainname">' . $r["trainno"] .'-'. $r["trainname"] . '</div>'; 
                            echo '<div id="working"><p><strong>Runs On:</strong></p>
                            <p class="' . $r['sunday'] . '">S</p>
                            <p class="' . $r['monday'] . '">M</p>
                            <p class="' . $r['tuesday'] . '">T</p>
                            <p class="' . $r['wednesday'] . '">W</p>
                            <p class="' . $r['thursday'] . '">T</p>
                            <p class="' . $r['friday'] . '">F</p>
                            <p class="' . $r['saturday'] . '">S</p></div><hr>';
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
                    echo '</div>';
                    echo '</div>';
                    $sql3 = "SELECT * FROM stops WHERE stopname='" . $row['from'] . "'";
                    $res3 = mysqli_query($conn, $sql3);
                    if (mysqli_num_rows($res3) > 0) {
                        $r3 = mysqli_fetch_assoc($res3);
                        $classColumns = array("EA", "1A", "EV", "EC", "2A", "FC", "3A", "3E", "VC", "CC", "SL", "VS", "2S");
                        $classname = array("ANUBHUTI CLASS", "AC FIRSTCLASS", "VISTADOME AC", "EXEC. CHAIR CAR", "AC 2 TIER", "FIRST CLASS", "AC 3 TIER", "AC 3 ECONOMY", "VISTADOME CHAIR CAR", "AC CHAIR CAR", "SLEEPER", "VISTADOME NON AC", "SECOND SITTING");

                        echo '<div id="seats">';
                        foreach ($classColumns as $key => $classColumn) {
                            if ($r3[$classColumn] > 0) {
                                echo '<div class="seat-box">';
                                echo '<div class="classname">' . $classname[$key] . '[' . $classColumn . ']</div>';
                                echo '<hr class="hr-full-width"><div class="availability-label">Availability:</div><div class="availability-count">' . $r3[$classColumn] . '</div>';
                                echo '<a href="book.php?train_no=' . $train . '&class=' . $classColumn . '&date=' . $_SESSION["date"] . '&from=' . $_SESSION["from"] . '&to=' . $_SESSION["to"] . '" class="button"><button>BOOK</button></a>';
echo '</div>';
                            }
                        }
                        echo '</div>';
                    }
                }
            } else {
                echo "No results found.";
            }
        } else {
            $error = mysqli_error($conn);
            error_log("Query failed: " . $error);
            echo "Query failed: " . $error;
        }
    mysqli_close($conn);
?>
</div>
</body>
</html>