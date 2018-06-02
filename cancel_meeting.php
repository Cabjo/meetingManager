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
            <h1 align = "center">Cancel Meeting</h1>
            <form action = "delete_meeting.php" method = "POST" align = "center">

                <?php
                $ID = mysqli_real_escape_string($connection, $_POST['ID']);
                $sth1 = "SELECT * FROM Meeting WHERE person_id = '$ID';";
                $result1 = mysqli_query($connection, $sth1);
                $resulrcheck1 = mysqli_num_rows($result1);
                if ($resulrcheck1 > 0){
                    while($row = mysqli_fetch_assoc($result1)){
                        ?>

                        <input type = "radio" name = "meeting" value = "<?php echo $row['meeting_id']?>">
                        <?php ?> Date: <?PHP echo $row['date'] ?> <br> <?PHP echo $row['start_time']?> To <?PHP echo $row['end_time']?>
                        <br>
                        Room: <?PHP echo $row['room_id']?>
                        <br>
                        <br>

                        <?php
                    }
                    ?>
                    <br>
                    <button type = "submit" name = "submit">Cancel Meeting</button>
                    <br>
                    <?PHP
                } else {
                    ?>
                    <p>You have no meetings to cancel</p>
                    <button type="submit" formaction="index.php" name = "submit">Go Back</button>

                    <?php
                }
                ?>
            </form>
        </div>
    </body>
</html>
