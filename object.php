<?php
include('head.php');
if(!isset($_GET['id']) || object_exists($_GET['id'])!=$_GET['id']){
  $title = 'This object doesn\'t exist';
  $description = '';
  $price = '';
  $category_name = '';
  $lastname = '';
  $firstname = '';
  $email = '';
}
else{
  $object = get_object($_GET['id']);
  extract($object);
}
?>
    <div class="jumbotron">
      <div class="container">
        <h1><?php echo $title; ?></h1>
        <p><?php echo $description; ?></p>
        <?php echo '<img src="'.print_photo($photo_path).'" />'; ?>
        <p><?php echo '<b>Category</b> : '.$category_name.' - <b>Price</b> : '.$price.' $'; ?></p>
        <p><?php echo '<b>Vendor</b> : '.$lastname.' '.$firstname.' ('.$email.')'; ?></p>
        <?php echo '<img src="'.print_avatar($avatar).'" />'; ?>
      </div>
    </div>

    <div class="container">
      <hr>
<?php 
include('foot.php');
?>