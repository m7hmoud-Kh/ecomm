<?php
session_start();
 $pagetitle ="Home page";
include "init.php";

$stmt = $con->prepare("SELECT items.* , users.username FROM items
                      INNER JOIN users ON users.ID = items.member_id
                      WHERE items.approv = 1
                      ORDER BY items.ID DESC");
$stmt->execute();
$allitem = $stmt->fetchAll();
  ?>
  <style>
      .item_box 
      {
          margin: 20px 0;
      }
  </style>
   <div class="container">
       <div class="row">
  <?php 
  foreach($allitem as $item){
?>
     <div class="col-md-3">
                    <div class="item_box">
                    <div class="card">
                    <img src="../eCommerce/includes/templates/layout/img/ven3.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title" > <a href="item.php?itemid=<?php echo $item["ID"]; ?>"> 
                        <?php echo $item["name"] ?></a></h5>
                        <p class="card-text"><?php echo $item["desk"] ?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><?php echo $item["price"] ?>$</li>
                        <li class="list-group-item"><?php echo $item["add_date"] ?></li>
                        <li class="list-group-item"><?php echo $item["country_made"]; ?></li>
                    </ul>
                    <div class="card-body">
                        <a href="#" class="card-link"><?php echo $item["username"] ?></a>
                    </div>
                    </div>
                    </div>
        </div>
<?php 
  }
  ?>
 </div>
    </div>
  <?php 


include $footer; 

