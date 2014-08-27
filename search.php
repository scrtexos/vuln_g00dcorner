<?php
include('head.php');
$num = 0;
$objects_list = array();
if(isset($_POST['keyword']) && isset($_POST['category'])){
    $objects_list = search_object($_POST['keyword'], $_POST['category']);
    $num = count($objects_list);
}
?>
    <div class="jumbotron">
      <div class="container">
        <h1>Your research return <?php echo $num; ?> results.</h1>
      </div>
    </div>

    <div class="container">
      <?php 
      for($i=0;$i<$num;$i++){
        ?>
        <div class="col-md-4">
            <h2><?php echo htmlentities($objects_list[$i]['title']); ?></h2>
            <p><?php echo $objects_list[$i]['description']; ?></p>
            <a class="btn btn-default" href="/object.php?id=<?php echo $objects_list[$i]['id']; ?>" role="button">View details &raquo;</a>
        </div>
        <?php
      }
      ?>
    </div>
      <div class="container">
    <hr>
<?php 
include('foot.php');
?>