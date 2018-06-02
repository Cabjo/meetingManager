<?php
include "connection.php";

$meeting = $_POST['meeting'];

//delete meeting
$delete = mysqli_query($connection, "DELETE FROM Meeting WHERE meeting_id = '$meeting';");

header("Location: index.php?cancellation=success");


