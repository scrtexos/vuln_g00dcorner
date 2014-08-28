<?php
include('head.php');
$status = 'info';
$msg = '';
$t_msg = 'Register';
$avatar = 'default-avatar.png';

$save = 0;
if(isset($_POST['mail']) && 
   isset($_POST['passwd1']) && 
   isset($_POST['passwd2']) && 
   isset($_POST['lastname']) && 
   isset($_POST['firstname']) && 
   isset($_POST['address'])){
$save = 1;
if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
  $status = 'warning';
  $msg .= '* Invalid email address<br />';
}
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

if(user_exists($_POST['mail'])>0){
  $status = 'warning';
  $msg .= '* User already exists<br />';
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
  if(create_user($_POST['mail'],
                 $_POST['passwd1'], 
                 $_POST['lastname'], 
                 $_POST['firstname'], 
                 $_POST['address'], 
                 $avatar)
    ){
      $save = 2;
      $msg .= 'Welcome to The g00d corner '.htmlentities($_POST['firstname'].' '.$_POST['lastname']);
      $msg .= '<br /> You can now log in !';
  }
  else{
    $status = 'danger';
    $msg .= 'Database error, please contact administrator';
  }
  
}
}
?>
<!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Register on The g00d corner</h1>
      </div>
    </div>

    <div class="container">
    <form role="form" method="POST" enctype="multipart/form-data" action="<?php if($save!=2) { echo '/register.php'; } else { echo '/login.php'; } ?>">
      <div class="col-md-6">
          <div class="bs-callout bs-callout-<?php echo $status; ?>">
            <h4><?php echo $t_msg; ?></h4>
            <p><?php echo $msg; ?></p>
          </div>
          <?php if($save!=2){ ?>
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input name="mail" type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="<?php if($save==1){ echo htmlentities($_POST['mail']); } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input name="passwd1" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" value="<?php if($save==1){ echo htmlentities($_POST['passwd1']); } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword2">Retype Password</label>
            <input name="passwd2" type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" value="<?php if($save==1){ echo htmlentities($_POST['passwd2']); } ?>">
          </div>
      </div>
      <div class="col-md-6">
          <div class="form-group">
            <label for="Lastname">Lastname</label>
            <input name="lastname" type="text" class="form-control" id="Lastname" placeholder="Enter lastname" value="<?php if($save==1){ echo htmlentities($_POST['lastname']); } ?>">
          </div>
          <div class="form-group">
            <label for="Firstname">Firstname</label>
            <input name="firstname" type="text" class="form-control" id="Firstname" placeholder="Enter firstname" value="<?php if($save==1){ echo htmlentities($_POST['firstname']); } ?>">
          </div>
          <div class="form-group">
            <label for="Address">Address</label>
            <textarea name="address" class="form-control" rows="3" placeholder="Enter Address"><?php if($save==1){ echo htmlentities($_POST['address']); } ?></textarea>
          </div>
          <div class="form-group">
            <label for="exampleInputFile">Avatar</label>
            <input name="avatar" type="file" id="exampleInputFile">
          </div>
          <button type="submit" class="btn btn-success">Submit</button>
      </div>
      <?php } 
      else{
        ?>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input name="mail" type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="<?php echo htmlentities($_POST['mail']); ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input name="passwd" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
          </div>
          <button type="submit" class="btn btn-success">Login</button>
        </div>
        <?php
      }
      ?>
      </form>
      </div>
      <div class="container">
    <hr>
<?php 
include('foot.php');
?>
