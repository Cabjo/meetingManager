<?php
/**
 * Created by IntelliJ IDEA.
 * User: CamillaBjorn
 * Date: 2018-04-25
 * Time: 03:12
 */

include "connection.php";

$ID = mysqli_real_escape_string($connection, $_POST['ID']);
$date = mysqli_real_escape_string($connection, $_POST['date']);
$s_time = mysqli_real_escape_string($connection, $_POST['start_time']);
$e_time = mysqli_real_escape_string($connection, $_POST['end_time']);
$room = $_POST['room'];
//$participant_array = $_POST['participant']; // KOLLA UPP DENNA!!!

//Returns the timedifference in minutes
function minute_diff($time1, $time2) {
    $s_array = explode(":",$time1);     //Convert the timesting to an array
    $e_array = explode(":",$time2);
    $minutes = ($e_array[0] - $s_array[0])*60 + ($e_array[1] - $s_array[1]);    //Calculate minutes
    return $minutes;
}

//Get the team
$q1 = mysqli_query($connection, "SELECT team FROM Person WHERE person_id = '$ID';");
$team = mysqli_fetch_assoc($q1)['team'];

//The am price and the pm price for the room
$q2 = mysqli_query($connection, "SELECT am_price FROM Meeting_room WHERE room_id = '$room';");
$am_price = mysqli_fetch_assoc($q2)['am_price']/60;

$q3 = mysqli_query($connection, "SELECT pm_price FROM Meeting_room WHERE room_id = '$room';");
$pm_price = mysqli_fetch_assoc($q3)['pm_price']/60;

$q5 = mysqli_query($connection, "SELECT * FROM `Person` WHERE person_id = '$ID';");
$is_id = mysqli_num_rows($q5);

$today_date = date("Y-m-d");
$today_time = date("h:i:s");

$today_date_num = str_replace("-", "", $today_date);
$date_num = str_replace("-", "", $date);



if ($today_date_num - $date_num < 0) {
//The person booking is valid and the person belongs to a team
    if ($team != NULL) {

        //Check if there is any other meetings in the same room at the same time...
        $q0 = mysqli_query($connection, "SELECT * FROM Meeting WHERE (room_id = '$room' and date = '$date') and ((start_time >= '$s_time' and end_time <= '$e_time') or (start_time < '$s_time' and end_time > '$s_time') or (start_time < '$e_time' and end_time > '$e_time'));" );
        $is_other_meeting = mysqli_num_rows($q0);

        if ($is_other_meeting === 0) {

            //Calculates the cost depending on the time
            if ($s_time < $e_time) {
                if ($e_time <= "1200" and $s_time < "1200") {
                    $cost = minute_diff($s_time, $e_time) * $am_price;
                    //echo $am_price . "\n";
                } elseif ($s_time >= "1200" and $e_time > "1200") {
                    $cost = minute_diff($s_time, $e_time) * $pm_price;
                    //echo $pm_price . "\n";
                } else {
                    $am_cost = minute_diff($s_time, "12:00") * $am_price;
                    $pm_cost = minute_diff("12:00", $e_time) * $pm_price;
                    //echo $pm_cost . "\n";
                    //echo $am_cost . "\n";
                    $cost = ($am_cost + $pm_cost);
                }
                //Calculates the cost depending on the facilities
                $q4 = mysqli_query($connection, "SELECT SUM(price) AS price FROM Facility JOIN Facility_In_Room ON Facility.facility_id = Facility_In_Room.facility_id WHERE room_id = '$room';");
                $facility_price = mysqli_fetch_assoc($q4)['price'];
                $cost = $cost + $facility_price;

                //Insert new meeting
                $sth = "INSERT INTO Meeting (room_id, cost, date, start_time, end_time, team, person_id) VALUES ('$room', '$cost', '$date ', '$s_time','$e_time', '$team', '$ID');";
                mysqli_query($connection, $sth);

                header("Location: chose_participants.php?booking=success");
                exit();
            }
            header("Location: index.php?booking=endtimebeforestarttime");
            exit();
        }
        header("Location: index.php?booking=roomattimenotavailable");
        exit();
    }
    header("Location: index.php?booking=IDnotvalid");
    exit();
}
header("Location: index.php?booking=datenotvalid");
exit();