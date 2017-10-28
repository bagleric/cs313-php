<?php
require("dbconnect.php");
$db = get_db();
session_start();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/violinStudio.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light "> <a class="navbar-brand" href="../index.php">De Violín</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active"> <a class="nav-link" href="../index.php">Home <span class="sr-only">(current)</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" href="./philosophy.php">Philosophy</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="./events.php">Events</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="./resources.php">Resources</a> </li>
                </ul>
                <ul class="navbar-nav mt-2 mt-lg-0">
                    <li class="nav-item navbar-right"> <a class="nav-link" href="signIn.php">Sign In</a> </li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <h5 class="display-4">Upcoming Events</h5> </div>
        </div>
        <?php 
             try
{
	// prepare the statement
	$statement = $db->prepare('SELECT id, name, event_date, description FROM studio_events');
	$statement->execute();
	// Go through each result
    $count = 0;
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
        $count++;
    echo '<div class="col-md-5 big-square"><p><strong>' . $row['name']. ' - ' . $row['event_date'] . '</strong></p><p>' . $row['description']. '</p>';
        
        if($_SESSION["authenticated"]==true){
            echo '<form method="post" action="deleteEvent.php"><div><input type="text" class="form-control invisible" id="event'. $row['id'] . '" name="event" placeholder="'. $row['id'] . '" value="'. $row['id'] . '"/></div><button type="submit" class="btn primary-color">Delete</button></form></div>';
            
            
        }else{
            echo '</div>';
        }
	}
    if($count == 0){
        echo '<div class="big-square"><h4>There are no upcoming events.</h4></div>';
    }
}
catch (PDOException $ex)
{
	//echo "Error with DB. Details: $ex";
	die();
}
?>
    </body>

    </html>