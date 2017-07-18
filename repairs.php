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
  <link href="custom.css" rel="stylesheet">

  <title>Chromebook Repairs</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="dashboard.css" rel="stylesheet">

  <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
  <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
  <script src="assets/js/ie-emulation-modes-warning.js"></script>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body>
  <?php include 'functions.php' ?>

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
          <li><a href="overview.html">Overview <span class="sr-only">(current)</span></a></li>
          <li><a href="analytics.html">Analytics</a></li>
          <li><a href="export.html">Export</a></li>
        </ul>
        <ul class="nav nav-sidebar">
          <li><a href="manage.html">Manage</a></li>
          <li><a href="search.php">Search</a></li>
          <li><a href ="quick-add.php"> Add Chromebook </a></li>
          <li class="active"> <a href="repairs.php"> Repairs </a></li>
        </ul>
      </div>

      <div class="row">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main text-align:center;">
            <h1 style="text-align: center; margin: auto; padding-bottom: 20px;">
              Submit A Repair Request </h1>
        </div>
      </div>
        <div class="col-md-12 col-md-offset-6">
          <form method="post" action= >
            <input type="text" name="repair-search" placeholder="Serial Number/Asset Tag">
            <input type="submit">
          </form>


        </div>
      <div class="row">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main text-align:center;">
          <?php
            if($_POST) {
              getChromebookRepair($_POST);
            }
           ?>
        </div>
      </div>
</body>

</html>