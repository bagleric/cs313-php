<?php
// get the data from the POST
$eventName = $_POST['eventName'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$month = $_POST['month'];
$day = $_POST['day'];
$year = $_POST['year'];
$preDescription = $_POST['description'];

$eventDate = "$year-$month-$day"; 
$description = $startTime . '-' . $endTime . '<br/>' . $preDescription;

require("dbconnect.php");
$db = get_db();

try
{
	// Add the Scripture
	// We do this by preparing the query with placeholder values
	$query = 'INSERT INTO studio_events(name, event_date, description) VALUES (:name, :event_date, :description)';
	$statement = $db->prepare($query);
	// Now we bind the values to the placeholders. This does some nice things
	// including sanitizing the input with regard to sql commands.
	$statement->bindValue(':name', $eventName);
	$statement->bindValue(':event_date', $eventDate);
	$statement->bindValue(':description', $description);
	$result = $statement->execute();
   
}
catch (Exception $ex)
{
    //echo "Error with DB. Details: $ex";
	die();
}
header("Location: teachers.php");
die(); 
?>