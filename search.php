<!Doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">

  <title>Search</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="dashboard.css" rel="stylesheet">
  <link href="custom.css" rel="stylesheet">

  <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
  <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
  <script src="assets/js/ie-emulation-modes-warning.js"></script>

  <?php
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
?>


  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body>
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.html">Chromebook Management Dashboard</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="index.html">Dashboard</a></li>
          <li><a href="#">Settings</a></li>
          <li><a href="#">Profile</a></li>
          <li><a href="#">Help</a></li>
        </ul>
        <form class="navbar-form navbar-right">
          <input type="text" class="form-control" placeholder="Search...">
        </form>
      </div>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-3 col-md-2 sidebar">

        <ul class="nav nav-sidebar">
          <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
          <li><a href="analytics.html">Analytics</a></li>
          <li><a href="export.html">Export</a></li>
        </ul>
        <ul class="nav nav-sidebar">
          <li><a href="manage.html">Manage</a></li>
          <li><a href="search.php">Search</a></li>
        </ul>
      </div>

      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "text-align: center; margin: auto; padding-bottom: 20px;">
            Chromebook Lookup </h1>


<!-- Wrapper that contains all the parts of the Chromebook search. This div
contains all of the fields that are required to look up a Chromebook -->
        <div class = "search-wrapper">

          <div class = "search-options">

            Search by
            <select id = "options" onchange="checkSearchParam()" onload="checkSearchParam()">
              <option value = "asset" onclick> Asset Tag </option>
              <option value = "pid"> Student PID </option>
              <option value = "room"> Room Number </option>
            </select>
          </div>

          <form method = "post" action = >
            <input type = "text" class = "custom-search" placeholder = "Search..." name = "chromebook" maxlength="4">
              <input type = "submit" class = "custom-search-button">
          </form>
        </div>
        <p id = "testpara"> Asset </p>
        <?php

          // validation after the form has been submitted
          if ($_POST) {
            $input = $_POST['chromebook'];
            $result = $conn->query("SELECT room FROM chromebooks WHERE asset = $input");
            $row = $result->fetch_assoc();
            echo "Here is your chromebook!\n";
            echo "It is in room " . $row["room"];
          }
        ?>

      </div>

    </div>

  </div>

<script src = "js/custom.js"></script>
</body>

</html>
