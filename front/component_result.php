<!DOCTYPE html>
<html>
    <head>
        <title>Component Result</title>
        <link rel="stylesheet" href="component.css">
    </head>
    <body>
        <div id="navbar">
            <p id="name-title">Welcome NAME SURNAME</p> 
            <button id="logout">Logout</button>
        </div>
        <div>
           <div id="comp-title">COMPONENT RESULT HISTORY</div> 
           <div id="comp-name">SELECTED COMPONENT: COMPONENT NAME</div>
           <div id="result-container">
            <table>
                <tr>
                    <th>Test Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Normality Interval</th>
                    <th>Result</th>
                </tr>
                <?php
                    $resultCount = 7;
                    for ($x = 0; $x <= $resultCount; $x++) {
                         echo "<tr>
                                  <td>Blood Test</td>
                                  <td>05/06/2021</td>
                                  <td>18:36</td>
                                  <td>5-10 mg</td>
                                  <td>7 mg</td>
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