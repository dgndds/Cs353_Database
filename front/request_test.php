<!DOCTYPE html>
<html lang="en">
<head>
    <title>Request New Test</title>
    <link rel="stylesheet" href="request.css">
</head>
<body>
    <div id="page-title">Request New Test</div>
    <div id="request-container">
        <div class="user-input">
            <label for="patient-name">Patient</label>
            <select id="patients" name="patients">
                <?php
                    $patientCount = 15;
                    for($x=0;$x<$patientCount;$x++){
                        echo "<option value=\"Hakan-Kara\">Hakan Kara</option>";
                    }
                ?>
             </select>
        </div>
        <div class="user-input">
            <label for="test-type">Test Type</label>
            <select id="tests" name="tests">
                <?php
                    $patientCount = 15;
                    for($x=0;$x<$patientCount;$x++){
                        echo "<option value=\"blood-test\">Blood Test</option>";
                    }
                ?>
             </select>
        </div>
        <div class="user-input" id="component-input">
            <label for="test-components">Components</label>
            <select id="components" name="components">
                <option value="magnesium">Magnesium</option>
                <option value="calcium">Calcium</option>
                <option value="sugar">Sugar</option>
                <option value="sodium">Sodium</option>
                <option value="chlorine">Chlorine</option>
            </select>
        </div>
        <div><button id="add-button">Add Component</button></div>
        <div>
            <p>Requested Components</p>
            <ul>
                    <?php
                        for($x=0;$x<5;$x++){
                            echo "<li>Magnesium</li>";
                        }
                    ?>
            </ul>
        </div>
        <div>
            <input type="submit">
        </div>
    </div>
    <div><button id="return-button">Return</button></div>
</body>
</html>