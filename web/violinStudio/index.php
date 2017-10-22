<?php
require("./php/dbconnect.php");
$db = get_db();
session_start();

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>De Violín</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <link rel="stylesheet" href="css/violinStudio.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light "> <a class="navbar-brand" href="index.php">De Violín</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active"> <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" href="./php/philosophy.php">Philosophy</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="./php/events.php">Events</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="./php/resources.php">Resources</a> </li>
                </ul>
                <ul class="navbar-nav mt-2 mt-lg-0">
                    <li class="nav-item navbar-right"> <a class="nav-link" href="./php/signIn.php">Sign In</a> </li>
                </ul>
            </div>
        </nav>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner banner" role="listbox">
                <div class="carousel-item active "> <img class="d-block img-fluid  banner-img" src="./images/makingViolins.jpg" alt="Making a Violin"> </div>
                <div class="carousel-item "> <img class="d-block img-fluid  banner-img" src="./images/onlyViolin.jpg" alt="Violin"> </div>
                <div class="carousel-item "> <img class="d-block img-fluid  banner-img" src="./images/violinDrawing.jpg" alt="Drawing of Violin"> </div>
                <div class="carousel-item "> <img class="d-block img-fluid  banner-img" src="./images/violinWithScore.jpg" alt="Violin with Music Score"> </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
        </div>
        <div class="container">
            <div class="row d-flex justify-content-center">
                
                    <div id="philosophy" class="col-md-5 big-square">
                       <a href="php/philosophy.php">
                        <h1 class="display-4">Philosophy</h1>
                        <p>This is where you will find the teaching Philosophy for the Violin Studio! A philosophy is essential because it gives the basis of how we teach and why we teach. It is what inspires us, how we hope to inspire others and how you too can be inspired. </p>
                        </a>
                    </div>
                
                
                    <div id="events" class="col-md-5 big-square">
                       <a href="php/events.php">
                        <h1 class="display-4">Events</h1>
                        <p>This is where you will find the teaching Events for the Violin Studio!</p>
                        <?php 
                    try
{
	// prepare the statement
	$statement = $db->prepare('SELECT name, event_date, description FROM studio_events');
	$statement->execute();
	// Go through each result
	$x= 0;
	while (($x < 3) && ($row = $statement->fetch(PDO::FETCH_ASSOC)))
	{
    $x = $x + 1;
    echo '<p><strong>' . $row['name']. ' - ' . $row['event_date'] . '</strong></p> <p>' . $row['description'] . '</p>';
		
	}
}
catch (PDOException $ex)
{
	echo "Error with DB. Details: $ex";
	die();
}
                    ?></a>
                    </div>
                
                
                    <div id="resources" class="col-md-5 big-square">
                       <a href="php/resources.php">
                        <h1 class="display-4">Resources</h1>
                        <p>This is where you will find the teaching Resources for the Violin Studio!</p>
                        <?php 
                    try
{
	// prepare the statement
	$statement = $db->prepare('SELECT name, resource_url, description FROM studio_resources');
	$statement->execute();
	// Go through each result
	$x= 0;
	while (($x < 2) && ($row = $statement->fetch(PDO::FETCH_ASSOC)))
	{
    $x = $x + 1;
    echo '<li"> <a class="primary-text" href="'. $row['resource_url'] . '"><p>'. '<strong>' . $row['name'] . '</strong></p> <p>' . $row['description'] . '</p></a> </li>';
		
	}
}
catch (PDOException $ex)
{
	echo "Error with DB. Details: $ex";
	die();
}
                    ?> </a>
                    </div>
               
                <!--
                <div id="currentStudent" class="col-md-5 big-square">
                    <h1 class="display-4">Current Student</h1></div>
--></div>
            <div class="row"> </div>
        </div>
    </body>

    </html>