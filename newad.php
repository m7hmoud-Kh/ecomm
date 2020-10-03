<?php 
session_start();
$pagetitle  = "Add New Ads";
include "init.php";
if(isset($_SESSION["username"]))
{


  if ($_SERVER["REQUEST_METHOD"] == 'POST')
  {
      $formerror = array();

       $name    = filter_var($_POST["name"],FILTER_SANITIZE_STRING);
       $des     = filter_var($_POST["des"],FILTER_SANITIZE_STRING);
       $price   = filter_var($_POST["price"],FILTER_SANITIZE_NUMBER_INT);
       $country = filter_var($_POST["country"],FILTER_SANITIZE_STRING);
       $stat    = filter_var($_POST["status"],FILTER_SANITIZE_NUMBER_INT);
       $cat     = filter_var($_POST["categor"],FILTER_SANITIZE_NUMBER_INT);
       $tag     = filter_var($_POST["tag"],FILTER_SANITIZE_STRING);

       if(strlen($name) < 3)
       {
         $formerror[]="<div class='alert alert-danger'>must name greater than <b>3</b></div>";
       }
       if(strlen($des) < 10)
       {
         $formerror[]="<div class='alert alert-danger'>must Describe greater than <b>10</b></div>";
       }
       if(strlen($country) < 2)
       {
         $formerror[]="<div class='alert alert-danger'>must country greater than <b>2</b></div>";
       }
       if(empty($price))
       {
         $formerror[]="<div class='alert alert-danger'>price can't be <b>Empty</b></div>";
       }
       if(empty($stat))
       {
         $formerror[]="<div class='alert alert-danger'>status can't be <b>Empty</b></div>";
       }
       if(empty($cat))
       {
         $formerror[]="<div class='alert alert-danger'>categor can't be <b>Empty</b></div>";
       }

       if(empty($formerror))
       {
           $stmt = $con->prepare("INSERT 
            INTO items (`name` , desk , price , add_date , country_made , `status` ,cate_id , member_id , tag)
            VALUES (:n , :d , :p , now() , :c, :s , :cid ,:mid , :t )");

            $stmt->execute(array(

                "n"   =>  $name ,
                "d"   =>  $des  ,
                "p"   =>  $price ,
                "c"   =>  $country ,
                "s"   =>  $stat ,
                "cid" =>  $cat  ,
                "mid" =>  $_SESSION["uid"],
                't'   => $tag
            ));

            $count =$stmt->rowCount();

            if($count > 0)
            {
                $success =  "<div class='alert alert-success'>Add Item</div>";
            }
            else
            {
                echo "error in query " ;
            }

       }

  }

    ?>
    <style>
        .ask 
        {
            position: absolute;
            right: 5%;
            top: 3px;
            font-size: 25px;
            color: #f00;
        }
        .sty
        {
            width: 81% !important;
        }

    
        </style>
     <h1 class="text-center">Creat New Ads</h1>
     <div class="container">
         <div class="row">
             <div class="col-lg-8">
             <div class="container">
            <form class="form-horizontal" action="<?php echo $_SERVER["PHP_SELF"] ; ?>" method="POST">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input class="form-control live_name" type="text" name="name" autocomplete="off"   placeholder="name of the item" required="required" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Describe</label>
                    <div class="col-sm-10">
                        <input class="form-control live_desc" type="text" name="des"  
                         placeholder="describe of item"required="required" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">price</label>
                    <div class="col-sm-10">
                        <input class="form-control live_price" type="text" name="price" placeholder="price of item" required="required" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Country</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="country" placeholder="country made" required="required" >
                    </div>
                </div>
                <div class="form-group sty">
                    <label class="col-sm-2 control-label">status</label>
                    <select name="status" class="form-control sele" required="required"  >
                        <option value="0">...</option>
                        <option value="1">New</option>
                        <option value="2">Like New</option>
                        <option value="3">Used</option>
                        <option value="4">Old</option>
                    </select>
                </div>
                <div class="form-group sty">
                    <label class="col-sm-2 control-label">Categories</label>
                    <select name="categor" class="form-control sele" required="required"  >
                        <option value="0">...</option> <?php
                                                        $stmt = $con->prepare("SELECT * FROM categor");
                                                        $stmt->execute();
                                                        $cats = $stmt->fetchAll();
                                                        foreach ($cats as $cat) {
                                                        ?>
                            <option value="<?php echo $cat["ID"] ?>"><?php echo $cat["thename"] ?></option>
                        <?php
                                                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Tags</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="tag"  
                         placeholder="sperate with tags comma (,)">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 save">
                        <input type="submit" value="Add item" class="form-control btn btn-danger">
                    </div>
                </div>
            </form>
        </div>
             </div>
             <div class="col-lg-3">
                 <div class="card">
                    <img src="../eCommerce/layout/images/portfolio2.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title ">title</h5>
                        <p class="card-text">description</p>
                    </div>
                    <ul class="list-group list-group-flush live-pre">
                        <li class="list-group-item">$0</li>
                    </ul>
                 </div>
             </div>
         </div>
         <?php 
              if(! empty($formerror))
              {
                  foreach($formerror as $err)
                  {
                      echo $err . "<br>";
                  }
              }
               
              if(isset($success))
              {
                  echo $success;
              }

             ?>
     </div>



  <?php 
}
else
{
    header("location:login.php");
}


include $footer ;