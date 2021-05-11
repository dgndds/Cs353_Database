<!DOCTYPE html>
<html>
    <head>
        <title>Patient Appointments</title>
        <link rel="stylesheet" href="appointment.css">
    </head>
    <body>
        <div id="navbar">
            <p id="name-title">Welcome NAME SURNAME</p> 
            <button id="logout">Logout</button>
        </div>
        <div>
           <div id="appoint-title">PATIENT APPOINTMENT HISTORY</div> 
           <!-- <div id="comp-name">SELECTED COMPONENT: COMPONENT NAME</div> -->
           <div id="result-container">
            <table>
                <tr>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Symptomps and Diseases</th>
                </tr>
                <?php
                    $resultCount = 7;
                    for ($x = 0; $x <= $resultCount; $x++) {
                         echo "<tr>
                                  <td>Hakan Kara</td>
                                  <td>Murat Kuşçu</td>
                                  <td>05/06/2021</td>
                                  <td>18:36</td>
                                  <td><a href=\"#\">view</a></td>
                               </tr>";
                    }
                ?>
            </table>
           </div>
           <div id="result-page-nums">
               <ul>
                   <?php
                        $pageCount = 10;

                        for($x = 1; $x<=$pageCount; $x++){
                            echo "<li><a href=\"#\">$x</a></li>";
                        }
                   ?>
               </ul>
           </div>
           <button id="return-button">Back</button>
        </div>
    </body>
</html>