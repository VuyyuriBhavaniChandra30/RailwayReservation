<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const applyButton = document.querySelector("input[value='APPLY']");

        applyButton.addEventListener("click", function (e) {
            e.preventDefault(); // Prevent the default form submission

            // Get selected filter values
            const timeFilter = document.querySelector("input[name='time']:checked").value;
            const availFilter = document.querySelector("input[name='avail']:checked").value;
            // Add code to get other filter values if needed

            // Update the form input values with selected filters
            document.querySelector("input[name='time']").value = timeFilter;
            document.querySelector("input[name='avail']").value = availFilter;
            // Update other input values with selected filters if needed

            // Submit the form
            document.getElementById("filter-form").submit();
        });
    });
</script>
</head>
<body>
<form action="plantrip.php" method="POST">
        <div class="form-container">
            <div>
                <label for="from">FROM</label>
                <input type="text" name="from" value="<?php echo isset($_POST['from']) ? $_POST['from'] : ''; ?>">
            </div>
            <div>
                <label for="to">TO</label>
                <input type="text" name="to" value="<?php echo isset($_POST['to']) ? $_POST['to'] : ''; ?>">
            </div>
            <div>
                <label for="date">DD/MM/YYYY</label>
                <input type="date" name="date" value="<?php echo isset($_POST['date']) ? $_POST['date'] : ''; ?>">
            </div>
            <div id="classselect">
                <label for="class">CLASS</label>
                <select name="class" value="<?php echo isset($_POST['class']) ? $_POST['class'] : ''; ?>">
                            <option value="ALL" <?php if (isset($_POST['class']) && $_POST['class'] === 'ALL') echo 'selected'; ?>>ALL CLASSESS </option>
                            <option value="EA" <?php if (isset($_POST['class']) && $_POST['class'] === 'EA') echo 'selected'; ?>>ANUBHUTI CLASS (EA)</option>
                            <option value="1A" <?php if (isset($_POST['class']) && $_POST['class'] === '1A') echo 'selected'; ?>>AC FIRST CLASS (1A)</option>
                            <option value="EV" <?php if (isset($_POST['class']) && $_POST['class'] === 'EV') echo 'selected'; ?>>VISTADOME AC (EV)</option>
                            <option value="EC" <?php if (isset($_POST['class']) && $_POST['class'] === 'EC') echo 'selected'; ?>>EXEC. CHAIR CAR (EC)</option>
                            <option value="2A" <?php if (isset($_POST['class']) && $_POST['class'] === '2A') echo 'selected'; ?>>AC 2 TIER (2A)</option>
                            <option value="FC" <?php if (isset($_POST['class']) && $_POST['class'] === 'FC') echo 'selected'; ?>>FIRST CLASS (FC)</option>
                            <option value="3A" <?php if (isset($_POST['class']) && $_POST['class'] === '3A') echo 'selected'; ?>>AC 3 TIER (3A)</option>
                            <option value="3E" <?php if (isset($_POST['class']) && $_POST['class'] === '3E') echo 'selected'; ?>>AC 3 ECONOMY (3E)</option>
                            <option value="VC" <?php if (isset($_POST['class']) && $_POST['class'] === 'VC') echo 'selected'; ?>>VISTADOME CHAIR CAR (VC)</option>
                            <option value="CC" <?php if (isset($_POST['class']) && $_POST['class'] === 'CC') echo 'selected'; ?>>AC CHAIR CAR (CC)</option>
                            <option value="SL" <?php if (isset($_POST['class']) && $_POST['class'] === 'SL') echo 'selected'; ?>>SLEEPER (SL)</option>
                            <option value="VS" <?php if (isset($_POST['class']) && $_POST['class'] === 'VS') echo 'selected'; ?>>VISTADOME NON AC (VS)</option>
                            <option value="2S" <?php if (isset($_POST['class']) && $_POST['class'] === '2S') echo 'selected'; ?>>SECOND SITTING (2S)</option>
                        </select>
            </div>
            <div id="typeselect">
                <label for="type">TYPE</label>
                <select name="type">
    <option value="GENERAL" <?php if (isset($_POST['type']) && $_POST['type'] === 'GENERAL') echo 'selected'; ?>>GENERAL</option>
    <option value="LADIES" <?php if (isset($_POST['type']) && $_POST['type'] === 'LADIES') echo 'selected'; ?>>LADIES</option>
    <option value="LOWER BERTH/SR.CITIZEN" <?php if (isset($_POST['type']) && $_POST['type'] === 'LOWER BERTH/SR.CITIZEN') echo 'selected'; ?>>LOWER BERTH/SR.CITIZEN</option>
    <option value="PERSON WITH DISABILITY" <?php if (isset($_POST['type']) && $_POST['type'] === 'PERSON WITH DISABILITY') echo 'selected'; ?>>PERSON WITH DISABILITY</option>
    <option value="DUTY PASS" <?php if (isset($_POST['type']) && $_POST['type'] === 'DUTY PASS') echo 'selected'; ?>>DUTY PASS</option>
    <option value="TATKAL" <?php if (isset($_POST['type']) && $_POST['type'] === 'TATKAL') echo 'selected'; ?>>TATKAL</option>
    <option value="PREMIUM TATKAL" <?php if (isset($_POST['type']) && $_POST['type'] === 'PREMIUM TATKAL') echo 'selected'; ?>>PREMIUM TATKAL</option>
