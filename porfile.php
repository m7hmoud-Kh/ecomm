<?php
session_start();
 $pagetitle ="porfile";
include "init.php";

if(isset($_SESSION["username"]))
{

    $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute(array($_SESSION["username"]));
    $info = $stmt->fetch();

    $stmt2 = $con->prepare("SELECT * FROM items WHERE member_id = ? ORDER BY ID DESC");
    $stmt2->execute(array($info["ID"]));
    $items = $stmt2->fetchAll();
    $couitem = $stmt2->rowCount();


    $stmt3 = $con->prepare("SELECT * FROM comments WHERE mem_id = ?");
    $stmt3->execute(array($info["ID"]));
    $comments = $stmt3->fetchAll();




 ?>
 <style>
     .face
    {
        text-align: center;
        font-size: 35px;
        color: #fff;
        background-color:#3b0404;
        border-radius: 15px;
        width: 500px;
        margin: auto;
        margin-bottom: 5px;
        font-weight: bold;
        border: 3px solid #ff5e5e;
        position: relative;
     }
     .face::before
     {
         content: "";
         border-style: solid;
         position: absolute;
         width: 0;
         height: 0;
         border-color: #f00 transparent transparent transparent;
         border-width: 10px;
         bottom: -21px;
         left: 228px;
     }
     .body
     {
         text-align: center;
         margin: 15px 0;
     }
     .comment
     {
        color: #fff;
        background-color: #000;
        width: 500px;
        margin: auto;
        margin-bottom: 11px;
        border-radius: 15px;
        padding: 5px;
     }
     .item_box
     {
         margin-bottom: 10px;
     }
     .edit 
     {
         margin: 10px 0;
         margin-left: 45%;

     }
    
 </style>
 <h1 class="text-center">porfile <?php echo $_SESSION["username"]; ?></h1>

    <div class="container">
        <div class="face">MY informations</div>
        <div class="body">
        name      : <?php echo $info["username"] ; ?> <br>
        Email     : <?php echo $info["email"] ; ?> <br>
        Full Name : <?php echo $info["Fullname"] ; ?> <br>
        DATE      : <?php echo $info["history"] ; ?> <br>
        </div>
        <a href="#" class="btn btn-primary text-center edit">Edit Informations</a>
     </div>
    <div class="container">
        <div class="face">MY Ads</div>
        <div class="body">
            <div class="row">
        <?php
        if( $couitem > 0){
          foreach($items as $item)
          {     ?>
                <div class="col-lg-4">
                    <div class="item_box">
                    <div class="card">
                    <img src="../eCommerce/includes/templates/layout/img/ven3.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><a href="item.php?itemid=<?php echo $item["ID"] ?> "> 
                        <?php echo $item["name"] ?></a></h5>
                        <p class="card-text"><?php echo $item["desk"] ?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">$<?php echo $item["price"] ?></li>
                        <li class="list-group-item"><?php echo $item["add_date"] ?></li>
                        <li class="list-group-item"><?php echo $item["country_made"]; ?></li>
                    </ul>
                    <?php
                        if($item["approv"]==0)
                        {
                            ?>
                            <div class="alert alert-info">this is not approval</div>
                            <?php
                        } 
                        ?>
                    </div>
                </div>
                </div>
               

            <?php  
             
           }
          echo "</div>";
          }
          else{
              echo "<div alert alert-info>You not upload any <b>Ads<b></div>";
          } 
          ?>
        </div>
    </div>
    <div class="container">
        <div class="face">MY Comments</div>
        <div class="body">
          <?php 
               foreach($comments as $com)
               {
                ?>
                 <p class="comment"><?php echo $com["comment"] ?></p>
                <?php
               }
          ?>
        </div>
    </div>

 <?php 
}
else
{
    header("location:login.php");
}
include $footer; 

