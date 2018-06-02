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
    <form action = "add_meeting.php" method = "POST" align = "center">

      <input type = "text" name = "ID" placeholder = "Person ID">
      <br>
      Date: <input type = "date" name = "date" max = "2020-12-31"  placeholder = "Date">
      <br>
      Start Time: <input type="time" name = "start_time" max = "23:00" min = "<?php date("h:i")?>" placeholder = "Start Time">
      <br>
      End Time: <input type = "time" name = "end_time" max = "23:59" placeholder = "End Time">
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

        <br>
        <button type = "submit" name = "submit">Book Meeting</button>
        <br>
      </form>

      <?PHP
      // Här börjar Facility tabellen
      ?>
      <head>
          <title>Displaying MySQL Data in HTML Table</title>
          <style type="text/css">
              body {
                  font-size: 15px;
                  color: #343d44;
                  font-family: "segoe-ui", "open-sans", tahoma, arial;
                  padding: 1;
                  margin: 0;
              }
              table {
                  margin: auto;
                  font-family: "Lucida Sans Unicode", "Lucida Grande", "Segoe Ui";
                  font-size: 12px;
              }
              table td {
                  transition: all .5s;
              }

              /* Table */
              .data-table {
                  border-collapse: collapse;
                  font-size: 12px;
                  min-width: 200px;
              }

              .data-table th,
              .data-table td {
                  border: 1px solid #e1edff;
                  padding: 5px 17px;
              }


              /* Table Header */
              .data-table thead th {
                  background-color: #508abb;
                  color: #FFFFFF;
                  border-color: #6ea1cc !important;
                  text-transform: uppercase;
              }

              /* Table Body */
              .data-table tbody td {
                  color: #353535;
              }

              .data-table tbody td:first-child,
              .data-table tbody td:nth-child(4),
              .data-table tbody td:last-child {
                  text-align: right;
              }

              .data-table tbody tr:nth-child(odd) td {
                  background-color: #f4fbff;
              }


              .data-table tbody tr:hover td {
                  background-color: #ffffa2;
                  border-color: #ffff0f;
              }

              <?php

              ?>
          </style>
      </head>

      <tbody>
      <table class="data-table">
          <p align = "center"><strong>Meeting Room Information</strong></p>
          <thead>
          <tr>
              <td>Room Number</td>
              <td>Facility</td>
          </tr>
          </thead>
          <tbody>
          <?php
          $sth = "SELECT room_id, item FROM Facility JOIN Facility_In_Room ON Facility.facility_id=Facility_In_Room.facility_id ORDER BY room_id";
          $res = $connection->query($sth);

          if ($res->num_rows>0){
              while($row=$res->fetch_assoc()){
                  ?>
                  <tr>
                      <td><?php echo $row['room_id']?></td>
                      <td><?php echo $row['item']?></td>
                  </tr>
                  <?php
              }
          }
          ?>
      </table>
      </tbody>

      <?php
      // Här slutar Facility tabellen
      ?>
    </div>
    <div>
      <h1 align = "center">Cancel Meeting</h1>
        <form action = "cancel_meeting.php" method = "POST" align = "center">
        <input type = "text" name = "ID" placeholder = "Person ID">

        <br>
        <button type = "submit" name = "submit">Cancel Meeting</button>
        <br>
      </form>
    </div>
  </body>
</html>
