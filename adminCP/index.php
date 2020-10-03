<?php
session_start();
$nonav ="";
$pagetitle = "login";
include "init.php";
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
     $user = $_POST["user"];
     $pass = $_POST["pass"];
     $hashedpass = sha1($pass);

     // check if user is exist or not 

      $sql = "SELECT ID , username , pass  FROM users WHERE username = ? AND pass  = ?  AND groupID = '1' LIMIT 1 " ;

       $stmt = $con->prepare($sql);
       $stmt->execute(array($user, $pass));
       $row  = $stmt->fetch();
       $count =$stmt->rowCount();
       if($count > 0)
       {
         $_SESSION["user"] = $user ;
         $_SESSION["id"] = $row["ID"];
         header("location:dashbord.php");
       }
       else
       {
          echo "<div class='alert alert-danger'>you are not admin sir</div>";
       }
       

  }
?>
<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" METHOD="POST">
    <h4 class="text-center">Admin Login</h4>
    <input class="form-control"  type="text"     name="user" placeholder="username" autocomplete="off">
    <input class="form-control"  type="password" name="pass" placeholder="password" autocomplete="new-password">
    <input class="btn btn-primary btn-block"     type="submit" value="login">
</form>

<?php include $footer; ?>

