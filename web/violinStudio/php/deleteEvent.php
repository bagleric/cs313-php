<?php 
session_start();
$id = $_POST['event'];

    require("dbconnect.php");
    $db = get_db();
    try{
        
        $last_name = $_POST['lastName'];
        $first_name = $_POST['firstName'];
        $email = $_SESSION["email"];
        $query = 'DELETE FROM studio_events WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $result = $statement->execute();
        
        if ($result){
            $row = $statement->fetch();
            header('Location: events.php');
        }
}
catch (Exception $ex)
{
	echo "Error with DB. Details: $ex";
	die();
}

?>