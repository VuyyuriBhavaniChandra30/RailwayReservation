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