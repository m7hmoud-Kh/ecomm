<?php

/*
============================================================
== mange member
== you can add | edit and delete member
============================================================
*/
$pagetitle = "member";
session_start();
if (isset($_SESSION["user"])) {
  include "init.php";
  $do = "";
  if (isset($_GET["do"])) {
    $do = $_GET["do"]; // 
  } else {
    $do = "mange";
  }
  $qurey = '';
  if (isset($_GET["page"]) && $_GET["page"] == "pending") {
    $qurey = "AND regstatus = 0 ";
  }


  if ($do == "mange") {


    $sql5 = "SELECT * FROM users WHERE ID != ? $qurey ";
    $stmt = $con->prepare($sql5);
    $stmt->execute(array($_SESSION['uid']));
    $rows = $stmt->fetchAll();
?>

  <style>
    .img 
    {
      width: 75px;
    }
    .img img 
    {
      width: 100%;
      border-radius: 50%;
      padding: 5px;
      background-color: #eee;
    }
  </style>
    <h1 class="text-center">mange member</h1>
    <div class="container">
      <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
          <tr>
            <td>#ID</td>
            <td>Avatar</td>
            <td>username</td>
            <td>email</td>
            <td>Fullname</td>
            <td>Registerd Date</td>
            <td>control</td>
          </tr>
          <?php


          foreach ($rows as $ro5) {
          ?>
            <tr>
              <td>
                <?php echo $ro5["ID"]; ?>
              </td>
              <td>
                <?php if (empty($ro5["image"]))
                {
                  echo "no image";
                }else{
                  ?> 
                 <div class="img">
                   <img src="../adminCP\\upload\\avatar\\<?php echo $ro5['image'] ; ?>" alt="">
                 </div>
                 <?php
                }
                 ?>
              </td>
              <td>
                <?php echo $ro5["username"]; ?>
              </td>
              <td>
                <?php echo $ro5["email"]; ?>
              </td>
              <td>
                <?php echo $ro5["Fullname"]; ?>
              </td>
              <td>
                <?php echo $ro5["history"]; ?>
              </td>
              <td>
                <a href="member.php?do=edit&userid= <?php echo $ro5["ID"] ?> " class="btn btn-success"> <i class="fa fa-edit"></i> Edit</a>
                <a href="member.php?do=delete&userid= <?php echo $ro5["ID"] ?> " class="btn btn-danger confirm"><i class="fa fa-times"></i> Delete</a>
                <?php
                if ($ro5["regstatus"] == 0) {
                  echo '<a href="member.php?do=active&userid=' . $ro5["ID"] . '" class="btn btn-info"> <i class="fas fa-check"></i> Accept</a>';
                }
                ?>
              </td>
            </tr>
          <?php
          }

          ?>
        </table>
      </div>
      <a href="member.php?do=add" class="btn btn-primary"> <i class="fa fa-plus"></i> Add New member</a>
    </div>



  <?php } elseif ($do == "add") { ?>

    <h1 class="text-center">Add New member</h1>
    <div class="container">
      <form class="form-horizontal" action="member.php?do=insert" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label class="col-sm-2 control-label">username</label>
          <div class="col-sm-10">
            <input class="form-control" type="text" name="username" autocomplete="off" required="required">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">password</label>
          <div class="col-sm-10">
            <input class="form-control" type="password" name="password" autocomplete="new-password" required="required">
            <i class="showpass fa fa-eye fa-2x"></i>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">email</label>
          <div class="col-sm-10">
            <input class="form-control" type="email" name="email" required="required">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">fullname</label>
          <div class="col-sm-10">
            <input class="form-control" type="text" name="funame" required="required">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Image porfile</label>
          <div class="col-sm-10">
            <input class="form-control" type="file" name="avtar" required="required">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10 save">
            <input type="submit" value="Add member" class="form-control btn btn-danger">
          </div>
        </div>
      </form>
    </div>

    <?php } elseif ($do == "insert") {
    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
      echo  "<h1 class='text-center'>Insert member</h1>";
      echo "<div class='container'>";

      // upload file
      
        $filename = $_FILES["avtar"]["name"];
        $filetype = $_FILES["avtar"]["type"];
        $filetmp  = $_FILES["avtar"]["tmp_name"];
        $filesize = $_FILES["avtar"]["size"];
        $fileerr  = $_FILES["avtar"]["error"];

        // allowed extion
        $allowextin = array("jpeg","jpg","png","gif");
        //extion will you get from filename
        $explode =  explode(".",$filename);
        $extion =end($explode);
        $extion = strtolower($extion);

        //------------------------------

      $user     = $_POST["username"];
      $email    = $_POST["email"];
      $fullname = $_POST["funame"];
      $Pass     = $_POST["password"];

      // password trick 
      // $pass = sha1($pass);
      // form vaildate 

      $formerr = array();

     
      if (empty($user)) {
        $formerr[] = " username  can't be <b> empty </b>";
      }
      if (strlen($user) < 3) {
        $formerr[] = " this username must be than <b> 2 caharater </b>";
      }

      if (strlen($user) >= 20) {
        $formerr[] = "this username must be less <b> 20 caharater </b>";
      }
      if (empty($email)) {
        $formerr[] = " eamil can't be <b> empty </b> ";
      }

      if (empty($fullname)) {
        $formerr[] =  "fullname  can't be <b> empty </b> ";
      }
      if(empty($filename))
      {
        $formerr[] =  "avatar  is <b> requried </b> ";
      }
      if(! in_array($extion, $allowextin))
      {
        $formerr[] =  "extionsion is not <b> Allowed </b> ";
      }
      if($filesize >4194304)
      {
        $formerr[] =  "avatar  is over <b> Size </b> ";
      }

      foreach ($formerr as $error) {
        echo "<div class='alert alert-danger'> $error </div>";
      }

      // check if no error in form or not 
      
      if (empty($formerr)) {


       $avatar = rand(0,100000)."_". $filename;
       $pith ="C:\\xampp\\htdocs\\php_mah\\eCommerce\\adminCP\\upload\\avatar\\";
       move_uploaded_file($filetmp, $pith.$avatar);

        $check = checkitem('username', 'users', $user );

        if ($check == 0) {

          $stmt = $con->prepare("INSERT INTO users (username , pass ,email ,Fullname,regstatus,history,`image`) VALUES(:u , :p , :e ,:f , 1 , 'now()', :i) ");
          $stmt->execute(array(
            'u' => $user,
            'p' => $Pass,
            'e' => $email,
            'f' => $fullname,
            'i' => $avatar 
          ));


          $themeg = "<div class='alert alert-success'> recored update ! </div>";
           
          redirect($themeg, 'back', 4, null);
        } else {
          $themeg = "<div class='alert alert-danger'>please try write anthor name </div>";
          redirect($themeg, "back", 4, null);
        }
      } else {
        $themeg = "<div class='alert alert-danger'>there is error in query </div>";
         redirect($themeg, null, 4, "homepage");
      }
      echo "<div/>";
    }
    
  } elseif ($do == 'edit') { // edit page

    if (isset($_GET["userid"]) && is_numeric($_GET["userid"])) {
      $userid = $_GET["userid"];
    } else {
      echo 0;
    }

    $sql = "SELECT * FROM users WHERE ID = ? LIMIT 1 ";

    $stmt = $con->prepare($sql);
    $stmt->execute(array($userid));
    $row  = $stmt->fetch();
    $count = $stmt->rowCount();

    if ($count > 0) {

    ?>

      <h1 class="text-center">Edit member</h1>
      <div class="container">
        <form class="form-horizontal" action="member.php?do=update" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label class="col-sm-2 control-label">username</label>
            <div class="col-sm-10">
              <input class="form-control" type="text" name="username" value="<?php echo $row["username"]; ?>" autocomplete="off" required="required">
            </div>
            <input type="hidden" name="ID" value="<?php echo $userid; ?>">
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">password</label>
            <div class="col-sm-10">
              <input type="hidden" name="oldpass" value="<?php echo $row["pass"] ?>">
              <input class="form-control" type="password" name="pass" autocomplete="new-password">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">email</label>
            <div class="col-sm-10">
              <input class="form-control" type="email" name="email" value="<?php echo $row["email"] ?>" required="required">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">fullname</label>
            <div class="col-sm-10">
              <input class="form-control" type="text" name="funame" value="<?php echo $row["Fullname"] ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">image users</label>
            <div class="col-sm-10">
              <input class="form-control" type="file" name="avta">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 save">
              <input type="submit" value="Save" class="form-control btn btn-danger">
            </div>
          </div>
        </form>
      </div>
<?php
    } else {
      $themeg =  '<div class="alert alert-danger"> this is any ID with this number </div>';
      redirect($themeg, 'back', 3, 'Backpage');
    }
  } elseif ($do == "update") {
    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
      echo  "<h1 class='text-center'>Update member</h1>";
      echo "<div class='container'>";
   
      $fname = $_FILES["avta"]["name"];
      $ftmp  = $_FILES["avta"]["tmp_name"];
      $ftype = $_FILES["avta"]["type"];
      $fsize = $_FILES["avta"]["size"];
      
      // allow extions
      $allowedextion = array("jpeg","jpg","png","gif");
      //
      $extion = explode(".",$fname);
      $extion = end($extion);
      $extion = strtolower($extion);


      $id       = $_POST["ID"];
      $user     = $_POST["username"];
      $email    = $_POST["email"];
      $fullname = $_POST["funame"];
    
      // password trick 

      $pass = "";
      if (empty($_POST["pass"])) {
        $pass = $_POST["oldpass"];
      } else {
        $pass = $_POST["pass"];
      }
      // $pass = sha1($pass);


      // form vaildate 

      $formerr = array();


      if (empty($user)) {
        $formerr[] = "<div class='alert alert-danger'> username  can't be <b> empty </div> </div>";
      }
      if (strlen($user) < 3) {
        $formerr[] = "<div class='alert alert-danger'> this username must be than <b> 2 caharater </b> </div>";
      }

      if (strlen($user) >= 20) {
        $formerr[] = "<div class='alert alert-danger'> this username must be less <b> 20 caharater </b> </div>";
      }
      if (empty($email)) {
        $formerr[] = "<div class='alert alert-danger'> eamil can't be <b> empty </b> </div>";
      }

      if (empty($fullname)) {
        $formerr[] = "<div class='alert alert-danger'> fullname  can't be <b> empty </b> </div>";
      }

      if(empty($fname))
      {
        $formerr[] = "<div class='alert alert-danger'> this is image <b> requried </b> </div>";
      }
      if(! in_array($extion,$allowedextion))
      {
        $formerr[] = "<div class='alert alert-danger'> this extion not <b> allowed </b> </div>";
      }
      if($fsize > 4194304)
      {
        $formerr[] = "<div class='alert alert-danger'> this image must be less than <b> 4MB </b> </div>";
      }

      foreach ($formerr as $error) {
        echo $error;

      }

      // check if no error in form or not 

      if (empty($formerr)) {

        $avatar = rand(0,10000)."_".$fname;
        $pith ="C:\\xampp\\htdocs\\php_mah\\eCommerce\\adminCP\\upload\\avatar\\";
        move_uploaded_file($ftmp , $pith.$avatar);

        $stmt2 = $con->prepare("SELECT username FROM users WHERE username = ? AND ID != ?");
        $stmt2->execute(array($user,$id));
        $row = $stmt2->rowCount();
        if ($row > 0) {
          $themeg = "<div class='alert alert-danger'>this name is exist try to use any name </div>";
            redirect($themeg, 'back', 4, null);
        } else {
          $stmt = $con->prepare("UPDATE users 
          SET username = ? , pass = ? , email = ? , Fullname = ? , `image` = ?  WHERE  ID = ? ");
          $stmt->execute(array($user, $pass, $email, $fullname, $avatar ,$id));
          $count = $stmt->rowCount();
          if ($count > 0) {
            $themeg = "<div class='alert alert-success'> recored update ! </div>";
            redirect($themeg, 'back', 4, null);
          } else {
            $themeg = "<div class='alert alert-danger'>NO DATA was Updated</div>";
            redirect($themeg, 'back', 4, null);
          }
        }
      }
    } else {
      $themeg = "<div class='alert alert-danger'>you can't browser Updata page directly </div>";
      redirect($themeg, null, 4, "homepage");
    }
    echo "<div/>";
  } elseif ($do == "delete") {

    echo  "<h1 class='text-center'>Delete member</h1>";
    echo "<div class='container'>";

    //this is check for userid
    if (isset($_GET["userid"]) && is_numeric($_GET["userid"])) {
      $userid = $_GET["userid"];
    } else {
      echo 0;
    }
    // fecth date when id =  $userid
    $sql6 = "SELECT * FROM users WHERE ID = ? LIMIT 1 ";
    $stmt = $con->prepare($sql6);
    $stmt->execute(array($userid));
    $count = $stmt->rowCount();
    if ($count > 0) {
      $stmt = $con->prepare("DELETE FROM users WHERE ID = ? ");
      $stmt->execute(array($userid));
      $themeg = '<div class="alert alert-success"> this is deleted </div>';
      redirect($themeg, 'back', 3, null);
    } else {
      $themeg =  '<div class="alert alert-danger"> this is any ID with this number </div>';
      redirect($themeg, 'back', 3, 'Backpage');
    }
  } elseif ($do == "active") {

    echo  "<h1 class='text-center'>Pending member</h1>";
    echo "<div class='container'>";

    //this is check for userid
    if (isset($_GET["userid"]) && is_numeric($_GET["userid"])) {
      $userid = $_GET["userid"];
    } else {
      echo 0;
    }
    // fecth date when id =  $userid
    $sql6 = "SELECT * FROM users WHERE ID = ? LIMIT 1 ";
    $stmt = $con->prepare($sql6);
    $stmt->execute(array($userid));
    $count = $stmt->rowCount();
    if ($count > 0) {
      $stmt = $con->prepare("UPDATE users SET  regstatus = 1 WHERE ID = ? ");
      $stmt->execute(array($userid));
      $themeg = '<div class="alert alert-success"> Record UPdate </div>';
      redirect($themeg, 'back', 3, null);
    } else {
      $themeg =  '<div class="alert alert-danger"> this is any ID with this number </div>';
      redirect($themeg, 'back', 3, 'Backpage');
    }
  } else {
    $themeg = "<div class='alert alert-danger'>ERROR there was no page with this name</div>";
    redirect($themeg, null, 5, 'homepage');
  }


  include $footer;
} else {
  header("location:index.php");
}
