<?php
  function queryDatabase($arg) {
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
    $input = $arg['searchBarInput'];
    $result = $conn->query("SELECT * FROM chromebooks WHERE asset = $input");

  //  $row = $result->fetch_assoc();
    if ($conn->error || $result->num_rows == 0) {
      echo("Chromebook not found!");
    }
    else {
      formatTable($result);
    }
  }

  function queryDatabaseRoom($arg) {
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

    $school = $arg['school-options'];
    $room = $arg[$school . '-rooms'];
    $result[] = array();

    if($room == "*") {
      $result = $conn->query("SELECT * FROM chromebooks
                              WHERE school = \"$school\"");
    }
    else {
      $result = $conn->query("SELECT * FROM chromebooks
                              WHERE school = \"$school\" AND room = $room");
    }

    if($conn->error) {
      echo("ERROR");
      return -1;
    }
    formatTable($result);
  }

  function quickAdd($chromebook) {
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

    $asset = $chromebook['assetInputField'];
    $serial = $chromebook['serialInputField'];
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
    echo("END OF FUNCTION");
  }

  function chromebookExists($chromebookAsset) {
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

    $result = $conn->query("SELECT * FROM chromebooks WHERE
                            asset = $chromebookAsset");

    if($result->num_rows == 0) {
      return false;
    }
    return true;
  }

  function formatTable($query) {
    $modelString = "model";
    $assetString = "asset";
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
                onclick= 'fillEditData($rowCounter)'> <td class=location>
                $school $room </td> <td class=asset> $asset </td>
                <td class=serial> $serial </td>
                <td class='model'>$model</td> <td class=status> $status </td> </tr>");
      $rowCounter++;
    }
  }

  function updateChromebook($query) {
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
    $room = $query['editRoomField'];
    $asset = $query['editAssetField'];
    $serial = $query['editSerialField'];
    $model = $query['edit-model-select'];
    $status = $query['edit-physical-status-select'];
    $oldAsset = $query['originalAsset'];

    $conn->query("UPDATE chromebooks SET room = $room, asset = $asset,
                  serial_number =\"$serial\", model=\"$model\",
                  Physical_Status=\"$status\" WHERE asset = $oldAsset");
  }

  function deleteChromebook($query) {
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
    $asset = $query['originalAsset'];
    $conn->query("DELETE FROM chromebooks WHERE asset = $asset");
  }


  function printRooms() {
    $schools = array("marshall", "fremont", "malaga");
    $roomCount = 1;
    for($schoolCount = 0; $schoolCount < count($schools); $schoolCount++) {

      echo("<select id='$schools[$schoolCount]-rooms'
                    name='$schools[$schoolCount]-rooms'>");
      echo("<option value='*'> All </option>");

      for($roomCount = 1; $roomCount < 26; $roomCount++) {
        echo("<option value='$roomCount'> $roomCount </option>");
      }
      echo("</select>");
    }
  }

 ?>
