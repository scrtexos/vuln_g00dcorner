<?php
include('config.php');
session_start();
$categories = get_categories();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="bootstrap/favicon.ico">
    
    <title>The g00d corner</title>

    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/bootstrap/css/docs.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/bootstrap/js/ie-emulation-modes-warning.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/bootstrap/js/ie10-viewport-bug-workaround.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="/index.php">Home</a>
          <?php 
          if (!isset($_SESSION['login']) || $_SESSION['login']!=1){
            echo '<a class="navbar-brand" href="/register.php">Register</a>';
            echo '<a class="navbar-brand" href="/login.php">Login</a>';
          }
          else{
            echo '<a class="navbar-brand" href="/profile.php">My profile</a>';
            echo '<a class="navbar-brand" href="/my_objects.php">My objects</a>';
            echo '<a class="navbar-brand" href="/logout.php">Logout</a>';
          }
          ?>
        </div>
        <div class="navbar-collapse collapse">
          <form class="navbar-form navbar-right" role="form" method="POST" action="/search.php">
            <div class="form-group">
              <input type="text" placeholder="Keyword" name="keyword" class="form-control">
            </div>
            <div class="form-group">
              <select name="category" class="form-control">
                <option value="<>0">All</option>
                <?php
                for($i=0;$i<count($categories);$i++){
                  echo '<option value="='.$categories[$i]['id'].'">'.htmlentities($categories[$i]['title']).'</option>';
                }
                ?>
              </select>
            </div>
            <button type="submit" class="btn btn-success">Search</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </div>