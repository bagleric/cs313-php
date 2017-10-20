<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Form Submission</title>
</head>

<body>
    <div>Contact Information
        <div>
            <?php echo $_POST["name"];?>
        </div>
        <div>
            <?php echo "<a href='mailto:".$_POST["email"] . "?subject=PHP%20Message'>" . $_POST["email"] ."</a>";?> </div>
        <div>
            <?php echo "Major: " . $_POST["major"];?>
        </div>
        <div>
            <?php echo $_POST["name"] . " has visited: <br/>";
        $continent = $_POST["continent"];
        print_r($_POST['continent']) ?>
        </div>
        <?php echo $_POST["comments"]; ?>
    </div>
</body>

</html>