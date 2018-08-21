<?php
session_start();
if (!isset($_SESSION['success'])) {
  header('Location: index.php');
}

/* Global vars */
$absence = 0;
$dates = array();
$come_time = array();
$leave_time = array();
$hours_worked = array();
$average_hours_worked = 0;

ini_set("display_errors",1);
error_reporting(-1);
$dsn = "mysql:host=**.**.**.**;dbname=timesheet";
$charset='utf8mb4';
$host = 'localhost';
$dbuser = '***';
$db = 'timesheet';
$dbpass = '***';

try {
    $pdo = new PDO("mysql:host=**.**.**.**;dbname=timesheet", $dbuser, $dbpass); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    getNumberOfAbsence($pdo);
    getAttendance($pdo);
    getAvgHoursWorked($pdo);
}

catch (PDOException $e){  
    echo 'Connection failed: ' . $e->getMessage();
}

function getNumberOfAbsence( $pdo ) {
    global $absence;
    $username = trim( $_SESSION['user']);

    $stmt = $pdo->prepare("SELECT number_of_absence FROM users WHERE username=:username");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetchAll();
    foreach( $result as $row) {
        $absence = $row["number_of_absence"];
        
    }
    

}

function getAttendance( $pdo ) {
    global $dates, $come_time, $leave_time;

     $username = trim( $_SESSION['user']); 

    // calculate/update time difference before getting it
   
    
     $stmt = $pdo->prepare("UPDATE " .$username . " SET time_diff=TIMEDIFF(leave_time,come_time)");
     //$stmt->bindParam(':username', $username, PDO::PARAM_STR);
     $stmt->execute();

     //fetching data
     $stmt = $pdo->prepare("SELECT * FROM :username");
     $stmt->bindParam(':username', $username, PDO::PARAM_STR);
     $stmt->execute(); 
     
     $result = $stmt->fetchAll();
     foreach( $result as $row) {
         array_push($dates, $row["date_of_record"]); 
         array_push($come_time, $row["come_time"]);
         array_push($leave_time, $row["leave_time"]); //TODO WHAT IF IT'S NULL? 
         array_push($hours_worked, $row["time_diff"]);
     }
     
}

function getAvgHoursWorked( $pdo ) {
    global $average_hours_worked;

    $username = trim( $_SESSION['user']);

    $stmt = $pdo->prepare("SELECT avg_hours_worked from users where username=:username");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);   
    $stmt->execute();

    $result = $stmt->fetchAll();
    foreach( $result as $row) {
        $average_hours_worked = $row[ "avg_hours_worked"];
    }
}
?>

    <!DOCTYPE html>
    <html>

    <head lang="en">
        <meta charset="UTF-8">
        <title>Timesheet Journal</title>
        <link rel="stylesheet" href="style.css"></link>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <!-- USING GOOGLE CHARTS API  -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load("current", {
                packages: ["calendar"]
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn({
                    type: 'date',
                    id: 'Date'
                });
                dataTable.addColumn({
                    type: 'number',
                    id: 'Hours worked'
                });
                dataTable.addRows([
                    [new Date(2018, 5, 13), 8],
                    [new Date(2018, 5, 14), 8],
                    [new Date(2018, 5, 15), 7],
                    [new Date(2018, 5, 16), 9],
                    [new Date(2018, 5, 17), 8],
                    [new Date(2018, 6, 17), 8],
                    [new Date(2018, 7, 17), 8],
                    // Many rows omitted for brevity.
                ]);

                var chart = new google.visualization.Calendar(document.getElementById('calendar_basic'));

                var options = {
                    title: "Attendance",
                    height: 350,
                    calendar: {
                        cellColor: {
                            stroke: '#76a7fa',
                            strokeOpacity: 0.5,
                            strokeWidth: 1,
                        },

                        cellSize: 12,
                    },
                    colorAxis: {
                        minValue: 0,
                        colors: ['#fceaea', '#f90909']
                    },

                };

                chart.draw(dataTable, options);

            }

        </script>
        <!-- DONUT CHART -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load("current", {
                packages: ["corechart"]
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Hours Category', 'Hours Number'],
                    ['9 hours', 11],
                    ['8 hours', 2],
                    ['7 hours', 7],
                    ['2 hours', 2],
                    ['0 hours', 2]
                ]);

                var options = {
                    title: 'Hours Worked per Day',
                    pieHole: 0.2,
                };

                var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
                chart.draw(data, options);
            }

        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#logout").click(function() {
                    $.ajax({
                        type: "POST",
                        url: 'logout.php',
                        data: ({
                            logout: 1
                        }),
                        dataType: "html",
                        success: function(data) {
                            window.location = 'index.php';
                        },
                        error: function() {}
                    });
                });
            });

        </script>

    </head>

    <header>
        <p>Timesheet</p>
    </header>

    <body>
        <p>Welcome
            <?php                                                         
          echo $_SESSION['user'];  
        ?>
        </p>


        <button id="enter_todays_data"> Enter today's data</button>
        <button id="logout">Logout</button>
        <div class="datasection" id='dataSection'>
            <div class="today_data">
                <h1>Statistic:</h1>
                <h2><span style="font-weight:bold">Average Working Hours:</span> <span style="color:blue; font-weight:bold">
                <?php
                  global $average_hours_worked;
                  echo  $average_hours_worked;
                ?>
                </span></h2>

                <div aria-label="graphs">
                    <div aria-label="attendance chart">
                        <div id="calendar_basic" style="width: 100%; height: 175px"></div>
                    </div>
                    <div aria-label="working hours donut chart">
                        <div id="donutchart" style="width: 100%; height: 250px;"></div>
                    </div>
                    <div aria-label='number of absences'>
                        <h2><span style="font-weight:bold">Total Number of Absences:</span> <span style="color:blue; font-weight:bold">
                   <?php 
                   global $absence;
                   echo $absence;
                    ?>
                   </span></h2>
                    </div>
                </div>
            </div>
            <div class="history">
                <h1> History:</h1>
            </div>
        </div>

    </body>

    <footer>

    </footer>

    </html>
