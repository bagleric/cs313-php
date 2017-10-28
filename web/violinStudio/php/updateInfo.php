<?php 
session_start();
    require("dbconnect.php");
    $db = get_db();
    try{
        
        $last_name = $_POST['lastName'];
        $first_name = $_POST['firstName'];
        $email = $_SESSION["email"];
        $query = 'UPDATE teacher SET first_name = :first_name, last_name = :last_name WHERE email = :email';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':first_name', $first_name);
        $statement->bindValue(':last_name', $last_name);
        $result = $statement->execute();
        
        if ($result){
            $row = $statement->fetch();
            $_SESSION["fullname"] = $first_name . " " . $last_name;
            $_SESSION["email"] = $email;
            header('Location: teachers.php');
            die();
        }
}
catch (Exception $ex)
{
	//echo "Error with DB. Details: $ex";
	die();
}

?>