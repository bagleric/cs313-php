<html>
<body>

<?php

// default Heroku Postgres configuration URL
$dbUrl = getenv('DATABASE_URL');

if (empty($dbUrl)) {
 // example localhost configuration URL with postgres username and a database called cs313db
 $dbUrl = "postgres://postgres:2016Aprende@localhost:5432/postgres";
}

$dbopts = parse_url($dbUrl);


$dbHost = $dbopts["host"];
$dbPort = $dbopts["port"];
$dbUser = $dbopts["user"];
$dbPassword = $dbopts["pass"];
$dbName = ltrim($dbopts["path"],'/');


try {
 $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
}
catch (PDOException $ex) {
 print "<p>error: $ex->getMessage() </p>\n\n";
 die();
}
    echo "<h1>Scripture Resources</h1><br/>";

    foreach ($db->query('SELECT * FROM scriptures') as $row)
{
    echo "<div>";
  echo "<b>" .$row['book'] . " " . $row['chapter'] . ":" . $row['verse']. "</b>-\"" . $row['content']. "\"";
    echo "</div>";
        echo"<br/>";
}

?>

</body>
</html>