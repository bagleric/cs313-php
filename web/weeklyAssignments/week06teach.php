<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Scripture Topics</title>
</head>

<body>
    <?php 

    $dbUrl = getenv('DATABASE_URL');
    if (empty($dbUrl)) {
        $dbUrl = "postgres://postgres:2016Aprende@localhost:5432/postgres";
    }
    $dbopts = parse_url($dbUrl);

    $dbHost = $dbopts["host"];
    $dbPort = $dbopts["port"];
    $dbUser = $dbopts["user"];
    $dbPassword = $dbopts["pass"];
    $dbName = "postgres";

    try
    {
        $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
    }
    catch (PDOException $ex)
    {
      echo 'Error!: ' . $ex->getMessage();
      die();
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $book = testInput($_POST['book']);
        $chapter = testInput($_POST['chapter']);
        $verse = testInput($_POST['verse']);
        $content = testInput($_POST['content']);
        $topicList = $_POST['topic'];
        
        $insert_qry = $db->prepare('INSERT INTO scriptures (book, chapter, verse, content) VALUES (:book, :chapter, :verse, :content) ');
        $insert_qry->bindValue(':book', $book, PDO::PARAM_STR);
        $insert_qry->bindValue(':chapter', $chapter, PDO::PARAM_STR);
        $insert_qry->bindValue(':verse', $verse, PDO::PARAM_STR);
        $insert_qry->bindValue(':content', $content, PDO::PARAM_STR);
        $insert_qry->execute();
        
        $id = $db->lastInsertId('scriptures_id_seq');
        $insert_link = $db->prepare('INSERT INTO topic_link (scripture, topic) VALUES (:scripture, :topic) ');
        $insert_link->bindValue(':scripture', $id, PDO::PARAM_INT);

        foreach ($topicList as $topic){
            $insert_link->bindValue(':topic', $topic, PDO::PARAM_INT);
            $insert_link->execute();
       }
    }
    function testInput($data) {
        $data = trim($data);
        $data = stripslashes($data);   
        $data = htmlspecialchars($data);
        return $data;
    }
    
    ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label>Book</label>
            <input type='text' name='book'>
            <label>Chapter</label>
            <input type='text' name='chapter'>
            <label>Verse</label>
            <input type='text' name='verse'>
            <label>Content</label>
            <textarea name='content'></textarea>
            <?php
            foreach ($db->query('SELECT * FROM topic') as $row)
            {
                echo "<div><input type='checkbox' name='topic' value='" . $row['id'] . "'>" . $row['name'] . "</div>";
                
            }
?>
                <input type='submit' name='submit' value='submit'> </form>
</body>

</html>