<?php

session_start();

$email = $_POST["email"];
$password = $_POST["pass"];

if($email == null || $password == null){
    header("Location: ../html/signIn.html");
    die();
}

// default Heroku Postgres configuration URL
$dbUrl = getenv('DATABASE_URL');

if (empty($dbUrl)) {
 // example localhost configuration URL with postgres username and a database called cs313db
 $dbUrl = "postgres://postgres:2016Aprende@localhost:5432/postgres";
}

$dbopts = parse_url($dbUrl);


$dbHost = $dbopts["host"];
$dbPort = $dbopts["port"];
$dbUser = $dbopts["user"];
$dbPassword = $dbopts["pass"];
$dbName = ltrim($dbopts["path"],'/');


try {
 $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
}
catch (PDOException $ex) {
 print "<p>error: $ex->getMessage() </p>\n\n";
 die();
}         
 
foreach($db->query('SELECT email, user_password FROM teacher') as $check){
    if($email != $check['email']){
        echo "You entered an incorrect email address: " . $email;
        die();
        }
    if($password != $check['user_password']){
        echo "You entered an incorrect password.";
        die();
        }
}

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Di Violino</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/violinStudio.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    </head>

    <body>
        <nav class=" navbar navbar-expand-lg navbar-light bg-light "> <a class="navbar-brand" href="../index.html">De Violín | Maestro</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item"> <a class="nav-link" href="teachers.php">Teacher Home <span class="sr-only">(current)</span></a> </li>
                    <!--                    <li class="nav-item"> <a class="nav-link" href="#">Philosophy</a> </li>-->
                    <!--                    <li class="nav-item"> <a class="nav-link" href="#">Events</a> </li>-->
                    <!--                    <li class="nav-item"> <a class="nav-link" href="#">Students</a> </li>-->
                </ul>
                <ul class="navbar-nav mt-2 mt-lg-0">
                    <li class="nav-item"> <a class="nav-link" href="../index.html">Studio Home</a> </li>
                    <!--                    <li class="nav-item navbar-right"> <a class="nav-link" href="#">Sign Out</a> </li>-->
                    <!--                    TODO// how do you do a sign out?-->
                </ul>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div id="updateOptions" data-children=".item">
                    <div class="item">
                        <a data-toggle="collapse" data-parent="#updateOptions" href="#updateStudentProgress" aria-expanded="false" aria-controls="updateStudentProgress">
                            <h5 class="display-4">View Student Progress</h5> </a>
                        <div id="updateStudentProgress" class="collapse" role="tabpanel">
                            <p class="mb-3">
                                <?php                           
    foreach ($db->query('SELECT id, first_name, last_name, music_level FROM student') as $row)
{
    echo '<div class="railroad-border">';
        echo '<p class="mb-3">';
            echo '<strong>' .$row['first_name'] . " " . $row['last_name'] . "</strong> : Level - " . $row['student_level'];
        echo "</p>";
        echo "<p> Practice Records </p>";
    $id = $row['id'];
    $practicing = false;
        foreach ($db->query('SELECT student, practice_date, practice_time, comments FROM practice_records;') as $row2){
            if($id == $row2['student']){
                 echo "<div>";
                echo "<p>" ;
                echo "Date: " . $row2['practice_date'] . " Time Practiced: " . $row2['practice_time']. " Comments: " . $row2['comments'];
                echo "</p>";
            echo "</div>";
                $practicing = true;
            }
        }
    if($practicing == false){
        echo "<p> No practicing recorded.</p>";
    }
    echo "</div>";
}?>
                            </p>
                        </div>
                    </div>
                    <!--
                    <div class="item">
                        <a data-toggle="collapse" data-parent="#updateOptions" href="#updatePhilosophy" aria-expanded="false" aria-controls="updateOptions">
                            <h5 class="display-4">Update Philosophy</h5> </a>
                        <div id="updatePhilosophy" class="collapse" role="tabpanel">
                            <p class="mb-3"> </p> //TODO Update the Philosophy </div>
                    </div>
-->
                    <div class="item">
                        <a data-toggle="collapse" data-parent="#updateOptions" href="#updateEvents" aria-expanded="false" aria-controls="updateOptions">
                            <h5 class="display-4">Create Events</h5> </a>
                        <div id="updateEvents" class="collapse" role="tabpanel">
                            <p class="mb-3"> </p>
                            <form method="post" action="">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Event Name</label>
                                    <input type="text" class="form-control" id="eventName" placeholder="Event name"> </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Start Time</label>
                                    <input type="text" class="form-control" id="startTime" placeholder="HH:MM">
                                    <label for="exampleFormControlInput1">End Time</label>
                                    <input type="text" class="form-control" id="endTime" placeholder="HH:MM">
                                    <label for="monthSelect">Select Month</label>
                                    <select class="form-control" id="monthSelect">
                                        <option>January</option>
                                        <option>February</option>
                                        <option>March</option>
                                        <option>April</option>
                                        <option>May</option>
                                        <option>June</option>
                                        <option>July</option>
                                        <option>August</option>
                                        <option>September</option>
                                        <option>October</option>
                                        <option>November</option>
                                        <option>December</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="daySelect">Select day</label>
                                    <select class="form-control" id="daySelect">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                        <option>13</option>
                                        <option>14</option>
                                        <option>15</option>
                                        <option>16</option>
                                        <option>17</option>
                                        <option>18</option>
                                        <option>19</option>
                                        <option>20</option>
                                        <option>21</option>
                                        <option>22</option>
                                        <option>23</option>
                                        <option>24</option>
                                        <option>25</option>
                                        <option>26</option>
                                        <option>27</option>
                                        <option>28</option>
                                        <option>29</option>
                                        <option>30</option>
                                        <option>31</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="yearSelect">Select Year</label>
                                    <select class="form-control" id="yearSelect">
                                        <option>2017</option>
                                        <option>2018</option>
                                        <option>2019</option>
                                        <option>2020</option>
                                        <option>2021</option>
                                        <option>2022</option>
                                        <option>2023</option>
                                        <option>2024</option>
                                        <option>2025</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="eventDescription">Event Description</label>
                                    <textarea class="form-control" id="eventDescription" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn">Create Event</button>
                            </form>
                        </div>
                    </div>
                    <!--
                    <div class="item">
                        <a data-toggle="collapse" data-parent="#updateOptions" href="#updateStudents" aria-expanded="false" aria-controls="updateOptions">
                            <h5 class="display-4">Update Students</h5> </a>
                        <div id="updateStudents" class="collapse" role="tabpanel">
                            <p class="mb-3"> </p> //TODO Update Students name, level, practice time </div>
                    </div>
--></div>
            </div>
        </div>
    </body>

    </html>