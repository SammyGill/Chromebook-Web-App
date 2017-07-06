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
    $result = $conn->query("SELECT room FROM chromebooks WHERE asset = $input");
    $row = $result->fetch_assoc();
    if ($row == 0) {
      echo "Chromebook not found!";
    }
    else {
      echo "Here is your chromebook!\n";
      echo "It is in room " . $row["room"];
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

    $input = $arg['assetInputField'];
    $result[] = array();
    $result = $conn->query("SELECT asset FROM chromebooks WHERE room = $input");
      while ($row = $result->fetch_assoc()) {
        echo "ASSET " . $row["asset"];
        echo "<br>";
      }
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
 ?>
