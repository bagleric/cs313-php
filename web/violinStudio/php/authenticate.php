<?php
session_start();
require ("dbconnect.php");
$db = get_db();    
 
// get the data from the POST
$firstName =$_POST['firstName'];
$lastName = $_POST['lastName'];
$username = $_POST['email'];
$password = $_POST['pass'];

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

if(password_verify($password, $passwordHash)){
    echo "SUCCESS";
    
}

try
{
	// Add the Scripture
	// We do this by preparing the query with placeholder values
	$query = ' INSERT INTO teacher(email, first_name, last_name, user_password) VALUES (:email, :first_name, :last_name, :password)';
	$statement = $db->prepare($query);
	
    
    
    // Now we bind the values to the placeholders. This does some nice things
	// including sanitizing the input with regard to sql commands.
	$statement->bindValue(':email', $username);
	$statement->bindValue(':first_name', $firstName);
	$statement->bindValue(':last_name', $lastName);
	$statement->bindValue(':password', $passwordHash);
	$statement->execute();
    
}
catch (Exception $ex)
{
	// Please be aware that you don't want to output the Exception message in
	// a production environment
	echo "Error with DB. Details: $ex";
	die();
}
// finally, redirect them to a new page to actually show the topics
 // we always include a die after redirects. In this case, there would be no
       // harm if the user got the rest of the page, because there is nothing else
       // but in general, there could be things after here that we don't want them
       // to see.
header('signIn.php');


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
        <div class="row d-flex justify-content-center">
            <div>
                <form method="post" action="teachers.php">
                    <div class="form-group">
                        <label for="inputEmail">Email address</label>
                        <input type="email" class="form-control" id="inputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter email"> <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> </div>
                    <div class="form-group">
                        <label for="inputPassword">Password</label>
                        <input type="password" class="form-control" id="inputPassword" name="pass" placeholder="Password"> </div>
                    <button type="submit" class="btn primary-color">Sign In</button>
                </form>
            </div>
        </div>
    </body>

    </html>