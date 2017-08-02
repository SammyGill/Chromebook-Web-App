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
  <link href="custom.css" rel="stylesheet">

  <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
  <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js">
      </script><![endif]-->
  <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

  <script src="assets/js/ie-emulation-modes-warning.js"></script>
  <script src="js/bootstrap.js"></script>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media
       queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js">
    </script>
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
          <li> <a href="assign.php"> Assign Chromebooks </a></li>
        </ul>
      </div>

      <div class="row">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main text-align:center;">
            <h1 style="text-align: center; margin: auto; padding-bottom: 20px;">
              Submit A Repair Request </h1>
              <?php
              if($_POST)
                  completeRepair($_POST);
               ?>
        </div>
      </div>
        <div class="col-md-12 col-md-offset-6">
            <input type="text" id="repair-search" name="repair-search" placeholder="Serial Number/Asset Tag" onkeyup="filterSearch('repair-search')">
        </div>
      <div class="row">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main text-align:center;">
          <?php
              formatTableRepair(getChromebookRepair());
           ?>

           <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
              aria-labelledby="myModalLabel" aria-hidden="true">

              <div class="modal-dialog">
                 <div class="modal-content">

                    <div class="modal-header">
                       <h4 class="modal-title" id="myModalLabel"> Damage Information </h1>
                    </div>

                    <form method="post" action= >
                    <div class="modal-body">
                      <div style="padding-bottom:15px;">

                        <div class="edit-data-input">
                          <label> Asset Tag </label>
                          <br>
                          <input type="text" id="asset" name="asset" placeholder="Asset" readonly>
                        </div>

                        <div class="edit-data-input">
                          <label> Serial Number </label>
                          <br>
                          <input type="text" id="serial" placeholder="Serial" readonly>
                        </div>

                        <div class="edit-data-input">
                          <label> School + Room </label>
                          <br>
                          <input type="text" id="location" name="location" placeholder="Location" readonly>
                        </div>
                      </div>

                        <div class="edit-data-input">
                          <label> Model </label>
                          <br>
                          <input type="text" id="model" placeholder="Model" readonly>
                        </div>

                        <div class="edit-data-input">
                          <label> Damage </label>
                          <br>
                          <input type="text" id="damage" name="damage" placeholder="Damage" readonly>
                        </div>

                        <div class="edit-data-input">
                          <label> Cost </label>
                          <br>
                          <input type="text" id="cost" name="cost" placeholder="Total Cost" readonly>
                        </div>
                        <input type="text" id="assignment" name="assignment" style="display:none;">
                    </div>

                    <div class="modal-footer">
                      <input type="submit" value="Repair Complete" class="btn btn-primary">
                    </div>
                    </form>
                  </div>
                </div>
              </div>


        </div>

      </div>
<script src="js/custom.js"></script>
</body>

</html>
