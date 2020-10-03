<?php

session_start();
include "init.php";

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (isset($_POST["login"])) {

        $name = $_POST["username"];
        $pass = $_POST["pass"];

        $stmt = $con->prepare("SELECT  ID , username , pass FROM users WHERE username = ? AND pass = ?");

        $stmt->execute(array($name,$pass));

        $getid = $stmt->fetch();

        $row = $stmt->rowCount();

        if ($row > 0) {
            $_SESSION["username"] = $name;
            $_SESSION["uid"]      = $getid["ID"];
            header("location:index.php");
        } else {
            echo  "<div class='alert alert-danger'> must be singup sir </div>";
        }
           
    }
    else
    {
        $formerro = array();

        $name  = $_POST["name"];
        $pass  = $_POST["pass"];
        $fname = $_POST["fname"];
        $email = $_POST["email"];
        
            if(isset($_POST["name"]))
            {
               $filtuser = filter_var($name,FILTER_SANITIZE_STRING);
               if(strlen($filtuser) < 3)
               {
                $formerro[] = "<div class='alert alert-danger'>Must uername greater than <b>3</b> </div>";
               }
            }

            if(isset($pass) && isset($_POST["testpass"]))
            {
                if(empty($pass))
                {
                    $formerro[] = "<div class='alert alert-danger'>Password can't be <b>Empty<b> </div>";
                }
                $pass1 =  $pass;
                $pass2 = $_POST["testpass"];

                if($pass1 !== $pass2)
                {
                    $formerro[]= "<div class='alert alert-danger'>password not <b>identcal</b></div>";
                }
            }

            if(isset($fname) && !empty($fname))
            {
                $filterfname = filter_var($fname,FILTER_SANITIZE_STRING);
            }
            if(isset($_POST["email"]))
            {
                $filteremail = filter_var($_POST["email"],FILTER_SANITIZE_EMAIL);
                if(filter_var($filteremail , FILTER_VALIDATE_EMAIL) != TRUE)
                { 
                    $formerro[]= "<div class='alert alert-danger'>Email Not <b>vailed</b></div>";
                }
            }

            if(empty($formerro))
            {
                $stmt = $con->prepare("SELECT username FROM users WHERE username = ? ");
                $stmt->execute(array($name));
                $checkname = $stmt->rowCount();
                if($checkname > 0 )
                {
                    $formerro[]= "<div class='alert alert-danger'>user is aleady <b> exist </b> </div>";
                }
                else
                {
                    $stmt2 =$con->prepare("INSERT INTO users (username , pass , email , Fullname, history, regstatus) 
                    VALUES (:u , :p ,:e , :f ,now() , 0) ");

                    $stmt2->execute(array(
                       "u" => $name ,
                       "p" => $pass ,
                       "e" => $email,
                       "f" => $fname
                    ));
                    $record = $stmt2->rowCount();

                    if ($record == 1)
                    {
                        $megsuccess = "<div class='alert alert-success'>you singup successfly</div>";
                    }
                    else
                    {
                        echo "<div class='alert alert-danger'>you are't singup sir </div>";
                    }
                }
            }
    }
}
?>
<style>
        .error
        {
            width: 300px !important;
            margin: auto !important;
        }
</style>
<h1 class="text-center"><span class="active" data-class=".login">Login</span>|
    <span data-class=".singup">SingUp</span></h1>

<div class="container">
    <!-- start the login form-->
    <div class="login">
        <form action="<?php $_SERVER['REQUEST_METHOD'] ?>" method="POST">
            <div class="form_login">
                <div class="form_input">
                    <input class="form-control lo_in" type="text" name="username" placeholder="type your name" autocomplete="off" required="required">
                </div>
                <div class="form_input">
                    <input class="form-control lo_in" type="password" name="pass" placeholder="type your password" autocomplete="new-password" required="required">
                </div>
                <input class="form-control alert alert-info lo_in" name="login" type="submit" value="login">
            </div>
        </form>
    </div>
    <!-- end the login form-->
    <!-- start the singup form-->
    <div class="singup">
        <form action="<?php $_SERVER['REQUEST_METHOD'] ?>" method="POST" class="singup">
            <div class="form_login">
                <div class="form_input">
                    <input class="form-control lo_in" type="text" name="name" placeholder="type your name"
                   autocomplete="off"  pattern=".{4,}" title="must be than 4 char" required="required">
                </div>
                <div class="form_input">
                    <input class="form-control lo_in" type="password" name="pass" placeholder="type your password" required="required">
                </div>
                <div class="form_input">
                    <input class="form-control lo_in" type="password" name="testpass" placeholder="type your password again" required="required">
                </div>
                <div class="form_input">
                    <input class="form-control lo_in" type="text" name="fname" placeholder="type your Full Name"
                   autocomplete="off"  required="required">
                </div>
                <div class="form_input">
                    <input class="form-control lo_in" type="text" name="email" placeholder="type your email" required="required">
                </div>
                <input class="form-control alert alert-success lo_in" name="singup" type="submit" value="SingUp">
            </div>
        </form>
    </div>
    <!-- end the singup form-->
    <div class="error text-center">
        <?php 
         if(!empty($formerro))
         {
             foreach($formerro as $err)
             {
                 ?>
                  <p><?php  echo $err ; ?></p>
                 <?php
             }
         }
          if(isset($megsuccess))
          {
              echo $megsuccess;
          }
         ?>
    </div>
</div>

<?php include $footer; ?>