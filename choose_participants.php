
<?php
include "connection.php";
?>

<html>
<head>
  <title>Displaying MySQL Data in HTML Table</title>
  <style type="text/css">
  <meta charset="utf-8">

  </style>
</head>

<h1 align = "center">Choose Particepants</h1>
      <body>
        <form action = "add_persons.php" method = "POST" align = "center">
          <?php

          $sth2 = "SELECT person_id, first_name, last_name, team FROM Person WHERE person_id <> $ID;";
          $result1 = mysqli_query($connection, $sth2);
          $resulrcheck1 = mysqli_num_rows($result1);
          if ($resulrcheck1 > 0){
            while($row = mysqli_fetch_assoc($result1)){
              ?>
              <input type = "checkbox" name = "participant" value = "<?php echo $row['person_id']?>"> <?php echo $row['first_name']. " ". $row['last_name']. ", ". $row['team']?>
              <br>
              <?php
              }
            }
            ?>
            <br>
            <br>
            <button type = "submit" name = "submit">Add to Meeting</button>
            <br>
          </form>

      </body>
</html>
