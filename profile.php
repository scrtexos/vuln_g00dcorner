<?php
include('head.php');
$status = 'info';
$msg = '';
$t_msg = 'Update';
$avatar = 'default-avatar.png';

if(isset($_POST['passwd1']) && 
   isset($_POST['passwd2']) && 
   isset($_POST['lastname']) && 
   isset($_POST['firstname']) && 
   isset($_POST['address'])){

if($_POST['passwd1']!==$_POST['passwd2']){
  $status = 'warning';
  $msg .= '* Passwords doesn\'t match<br />';
}
if(empty($_POST['passwd1'])){
  $status = 'warning';
  $msg .= '* Empty password<br />';
}
if(empty($_POST['lastname'])){
  $status = 'warning';
  $msg .= '* Empty lastname<br />';
}
if(empty($_POST['firstname'])){
  $status = 'warning';
  $msg .= '* Empty firstname<br />';
}
if(empty($_POST['address'])){
  $status = 'warning';
  $msg .= '* Empty Address<br />';
}
if(isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])){
  if($_FILES['avatar']['error'] > 0){
    $status = 'warning';
    $msg .= '* Avatar transfer failed<br />';   
  }
  else{
    $avatar = upload_avatar($_FILES['avatar']);
  }
}

if($status==='info'){
  if(update_user($_SESSION['uid'],
                 $_POST['passwd1'], 
                 $_POST['lastname'], 
                 $_POST['firstname'], 
                 $_POST['address'], 
                 $avatar)
    ){
      $msg .= 'Information updated';
  }
  else{
    $status = 'danger';
    $msg .= 'Database error, please contact administrator';
  }
}
}
$user_infos = get_user_infos($_SESSION['uid']);
?>
<!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1><?php echo htmlentities($user_infos['lastname'].' '.$user_infos['firstname']).' profile'; ?></h1>
      </div>
    </div>

    <div class="container">
    <form role="form" method="POST" action="/profile.php" enctype="multipart/form-data">
      <div class="col-md-6">
          <div class="bs-callout bs-callout-<?php echo $status; ?>">
            <h4><?php echo $t_msg; ?></h4>
            <p><?php echo $msg; ?></p>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input disabled type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="<?php echo htmlentities($user_infos['email']); ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input name="passwd1" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" value="">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword2">Retype Password</label>
            <input name="passwd2" type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" value="">
          </div>
      </div>
      <div class="col-md-6">
          <div class="form-group">
            <label for="Lastname">Lastname</label>
            <input name="lastname" type="text" class="form-control" id="Lastname" placeholder="Enter lastname" value="<?php echo htmlentities($user_infos['lastname']); ?>">
          </div>
          <div class="form-group">
            <label for="Firstname">Firstname</label>
            <input name="firstname" type="text" class="form-control" id="Firstname" placeholder="Enter firstname" value="<?php echo htmlentities($user_infos['firstname']); ?>">
          </div>
          <div class="form-group">
            <label for="Address">Address</label>
            <textarea name="address" class="form-control" rows="3" placeholder="Enter Address"><?php echo htmlentities($user_infos['address']); ?></textarea>
          </div>
          <div class="form-group">
            <label for="exampleInputFile">Avatar</label>
            <input name="avatar" type="file" id="exampleInputFile">
            <img src="<?php echo print_avatar($user_infos['avatar_path']); ?>" />
          </div>
          <input type="submit" class="btn btn-success">
      </div>
      </form>
      </div>
      <div class="container">
    <hr>
<?php 
include('foot.php');
?>
