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
    $input = $arg['chromebookQuery'];
    $result = $conn->query("SELECT * FROM chromebooks WHERE asset = $input");

  //  $row = $result->fetch_assoc();
    if ($conn->error || $result->num_rows == 0) {
      echo "Chromebook not found!";
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

    $input = $arg['chromebookQuery'];
    $result[] = array();
    $result = $conn->query("SELECT * FROM chromebooks WHERE room = $input");

    if($conn->error) {
      echo "ERROR";
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
      echo "<br>";
      echo "CHROMEBOOK ALREADY EXISTS";
      return -1;
    }

    $conn->query("INSERT INTO chromebooks (room, asset) VALUES ($room, $asset)");

    // Currently going to be adding Chromebook without serial, will add into later version
    echo "<br>";
    echo "END OF FUNCTION";
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

    $result = $conn->query("SELECT * FROM chromebooks WHERE asset = $chromebookAsset");

    if($result->num_rows == 0) {
      return false;
    }
    return true;
  }

  function formatTable($query) {
    echo "<table style=width:100% id=resultTable>";
    echo "<tr> <th> Room </th> <th> Asset Tag </th> </tr>";
    $rowCounter = 1;

    while($row = $query->fetch_assoc()) {
      $room = $row["room"];
      $asset = $row["asset"];

      echo "<tr data-toggle = 'modal' data-target = '#myModal' onclick= 'fillEditData($rowCounter)'> <td> $room </td> <td> $asset </td> </tr>";
      $rowCounter++;
    }
  }

  function updateDatabase($query) {
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
    $oldAsset = $query['originalAsset'];

    $conn->query("UPDATE chromebooks SET room = $room, asset = $asset WHERE asset = $oldAsset");
  }
 ?>