</select>

            </div>
            <div class="submit-button">
                <input type="submit" value="GET TRAINS">
            </div>
        </div>
    </form>
    <div id="display-container">
    <div id="filters">
    <form action="plantrip.php" method="POST">
    <fieldset>
    <h2>FILTER BY:</h2>
    <fieldset class="departure">
        <legend>DEPARTURE TIME</legend>
        <label>
            <input type="radio" name="time" value="all" checked> All
        </label><br>
        <label>
            <input type="radio" name="time" value="morning"> Morning
        </label><br>
        <label>
            <input type="radio" name="time" value="afternoon"> Afternoon
        </label><br>
        <label>
            <input type="radio" name="time" value="evening"> Evening
        </label><br>
    </fieldset>
    </fieldset>
    <fieldset>
    <h2>CLASS:</h2>
    <label>
        <input type="checkbox" name="class[]" value="ALL CLASSES" checked> ALL CLASSES
    </label><br>
    <label>
        <input type="checkbox" name="class[]" value="ANUBHUTI CLASS"> ANUBHUTI CLASS
    </label><br>
    <label>
        <input type="checkbox" name="class[]" value="AC FIRSTCLASS"> AC FIRSTCLASS
    </label><br>
    <label>
        <input type="checkbox" name="class[]" value="VISTADOME AC"> VISTADOME AC
    </label><br>
    <label>
        <input type="checkbox" name="class[]" value="EXEC. CHAIR CAR"> EXEC. CHAIR CAR
    </label><br>
    <label>
        <input type="checkbox" name="class[]" value="AC 2 TIER"> AC 2 TIER
    </label><br>
    <label>
        <input type="checkbox" name="class[]" value="FIRST CLASS"> FIRST CLASS
    </label><br>
    <label>
        <input type="checkbox" name="class[]" value="AC 3 TIER"> AC 3 TIER
    </label><br>
    <label>
        <input type="checkbox" name="class[]" value="AC 3 ECONOMY"> AC 3 ECONOMY
    </label><br>
    <label>
        <input type="checkbox" name="class[]" value="VISTADOME CHAIR CAR"> VISTADOME CHAIR CAR
    </label><br>
    <label>
        <input type="checkbox" name="class[]" value="AC CHAIR CAR"> AC CHAIR CAR
    </label><br>
    <label>
        <input type="checkbox" name="class[]" value="SLEEPER"> SLEEPER
    </label><br>
    <label>
        <input type="checkbox" name="class[]" value="VISTADOME NON AC"> VISTADOME NON AC
    </label><br>
    <label>
        <input type="checkbox" name="class[]" value="SECOND SITTING"> SECOND SITTING
    </label><br>
</fieldset>
<fieldset>
    <h2>SORT BY:</h2>
    <fieldset class="sort">
        <legend>DEPARTURE TIME</legend>
        <label>
            <input type="radio" name="timesort" value="departureascending" checked> ASCENDING
        </label><br>
        <label>
            <input type="radio" name="timesort" value="departuredescending"> DESCENDING
        </label><br>
    </fieldset>
    <fieldset class="sort">
        <legend>DURATION TIME</legend>
        <label>
            <input type="radio" name="timesort" value="durationascending"> ASCENDING
        </label><br>
        <label>
            <input type="radio" name="timesort" value="durationdescending"> DESCENDING
        </label><br>
    </fieldset>
</fieldset>
<center><input type="submit" value="APPLY"></center>
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
    $from = "";
    $to = "";
    $date="";
    $class="";
    $type="";
    if (isset($_POST["from"]) && isset($_POST["to"])) {
    $filtertime = isset($_POST["time"]) ? $_POST["time"] : "all";
    $sorttime = isset($_POST["timesort"]) ? $_POST["timesort"] : "departureascending";
    $startTime = "00:00:00";
    $endTime = "23:59:59";
    if($filtertime==="all"){
        $startTime = "00:00:00";
        $endTime = "23:59:59";
    }
    else if($filtertime === "morning") {
        $startTime = "05:00:00";
        $endTime = "11:59:59";
    } else if ($filtertime === "afternoon") {
        $startTime = "12:00:00";
        $endTime = "17:59:59";
    } else if ($filtertime === "evening") {
        $startTime = "18:00:00";
        $endTime = "23:59:59";
    }
    $sort="ORDER BY sourcetime ASC";
    if ($sorttime === "departureascending") {
        $sort = " ORDER BY sourcetime ASC";
    } elseif ($sorttime === "departuredescending") {
        $sort = " ORDER BY sourcetime DESC";
    } elseif ($sorttime === "durationascending") {
        $sort = " ORDER BY duration ASC";
    } elseif ($sorttime === "durationdescending") {
        $sort = " ORDER BY duration DESC";
    }
        $from = mysqli_real_escape_string($conn, $_POST["from"]);
        $to = mysqli_real_escape_string($conn, $_POST["to"]);
        $sql = "SELECT * FROM route 
    WHERE `from` = '$from' 
    AND `to` = '$to'
    AND TIME(`sourcetime`) BETWEEN TIME('$startTime') AND TIME('$endTime') $sort";
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
    } else {
        echo "Please provide valid 'from' and 'to' values.";
    }
    mysqli_close($conn);
?>
</div>
</body>
</html>