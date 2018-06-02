
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

<body>
  <div>
    <h1 align = "center"> Book Meeting</h1>
    <p align = "center">Start by chosing a date as well as start and end time for your meeting. Then decide which meeting room you would like to book as well as
    persons to invite to the meeting. It is better to be safe than sorry, so to make sure that your meeting is booked we advice you to
    contact the it support until we have relised the next update. </p>
    <form action = "add_meeting.php" method = "POST" align = "center">

      <input type = "date" name = "date" max = "2020-12-31"  placeholder = "Date">
      <br>
      Start <input type="time" name = "start_time" max = "23:00" min = "<?php date("h:i")?>" placeholder = "Start Time">
      <br>
      End  <input type = "time" name = "end_time" max = "23:59" placeholder = "End Time">
      <br>
      <p><strong>Meeting Room</strong></p>

      <?php
      $sth1 = "SELECT room_id FROM Meeting_room;";
      $result1 = mysqli_query($connection, $sth1);
      $resulrcheck1 = mysqli_num_rows($result1);
      if ($resulrcheck1 > 0){
        while($row = mysqli_fetch_assoc($result1)){
      ?>

          <input type = "radio" name = "room" value = "<?php echo $row['room_id']?>"> <?php echo $row['room_id']?>

      <?php
          }
        }
      ?>

      <p><strong>Invite people to the meeting</strong></p>

      <?php
      $sth2 = "SELECT person_id, first_name, last_name, team FROM Person;";
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
        <button type = "submit" name = "submit">Book Meeting</button>
        <br>
      </form>
    </div>
    <div>
      <h1 align = "center">Cancel Meeting</h1>
      <form action = "cancel_meeting.php" method = "POST" align = "center">

        <input type = "date" name = "date" min = "2018-04-24" max = "2020-12-31"  placeholder = "Date" required>
        <br>
        <input type="time" name = "start_time" max = "23:00" min = "<?php date("h:i")?>" placeholder = "Start Time">
        <br>
        <input type = "time" name = "end_time" max = "23:59" placeholder = "End Time">
        <br>
        <p>Meeting Room</p>

        <?php
        $sth1 = "SELECT room_id FROM Meeting_room;";
        $result1 = mysqli_query($connection, $sth1);
        $resulrcheck1 = mysqli_num_rows($result1);
        if ($resulrcheck1 > 0){
          while($row = mysqli_fetch_assoc($result1)){
        ?>

            <input type = "radio" name = "room" value = "<?php echo $row['room_id']?>"> <?php echo $row['room_id']?>

        <?php
            }
          }
        ?>

        <br>
        <button type = "submit" name = "submit">Cancel Meeting</button>
        <br>
      </form>
    </div>
  </body>
</html>
