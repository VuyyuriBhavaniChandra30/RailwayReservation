<!DOCTYPE html>
<html>
<head>
<style>
    body {
        background-color: #f0f0f0;
    }

    .form-container {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }

    .form-container div {
        margin: 10px;
    }

    .form-container label {
        display: block;
        color: #333;
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

    input[type="date"] {
        background-color: #f7f7f7;
    }

    .submit-button {
        text-align: center;
    }

    .submit-button input[type="submit"] {
        padding: 10px 20px;
        background-color: #007BFF;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 18px;
        cursor: pointer;
    }
</style>
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
            <div>
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
            <div>
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
</body>
</html>
