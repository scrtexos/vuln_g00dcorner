<?php
include('head.php');
$status = 'info';
$msg = '';
$t_msg = 'Add a new object';
$photo = 'default-avatar.png';

$save = 0;
if(isset($_POST['title']) && 
   isset($_POST['description']) && 
   isset($_POST['price']) && 
   isset($_POST['category_id'])){
$save = 1;
if(empty($_POST['title'])){
  $status = 'warning';
  $msg .= '* Empty title<br />';
}
if(empty($_POST['description'])){
  $status = 'warning';
  $msg .= '* Empty description<br />';
}
if(!filter_var($_POST['price'], FILTER_VALIDATE_INT)){
  $status = 'warning';
  $msg .= '* Invalid price<br />';
}
if($_POST['category_id'] == "new"){
  if(empty($_POST['category_name'])){
    $status = 'warning';
    $msg .= '* Empty category name<br />';
  }
  else{
    $cat_id = category_exists($_POST['category_name']);
    if($cat_id <= 0){
      $cat_id = create_category($_POST['category_name']);
    }
  }
}
else if(empty(get_category($_POST['category_id']))){
  $status = 'warning';
  $msg .= '* Invalid category<br />';
}
else{
  $cat_id = $_POST['category_id'];
}

if(isset($_FILES['photo']) && !empty($_FILES['photo']['name'])){
  if($_FILES['photo']['error'] > 0){
    $status = 'warning';
    $msg .= '* Photo transfer failed<br />';   
  }
  else{
    $photo = upload_photo($_FILES['photo']);
  }
}

if($status==='info'){
  if(isset($_GET['oid']) && object_exists($_GET['oid'])>0){
    if(update_object($_GET['oid'], $_POST['description'], $_POST['price'], $photo, $cat_id)){
      $save = 2;
      $msg .= 'Object successfully updated';
    }
    else{
      $status = 'danger';
      $msg .= 'Database error, please contact administrator';
    }
  }
  else{
    if(create_object($_POST['title'], $_POST['description'], $_POST['price'], $photo, $cat_id, $_SESSION['uid'])){
      $save = 2;
      $msg .= 'Object successfully created';
    }
    else{
      $status = 'danger';
      $msg .= 'Database error, please contact administrator';
    }
  }
}
}
else if(isset($_GET['oid'])){
  if(isset($_GET['del'])){
    delete_object($_GET['oid']);
    header('Location: /my_objects.php');
  }
  else{
    $t_msg = 'Edit an object';
    $save=1;
    $object = get_object($_GET['oid']);
    $_POST['title'] = $object['title'];
    $_POST['description'] = $object['description'];
    $_POST['price'] = $object['price'];
    $_POST['category_id'] = $object['category_id'];
    $_POST['category_name'] = '';
    $photo = $object['photo_path'];
  }
}
$user_infos = get_user_infos($_SESSION['uid']);
$objects = get_objects_user($_SESSION['uid']);
?>
    <div class="jumbotron">
      <div class="container">
        <h1><?php echo htmlentities($user_infos['lastname'].' '.$user_infos['firstname']).' objects'; ?></h1>
      </div>
    </div>

    <div class="container">
      <div class="col-md-6">
      <div class="bs-callout bs-callout-info">
            <h4>Object list</h4>
          </div>
          <ul>
            <?php
            for($i=0;$i<count($objects);$i++){
              echo '<li><a href="/my_objects.php?oid='.$objects[$i]['id'].'">'.htmlentities($objects[$i]['title']).'</a><a href="/my_objects.php?oid='.$objects[$i]['id'].'&del=1" style="float:right; margin-right:100px; color:red;">X</a></li>';
            }
            ?>
          </ul>
      </div>
      <div class="col-md-6">
        <form role="form" method="POST" enctype="multipart/form-data" action="/my_objects.php<?php if(isset($_GET['oid'])){ echo '?oid='.htmlentities($_GET['oid']); } ?>">
        <div class="bs-callout bs-callout-<?php echo $status; ?>">
            <h4><?php echo $t_msg; ?></h4>
            <p><?php echo $msg; ?></p>
          </div>
          <div class="form-group">
            <label for="Title">Title</label>
            <input <?php if(isset($_GET['oid'])) { echo 'readonly="readonly"'; } ?> name="title" type="text" class="form-control" id="Title" placeholder="Enter title" value="<?php if($save==1){ echo htmlentities($_POST['title']); } ?>">
          </div>
          <div class="form-group">
            <label for="Description">Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Enter description"><?php if($save==1){ echo htmlentities($_POST['description']); } ?></textarea>
          </div>
          <div class="form-group">
            <label for="Price">Price</label>
            <input name="price" type="number" class="form-control" id="Price" placeholder="Enter price" value="<?php if($save==1){ echo htmlentities($_POST['price']); } else { echo '1'; } ?>">
          </div>
          <div class="form-group">
            <label for="Category">Category</label>
            <select name="category_id" class="form-control" id="Category">
              <option value="new">New</option>
              <?php
              for($i=0;$i<count($categories);$i++){
                  if($save==1 && $categories[$i]['id']==$_POST['category_id']){
                    echo '<option selected value="'.$categories[$i]['id'].'">'.htmlentities($categories[$i]['title']).'</option>';
                  }
                  else{
                    echo '<option value="'.$categories[$i]['id'].'">'.htmlentities($categories[$i]['title']).'</option>';
                  }
              }
              ?>
            </select>
          </div>
          <div id="new_category" class="form-group">
            <label for="Category_name">Category name</label>
            <input name="category_name" type="text" class="form-control" id="Category_name" placeholder="Enter new category name" value="<?php if($save==1){ echo htmlentities($_POST['category_name']); } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputFile">Photo</label>
            <input name="photo" type="file" id="exampleInputFile">
            <?php if($save==1) { echo '<img src="'.print_avatar($photo).'" />'; } ?>
          </div>
          <button type="submit" class="btn btn-success">Submit</button>
      </div>
      </form>
      </div>
      <div class="container">
    <hr>
<?php 
include('foot.php');
?>