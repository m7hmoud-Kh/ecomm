<?php 

session_start();
include "init.php";
if(isset($_GET["itemid"]) && is_numeric($_GET["itemid"]))
{
    $itemid =$_GET["itemid"];

    $stmt = $con->prepare("SELECT items.* , categor.thename , users.username 
                          FROM items
                          INNER JOIN categor ON categor.ID   = items.cate_id
                          INNER JOIN users   ON  users.ID    = items.member_id
                          WHERE items.ID = ? AND items.approv = 1");
    $stmt->execute(array($itemid));
    $items = $stmt->fetch();
    $count = $stmt->rowCount();

    if($count > 0){
 
    ?>
    <style>
        .custom_hr 
        {
            color: #bb6f6f;
            border: 2px solid;
        }
        .add_comment h3 
        {
            font-weight: bold;
        }
        .add_comment textarea 
        {
            display: block;
            margin: 10px 0;
            width: 300px;
            height: 150px;
            padding: 5px;
        }
        .tag
        {
            background-color: #eee;
            padding: 5px;
            color: #000;
            text-decoration: none;
            margin-left: 1%;
            border-radius: 8px;
        }
        .tag:hover 
        {
            color: #000;
            text-decoration: none;
        }
    </style>
   <h1 class="text-center"><?php echo $items["name"] ; ?></h1>

     <div class="container">
         <div class="row">
             <div class="col-lg-8">
             <img src="../eCommerce/includes/templates/layout/img/ven3.jpg" class="card-img-top" alt="...">
             </div>
         <div class="col-lg-4">
                    <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $items["name"]; ?></h5>  
                        <p class="card-text"><?php echo $items["desk"] ?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">price   : <?php echo $items["price"] ?></li>
                        <li class="list-group-item">date    : <?php echo $items["add_date"] ?></li>
                        <li class="list-group-item">made in : <?php echo $items["country_made"]; ?></li>
                        <li class="list-group-item">status  : <?php 
                        if($items["status"] == 1){echo "New" ;}
                        if($items["status"] == 2){echo "Like New" ;}
                        if($items["status"] == 3){echo "Used" ;}
                        if($items["status"] == 4){echo "Old" ;}
                        ?></li>
                        <li class="list-group-item">categor : <a href="catego.php?pagecat=<?php echo $items["cate_id"] ?>"> 
                        <?php echo $items["thename"]; ?></li> </a>
                        <li class="list-group-item">Add BY : <?php echo $items["username"]; ?></li>
                        <li class="list-group-item">TAGS :
                        <?php
                          $alltag = explode(",",$items["tag"]);
                          foreach($alltag as $tag)
                          {
                              $tag = str_replace(" " , "" , $tag);
                              $strlower = strtolower($tag);
                              if(! empty($tag)){
                              echo "<a class='tag' href='tags.php?name=".$strlower."'>".$tag."</a>";
                              }
                          } 
                        ?>
                        </li>
                    </ul>
                    </div>
                </div>
         </div>
         <hr class="custom_hr"> 
         <?php 
         if(isset($_SESSION["username"]))
         {
             ?>
         <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-9">
              <div class="add_comment">
                <h3>Add your comment</h3>
                <form action="<?php echo $_SERVER["PHP_SELF"] . "?itemid=" .  $items["ID"]  ?>" method="POST">
                    <textarea name="comment" required></textarea>
                    <input class="btn btn-primary" type="submit" value="Add comment">
                </form>
              </div>
            </div>
          </div>
          <?php 
           if($_SERVER["REQUEST_METHOD"] == 'POST')
           {
                $com    =  filter_var($_POST["comment"],FILTER_SANITIZE_STRING);
                $itemid =  $items["ID"];
                $memid  =  $_SESSION["uid"];

                if(empty($com))
                {
                    echo "<div class='alert alert-danger'>comment mustn't be <b>Empty</b></div>";
                }
                else
                {
                    $stmt=$con->prepare("INSERT 
                                        INTO comments 
                                        (comment ,`status`, com_data , item_id , mem_id ) 
                                        VALUES (:c , 0 , now() , :i , :m)");

                    $stmt->execute(array(
                          
                        'c' =>  $com,
                        "i" =>  $itemid ,
                        'm' =>  $memid
                    )); 
                    
                    $count = $stmt->rowCount();
                    if($count > 0)
                    {
                        echo "<div class='alert alert-success'>Comment Added</div>";
                    }
                }

                
           }
         }
         else 
         {
            ?>
              <div class="alert alert-info"><a href="login.php">login</a> to Add comment</div>
            <?php
         }
          ?>
          <?php 
              $stmt = $con->prepare("SELECT comments.* , items.* , users.username 
                                    FROM comments 
                                    INNER JOIN items ON items.ID = comments.item_id
                                    INNER JOIN users ON users.ID = comments.mem_id
                                    WHERE comments.status = 1 
                                    AND  items.ID= ?
                                    ORDER BY comments.com_id DESC ");
               $stmt->execute(array($items["ID"]));
               $comments = $stmt->fetchAll();
               $count = $stmt->rowCount();
                              
          ?>
         <hr class="custom_hr">
        <?php  if($count > 0) {  ?>
         <?php 
             foreach($comments as $com)
             {
                 ?>
                 <div class="row">
                     <div class="col-lg-3">
                     user  :  <?php echo $com["username"] ?>
                     </div>
                     <div class="col-lg-8">
                         <?php echo $com["comment"] ?>
                     </div>
                 </div>
                 <?php
             }
         ?>
         <?php  
         }
         else
         {
             echo "<div class='alert alert-info'>no comments to show </div>";
         }
         
         
         ?>
     </div>




    <?php

    }
    else
    {
        echo "<div class='container'>";
        echo "<div class='alert alert-danger'>there is no such ID OR waiting approval</div>";
        echo "</div>";
    }
}
else
{
    header("location:index.php");
}




include $footer ;
?>