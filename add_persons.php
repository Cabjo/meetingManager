<html>
<br>

<?php
include "connection.php";
echo "<br />";
echo "du har lagt in; ";


$participant_array = $_POST['participant'];

foreach ($participant_array as $participant){
  echo "<br />";


  $q1 = mysqli_query($connection, "SELECT meeting_id FROM Meeting WHERE Meeting_id=(select MAX(meeting_id) from Meeting);");
  $meeting_id = mysqli_fetch_assoc($q1)['meeting_id'];

  $q2 = mysqli_query($connection, "SELECT first_name FROM Person WHERE person_id = '$participant';");
  $first_name = mysqli_fetch_assoc($q2)['first_name'];

  $q3 = mysqli_query($connection, "SELECT last_name FROM Person WHERE person_id = '$participant';");
  $last_name = mysqli_fetch_assoc($q3)['last_name'];

  $sth = "INSERT INTO Participant (person_id, first_name, last_name, meeting_id) VALUES ('$participant', '$first_name', '$last_name', '$meeting_id');";
  mysqli_query($connection, $sth);
/*
  echo "Person_id: ".$participant."<br />";
  echo "Name: ".$first_name. " ". $last_name."<br />";
  echo "Meeting_id: ".$meeting_id."<br />";
  echo "<br />";
*/
//header("Location: index.php?signup=success");
}
header("Location: index.php?invitation=success");
exit();
?>

<html>