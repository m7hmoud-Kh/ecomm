<?php
session_start();
include "init.php";
if (isset($_SESSION["username"])) {
    if (isset($_GET["name"])) {
        $tag =  $_GET["name"] ;
        $stmt = $con->prepare("SELECT items.* , users.username
                                FROM
                                items 
                                INNER JOIN users ON items.member_id = users.ID
                                WHERE 
                                items.tag LIKE ? AND items.approv = 1  ORDER BY items.ID DESC");
        $stmt->execute(array('%'.$tag.'%'));
        $allitem = $stmt->fetchAll();
        ?>
         <h1 class="text-center"> <?php echo strtoupper($tag) ;  ?></h1>
           <div class="container">
              <div class="row">
              <?php 
               foreach($allitem as $item){
             ?>
              <div class="col-md-3">
                    <div class="card">
                    <img src="../eCommerce/includes/templates/layout/img/ven3.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title" > <a href="item.php?itemid=<?php echo $item["ID"]; ?>"> 
                        <?php echo $item["name"] ?></a></h5>
                        <p class="card-text"><?php echo $item["desk"] ?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><?php echo $item["price"] ?></li>
                        <li class="list-group-item"><?php echo $item["add_date"] ?></li>
                        <li class="list-group-item"><?php echo $item["country_made"]; ?></li>
                    </ul>
                    <div class="card-body">
                        <a href="#" class="card-link"><?php echo $item["username"] ?></a>
                    </div>
                    </div>
                </div>
               <?php } ?>
              </div>
           </div>
      <?php     
    }
    else
    {
        echo "<div class='alert alert-danger'>this is no any request sir </div>";
    }
} else {
    header("location:login.php");
}




include $footer;
