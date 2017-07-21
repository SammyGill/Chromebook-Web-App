<?php

  function getConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "chromebookapplication";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
  }

  function getChromebook($arg) {
    $conn = getConnection();

    $input = $arg["searchBarInput"];
    $result = $conn->query("SELECT locations.School, locations.Room, chromebooks.Asset, chromebooks.Serial_Number, chromebooks.Model, chromebooks.Physical_Status, chromebooks.Assignment_Status FROM locations INNER JOIN chromebooks ON chromebooks.asset=locations.asset WHERE chromebooks.asset = $input");

    if ($conn->error || $result->num_rows == 0) {
      echo("Chromebook not found!");
    }
    else {
      formatTable($result);
    }
  }

  function getChromebookRoom($arg) {
    $conn = getConnection();

    $school = $arg["school-options"];
    $room = $arg[$school . "-rooms"];

    if($room == "*") {
      $result = $conn->query("SELECT locations.School, locations.Room, chromebooks.Asset, chromebooks.Serial_Number, chromebooks.Model, chromebooks.Physical_Status, chromebooks.Assignment_Status FROM locations INNER JOIN chromebooks ON chromebooks.asset=locations.asset
                              WHERE locations.School = \"$school\"");
    }
    else {
      $result = $conn->query("SELECT locations.School, locations.Room, chromebooks.Asset, chromebooks.Serial_Number, chromebooks.Model, chromebooks.Physical_Status, chromebooks.Assignment_Status FROM locations INNER JOIN chromebooks ON chromebooks.asset=locations.asset
                              WHERE locations.School = \"$school\" AND locations.Room = $room");
    }

    if($conn->error) {
      echo("ERROR");
      return -1;
    }

    formatTable($result);
  }

  function getChromebookRepair() {
    $conn = getConnection();

    $result = $conn->query("SELECT * FROM chromebooks WHERE Physical_Status = 'Damaged'");

    formatTableRepair($result);
  }

  function getChromebooksUnassigned() {
    $conn = getConnection();
    $result = $conn->query("SELECT * FROM chromebooks WHERE Assignment_Status = 'Unassigned'");
    formatTableRepair($result);
  }

  function quickAdd($chromebook) {
    $conn = getConnection();

    $asset = $chromebook["edit-asset-field"];
    $serial = $chromebook["edit-serial-field"];
    $room = 0;

    if(chromebookExists($asset)) {
      echo("<br>");
      echo("CHROMEBOOK ALREADY EXISTS");
      return -1;
    }

    $conn->query("INSERT INTO chromebooks (room, asset)
                  VALUES ($room, $asset)");


    // Currently going to be adding Chromebook without serial, will add into later version
    echo("<br>");
    echo("CHROMEBOOK SUCCESSFULLY ADDED");
  }

  function chromebookExists($chromebookAsset) {
    $conn = getConnection();

    $result = $conn->query("SELECT * FROM chromebooks WHERE
                         asset = $chromebookAsset");
    return $result->num_rows;
  }

  function formatTable($query) {
    echo("<table style=width:100% id=resultTable>");
    echo("<tr>
            <th onclick='sortTable(\"location\")'> School + Room </th>
            <th onclick='sortTable(\"asset\")'> Asset Tag </th>
            <th onclick='sortTable(\"serial\")'> Serial Number </th>
            <th onclick='sortTable(\"model\")'> Model </th>
            <th onclick='sortTable(\"status\")'> Physical Status </th>
          </tr>");

    $rowCounter = 1;

    while($row = $query->fetch_assoc()) {
      $room = $row["Room"];
      $asset = $row["Asset"];
      $school = $row["School"];
      $serial = $row["Serial_Number"];
      $status = $row["Physical_Status"];
      $model = $row["Model"];

      echo("<tr data-toggle = 'modal' data-target = '#myModal'
                onclick= 'fillEditData(\"$school\", $room, $asset, \"$serial\",
                                       \"$model\", \"$status\")'>

              <td class=location>$school $room</td>
              <td class=asset> $asset </td>
              <td class=serial> $serial </td>
              <td class='model'>$model</td>
              <td class=status>$status</td>

            </tr>");
      $rowCounter++;
    }
  }

  function formatTableRepair($query) {
    echo("<table style=width:100% id=resultTable>");
    echo("<tr>
            <th onclick='sortTable(\"location\")'> School + Room </th>
            <th onclick='sortTable(\"asset\")'> Asset Tag </th>
            <th onclick='sortTable(\"serial\")'> Serial Number </th>
            <th onclick='sortTable(\"model\")'> Model </th>
            <th onclick='sortTable(\"status\")'> Physical Status </th>
          </tr>");

    $rowCounter = 1;

    while($row = $query->fetch_assoc()) {
      $room = $row["Room"];
      $asset = $row["Asset"];
      $school = $row["School"];
      $serial = $row["Serial_Number"];
      $status = $row["Physical_Status"];
      $model = $row["Model"];

      echo("<tr data-toggle = 'modal' data-target = '#myModal'>

              <td class=location>$school $room</td>
              <td class=asset> $asset </td>
              <td class=serial> $serial </td>
              <td class='model'>$model</td>
              <td class=status>$status</td>

            </tr>");
      $rowCounter++;
    }
  }



  function updateChromebook($query) {
    $conn = getConnection();

    $room = $query["edit-room-field"];
    $asset = $query["edit-asset-field"];
    $serial = $query["edit-serial-field"];
    $model = $query["edit-model-select"];
    $status = $query["edit-physical-status-select"];
    $oldAsset = $query["original-asset"];

    $conn->query("UPDATE chromebooks SET room = $room, asset = $asset,
                  serial_number =\"$serial\", model=\"$model\",
                  Physical_Status=\"$status\" WHERE asset = $oldAsset");
  }

  function deleteChromebook($query) {
    $conn = getConnection();

    $asset = $query["original-asset"];
    $conn->query("DELETE FROM chromebooks WHERE asset = $asset");
  }


  function printRooms($toggleAllOption) {
    $schools = array("marshall", "fremont", "malaga");
    $roomCount = 1;
    for($schoolCount = 0; $schoolCount < count($schools); $schoolCount++) {
      echo("<select id='$schools[$schoolCount]-rooms'
                    name='$schools[$schoolCount]-rooms') class='rooms'>");
      if($toggleAllOption) {
        echo("<option value='*'> All </option>");
      }
      for($roomCount = 1; $roomCount < 26; $roomCount++) {
        echo("<option value='$roomCount'> $roomCount </option>");
      }
      echo("</select>");
    }
  }

  function addChromebook($chromebookData) {
    $conn = getConnection();

    $asset = $chromebookData["edit-asset-field"];
    $serial = $chromebookData["edit-serial-field"];
    $model = $chromebookData["edit-model-select"];
    $school = $chromebookData["school-options"];
    $room = $chromebookData["$school-rooms"];
    $status = $chromebookData["edit-physical-status-select"];
    $assignment = $chromebookData["edit-assignment-status-select"];
    $student = -1;

    if($room == "student") {
      $room = 0;
    }

    if("$assignment" == "assigned") {
      $student = $chromebookData["student-id"];
    }

    echo($student);

    if($conn->query("INSERT INTO chromebooks (School, Room, Asset, Serial_Number, Model, Physical_Status, Assignment_Status) VALUES (\"$school\", $room, $asset, \"$serial\", \"$model\", \"$status\", \"$assignment\")")) {
      echo("CHROME ADD SUCCESSFUL");
    }
    else {
      echo("ERROR ADDING CHROMEBOOK");
      echo($conn->error);
      echo("<br>");
      echo("\"$school\", $room, $asset, \"$serial\", \"$model\", \"$status\", \"$assignment\"");
    }
  }

 ?>
