<html>
    <body>
        <?php
try
{
  $user = 'bagleric';
  $password = '2016Aprende';
  $db = new PDO('pgsql:host=127.0.0.1;dbname=postgres', $user, $password);
}
catch (PDOException $ex)
{
  echo 'Error!: ' . $ex->getMessage();
  die();
}
   

foreach ($db->query('SELECT * FROM students') as $row)
{
  echo 'first name: ' . $row['first_name'];
  echo ' last name: ' . $row['last_name'];
  echo '<br/>';
}
?>

    </body>
</html>