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

  <title>Add Chromebook</title>

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

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <?php include 'functions.php' ?>
</head>

<body class="quick-add" onload="disableInsuranceButton()">
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

  <div class="container">
    <div class="row">
      <div class="col-sm-3 col-md-2 sidebar">

        <ul class="nav nav-sidebar">
          <li><a href="overview.html">Overview <span class="sr-only">(current)</span></a></li>
          <li><a href="analytics.html">Analytics</a></li>
          <li><a href="export.html">Export</a></li>
        </ul>
        <ul class="nav nav-sidebar">
          <li><a href="manage.html">Manage</a></li>
          <li><a href="search.php">Search</a></li>
          <li class="active"><a href ="quick-add.php"> Add Chromebook </a></li>
          <li> <a href="repairs.php"> Repairs </a></li>
          <li> <a href="assign.php"> Assign Chromebooks </a></li>
        </ul>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "text-align: center; margin: auto; padding-bottom: 20px;">
            Add Chromebook </h1>
      </div>
    </div>

  <form method = "post" action =>
    <div class="row top-row">

      <div class="col-md-12 col-md-offset-1" style="text-align:center;">
        <input type="text" name="asset-field" placeholder="Asset Tag">
        <input type="text" name="serial-field" placeholder="Serial Number">

        <div class=edit-data-input>
          <label> Model </label>
          <br>
          <select name="model-select" id="edit-model-select">
            <option value="asus"> Asus </option>
            <option value="Dell Chromebook 11 (3120)"> Dell </option>
            <option value="Samsung Chromebook"> Samsung </option>
          </select>
        </div>

      </div>
    </div>

    <div class="row">
      <div class="col-md-12 col-md-offset-1" style="text-align:center; padding-bottom:10px;">


      <div class="edit-data-input">
        <label> School </label>
        <br>
        <select id="school-options" name="school-options"
                onchange="changeCurrentRooms(); disableInsuranceButton();">
          <option value="marshall"> Marshall </option>
          <option value="fremont"> Fremont </option>
          <option value="malaga"> Malaga </option>
          <option value="sutter"> Sutter </option>
          <option value="fhs" > FHS </option>
          <option value="academy"> Academy </option>
        </select>
      </div>

      <div class ="edit-data-input">
        <label> Room </label>
        <br>
        <?php printRooms(False); ?>

        <select id="sutter-rooms" name="sutter-rooms">
          <option value="student"> Student Assigned </option>
          <option value="c2"> C2 </option>
          <option value="c3"> C3 </option>
          <option value="c4"> C4 </option>
          <option value="c5"> C5 </option>
          <option value="c6"> C6 </option>
          <option value="c7"> C7 </option>
          <option value="c8"> C8 </option>
          <option value="c9"> C9 </option>
          <option value="c10"> C10 </option>
          <option value="c11"> C11 </option>
          <option value="d1"> D1 </option>
          <option value="d2"> D2 </option>
          <option value="d3"> D3 </option>
          <option value="d4"> D4 </option>
          <option value="d5"> D5 </option>
          <option value="d6"> D6 </option>
          <option value="d7"> D7 </option>
          <option value="d8"> D8 </option>
          <option value="e1"> E1 </option>
          <option value="e2"> E2 </option>
          <option value="e3"> E3 </option>
          <option value="e4"> E4 </option>
        </select>

        <select id="fhs-rooms" name="fhs-rooms">
          <option value="student"> Student Assigned </option>
          <option value="101"> 101 </option>
          <option value="102"> 102 </option>
          <option value="103"> 103 </option>
          <option value="104"> 104 </option>
          <option value="105"> 105 </option>
          <option value="106"> 106</option>
          <option value="107"> 107 </option>
          <option value="108"> 108 </option>
          <option value="203"> 203 </option>
          <option value="204"> 204 </option>
          <option value="401"> 401 </option>
          <option value="402"> 402 </option>
          <option value="403"> 403 </option>
          <option value="404"> 404 </option>
          <option value="405"> 406 </option>
          <option value="407"> 407 </option>
          <option value="408"> 408 </option>
          <option value="409"> 409 </option>
          <option value="410"> 410 </option>
          <option value="411"> 411 </option>
          <option value="412"> 412 </option>
          <option value="413"> 413 </option>
          <option value="414"> 414 </option>
          <option value="501"> 501 </option>
          <option value="502"> 502 </option>
          <option value="601"> 601 </option>
          <option value="703"> 703 </option>
        </select>
      </div>


      <div class="edit-data-input">
        <label> Physical Status </label>
        <br>
        <select name="edit-physical-status-select" id="edit-physical-status-select">
          <option value="good"> Good </option>
          <option value="loaner"> Loaner </option>
        </select>
      </div>
    <div class="edit-data-input">
      <label class="student-id"> Student ID </label>
      <br>
      <input type="text" class="student-id" name="student-id" placeholder="Student ID">
    </div>

    <input type="checkbox" id="insurance-button" name="insurance" value="Y" class="insurance"> <label class="insurance"> Insurance </label>

      </div>
  </div>

  <div class="row">
    <div class="col-md-12 col-md-offset-1" style="text-align:center;">
      <input type="submit">
    </form>
      <br>
      <?php
        if($_POST) {
          if(isset($_POST["insurance"])) {
            addChromebook($_POST, true);
          }
          else {
            addChromebook($_POST, false);
          }
        }
       ?>
  </div>

</div>

  </div>
<script src="js/custom.js"></script>
</body>
</html>
