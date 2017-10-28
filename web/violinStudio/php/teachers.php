<?php

session_start();

if(!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] != true) {
    header('Location: signIn.php');
    die();
}
$email = $_SESSION["email"];
require("dbconnect.php");
$db = get_db();
try{
    $query = 'SELECT first_name, last_name FROM teacher WHERE email = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);

    $result = $statement->execute();
    if ($result){
        $row = $statement->fetch();
        $_SESSION["fullname"] = $row['first_name'] . " " . $row['last_name'];
        $_SESSION["email"] = $email;
    }
}
catch (Exception $ex)
{
	//echo "Error with DB. Details: $ex";
	die();
}


?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>De Violín | Maestro</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/violinStudio.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    </head>

    <body>
        <nav class=" navbar navbar-expand-lg navbar-light bg-light "> <a class="navbar-brand" href="../index.php">De Violín</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item"> <a class="nav-link" href="teachers.php">Teacher Home <span class="sr-only">(current)</span></a> </li>
                    <li class="nav-item"><a class="nav-link" href="./philosophy.php">Philosophy</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="./events.php">Events</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="./resources.php">Resources</a> </li>
                </ul>
                <ul class="navbar-nav mt-2 mt-lg-0">
                    <li class="nav-item"> <a class="nav-link" href="../index.php">Studio Home</a> </li>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle primary-color" type="button" id="userInfoButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_SESSION["fullname"]?>
                        </button>
                        <div class="dropdown-menu primary-color" aria-labelledby="userInfoButton"> <a class="dropdown-item" href="updateUserInfoForm.php">Update Info</a> <a class="dropdown-item" href="signOut.php">Sign Out</a></div>
                        <!--                        -->
                    </div>
                </ul>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div id="updateOptions" data-children=".item">
                    <div class="item big-square">
                        <a data-toggle="collapse" data-parent="#updateOptions" href="#updateStudentProgress" aria-expanded="false" aria-controls="updateStudentProgress">
                            <h5 class="display-4">View Student Progress</h5> </a>
                        <div id="updateStudentProgress" class="collapse" role="tabpanel">
                            <p class="mb-3">
                                <?php                           
    foreach ($db->query('SELECT id, first_name, last_name, music_level FROM student') as $row)
{
    echo '<div class="railroad-border">';
        echo '<p class="mb-3">';
            echo '<strong>' .$row['first_name'] . " " . $row['last_name'] . "</strong> : Level - " . $row['music_level'];
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
                    <div class="item big-square">
                        <a data-toggle="collapse" data-parent="#updateOptions" href="#updateEvents" aria-expanded="false" aria-controls="updateOptions">
                            <h5 class="display-4">Create Events</h5> </a>
                        <div id="updateEvents" class="collapse" role="tabpanel">
                            <p class="mb-3"> </p>
                            <form method="post" action="createEvent.php">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Event Name</label>
                                    <input type="text" class="form-control" required id="eventName" name="eventName" placeholder="Event name"> </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Start Time</label>
                                    <input type="text" class="form-control" id="startTime" name="startTime" placeholder="HH:MM">
                                    <label for="exampleFormControlInput1">End Time</label>
                                    <input type="text" class="form-control" id="endTime" name="endTime" placeholder="HH:MM">
                                    <label for="monthSelect">Select Month</label>
                                    <select class="form-control" required id="monthSelect" name="month">
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
                                    <select class="form-control" required id="daySelect" name="day">
                                        <option value="1">1 </option>
                                        <option value="2">2 </option>
                                        <option value="3">3 </option>
                                        <option value="4">4 </option>
                                        <option value="5">5 </option>
                                        <option value="6">6 </option>
                                        <option value="7">7 </option>
                                        <option value="8">8 </option>
                                        <option value="9">9 </option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
                                        <option value="26">26</option>
                                        <option value="27">27</option>
                                        <option value="28">28</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="yearSelect">Select Year</label>
                                    <select class="form-control" required id="yearSelect" name="year">
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="eventDescription">Event Description</label>
                                    <textarea class="form-control" required id="eventDescription" rows="3" name="description"></textarea>
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