<?php
include('head.php');
$objects_list = search_object('', '<>0');
?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Welcome on The g00d corner !</h1>
        <p>Here you can offer every products you have in your garage. You also can ask for a price and contact people who sell your dreamed object.</p>
        <p>Enjoy !</p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <?php 
        if(count($objects_list)>3){
          $num = 3;
        }
        else{
          $num = count($objects_list);
        }
        for($i=0;$i<$num;$i++){
        ?>
        <div class="col-md-4">
            <h2><?php echo htmlentities($objects_list[$i]['title']); ?></h2>
            <p><?php echo htmlentities($objects_list[$i]['description']); ?></p>
            <a class="btn btn-default" href="/object.php?id=<?php echo $objects_list[$i]['id']; ?>" role="button">View details &raquo;</a>
        </div>
        <?php
      }
      ?>
      </div>

      <hr>
<?php 
include('foot.php');
?>