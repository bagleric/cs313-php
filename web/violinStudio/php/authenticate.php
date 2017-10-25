<?php 
session_start();

if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] == true){
    //send them to the teacher page.
    header("Location: teachers.php");
}

else if (!isset($_SESSION["authenticated"])){
    $email = $_POST["email"];
    $password = $_POST["pass"];
    //check to see if they are null. If so send back to login page. 
    if($email == null || $password == null) {
        header("Location: signIn.php");
        die();
    }elseif($email != null && $password != null){
        require("dbconnect.php");
        $db = get_db();
        
        $query = 'SELECT email, user_password FROM teacher WHERE email = :email';
        
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        
        $result = $statement->execute();
        if ($result){
            $row = $statement->fetch();
            echo "password $password";
            $dbPass = $row['user_password'];
            if(password_verify($password, $dbPass)){
                $_SESSION["authenticated"] = true;
                $_SESSION["email"] = $email;
                header("Location: teachers.php");
                die();
            }else{
                echo 'it failed';
                die();
            }
        }
    }
}


?>