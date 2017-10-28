<?php
require ('dbconnect.php');
$db = get_db();    
session_start();
 
// get the data from the POST
$firstName =$_POST["firstName"];
$lastName = $_POST["lastName"];
$username = $_POST["email"];
$password = $_POST["pass"];

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

if(password_verify($password, $passwordHash)){
//    echo "SUCCESS";
    
}

try
{
    
//    $query1 = 'SELECT email FROM teacher WHERE email = :email';
//    $checkEmail = $db->prepare($query1);
//    
//    $checkEmail->bindValue(':email',$username);
//    $result = $checkEmail->execute();
//    echo "Result: $result";
//    
	// Add the Scripture
	// We do this by preparing the query with placeholder values
	$query = 'INSERT INTO teacher(email, first_name, last_name, user_password) VALUES (:email, :first_name, :last_name, :password)';
	$statement = $db->prepare($query);
	
 
    
    // Now we bind the values to the placeholders. This does some nice things
	// including sanitizing the input with regard to sql commands.
	$statement->bindValue(':email', $username);
	$statement->bindValue(':first_name', $firstName);
	$statement->bindValue(':last_name', $lastName);
	$statement->bindValue(':password', $passwordHash);
	$result = $statement->execute();
}
catch (Exception $ex)
{
	header("Location:error.php");
	die();
}
header("Location:signIn.php");
die();
?>