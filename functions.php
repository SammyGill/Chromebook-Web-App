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

    // Currently going to be adding Chromebook without serial, will add into later version
    
  }
 ?>
