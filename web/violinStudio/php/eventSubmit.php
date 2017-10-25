<?php
// get the data from the POST
$eventName = $_POST['eventName'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$month = $_POST['month'];
$day = $_POST['day'];
$year = $_POST['year'];
$preDescription = $_POST['description'];

echo "day=$day";
echo "month=$month";
echo "year=$year";


$eventDate = "$year-$month-$day"; 
$description = $startTime . '-' . $endTime . '<br/>' . $preDescription;


 echo "eventName=$eventName\n";
 echo "startTime-EndTime=$startTime - $endTime \n";
 echo "date=$eventDate\n";
 echo "description=$description\n";



// TODO put additional checks here to verify that all this data is actually provided
require("dbConnect.php");
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
    echo "/n trying to execute - $result";
    
}
catch (Exception $ex)
{
	// Please be aware that you don't want to output the Exception message in
	// a production environment
	echo "Error with DB. Details: $ex";
	die();
}
// finally, redirect them to a new page to actually show the topics
//header("Location: teachers.php");
echo "this is the database";
die(); // we always include a die after redirects. In this case, there would be no
       // harm if the user got the rest of the page, because there is nothing else
       // but in general, there could be things after here that we don't want them
       // to see.
?>