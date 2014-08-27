<?php
include('head.php');
if (isset($_SESSION['login']) && $_SESSION['login']==1){
  header('Location: /index.php');
  exit();
}
$status = 'info';
$msg = '';
$t_msg = 'Login';
if(isset($_POST['mail']) && 
   isset($_POST['passwd'])){

$uid = user_login($_POST['mail'], $_POST['passwd']);

if($uid > 0){
  $_SESSION['login']=1;
  $_SESSION['uid']=$uid;
  header('Location: /profile.php?uid='.$_SESSION['uid']);
  exit();
}
else{
  $status = 'warning';
  $msg .= 'User doesn\'t exist';
}
}
?>
<!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Login on The g00d corner</h1>
      </div>
    </div>

    <div class="container">
    <form role="form" method="POST" action="/login.php">
      <div class="col-md-6">
          <div class="bs-callout bs-callout-<?php echo $status; ?>">
            <h4><?php echo $t_msg; ?></h4>
            <p><?php echo $msg; ?></p>
          </div>
      </div>
      <div class="col-md-6">
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input name="mail" type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input name="passwd" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
          </div>
          <button type="submit" class="btn btn-success">Login</button>
        </div>
      </form>
      </div>
      <div class="container">
    <hr>
<?php 
include('foot.php');
?>