<?php

session_start();
$pagetitle = "comments";
if (isset($_SESSION["user"])) {

    include "init.php";

    $do = "";
    if (isset($_GET["do"])) {
        $do = $_GET["do"];
    } else {
        $do = "mange";
    }

    if ($do == "mange") {
        $stmt = $con->prepare("SELECT comments.* , items.name AS `item name` , users.username AS member 
                            FROM comments 
                            INNER JOIN items ON items.ID = comments.item_id 
                            INNER JOIN users ON users.ID = comments.mem_id
                            ORDER BY `status`");
        $stmt->execute();
        $comms = $stmt->fetchAll();

?>

        <h1 class="text-center">mange comments</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>comment</td>
                        <td>item name</td>
                        <td>member</td>
                        <td>data</td>
                        <td>control</td>
                    </tr>
                    <?php
                    foreach ($comms as $com) {
                    ?>
                        <tr>
                            <td>
                                <?php echo $com["com_id"]; ?>
                            </td>
                            <td>
                                <?php echo $com["comment"]; ?>
                            </td>
                            <td>
                                <?php echo $com["item name"]; ?>
                            </td>
                            <td>
                                <?php echo $com["member"]; ?>
                            </td>
                            <td>
                                <?php echo $com["com_data"]; ?>
                            </td>
                            <td>
                                <a href="comment.php?do=edit&comm_id= <?php echo $com["com_id"] ?> " class="btn btn-success"> <i class="fa fa-edit"></i> Edit</a>
                                <a href="comment.php?do=delete&comm_id= <?php echo  $com["com_id"]  ?> " class="btn btn-danger confirm"><i class="fa fa-times"></i> Delete</a>
                                <?php
                                if ($com["status"] == 0) {
                                    echo '<a href="comment.php?do=approv&comm_id=' . $com["com_id"] . '" class="btn btn-info"> <i class="fas fa-check"></i> Accept</a>';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php
                    }

                    ?>
                </table>
            </div>
        </div>
        <?php
    } elseif ($do == "edit") {
        if (isset($_GET["comm_id"]) && is_numeric($_GET["comm_id"])) {
            $comid = $_GET["comm_id"];
        } else {
            echo "0";
        }

        $stmt = $con->prepare("SELECT * FROM comments WHERE com_id = ?");
        $stmt->execute(array($comid));
        $comm = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) {
        ?>
            <h1 class="text-center">Edit Comment</h1>
            <div class="container">
                <form class="form-horizontal" action="comment.php?do=update" method="POST">
                    <input type="hidden" name="commid" value="<?php echo $comm["com_id"] ?>">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">comment</label>
                        <div class="col-sm-10">
                            <textarea name="comment" class="form-control" required="required">
                  <?php echo $comm["comment"]; ?></textarea>
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
            $themeg = "<div class='alert alert-danger'>this is no such ID</div>";
            redirect($themeg, 'back', 3, null);
        }
    } elseif ($do == "update") {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo "<h1 class='text-center'>update comment</h1>";
            echo "<div class='container'>";

            $commid = $_POST["commid"];
            $comment = $_POST["comment"];

            $check = checkitem("com_id", "comments", $commid);
            if ($check > 0) {
                $stmt = $con->prepare("UPDATE comments SET comment = ? WHERE com_id = ? ");
                $stmt->execute(array($comment, $commid));
                $themeg = "<div class='alert alert-success'>one comment updated...</div>";
                redirect($themeg, "back", 3, null);
            } else {
                $themeg = "<div class='alert alert-danger'>there is no such ID </div>";
                redirect($themeg, "back", 3, null);
            }
        } else {
            $themeg = "<div class='alert alert-danger'>you can't  broswer this page direct sir </div>";
            redirect($themeg, null, 3, 'homepage');
        }

        echo "</div>";
    } elseif ($do == "delete") {
           
        echo "<h1 class='text-center'>deleted comments</h1>";
        echo "<div class='container'>";

        if (isset($_GET["comm_id"]) && is_numeric($_GET["comm_id"])) {
            $commid = $_GET["comm_id"];
        } else {
            echo "0";
        }
        
        $stmt = $con->prepare("SELECT * FROM comments WHERE com_id =  ?");
        $stmt->execute(array($commid));
        $count = $stmt->rowCount();
        if($count > 0)
        {
           $stmt = $con->prepare("DELETE FROM comments WHERE com_id = ?");
           $stmt->execute(array($commid));
           $themeg = "<div class='alert alert-success'>one comment deleted...</div>";
           redirect($themeg, "back", 3, null);
        }
        else
        {
            $themeg = "<div class='alert alert-danger'>there is no such ID </div>";
            redirect($themeg, "back", 3, null);
        }
        echo "</div>";
    }
    elseif ($do == "approv")
    {
        echo "<h1 class='text-center'>Accepted comments</h1>";
        echo "<div class='container'>";

        if (isset($_GET["comm_id"]) && is_numeric($_GET["comm_id"])) {
            $commid = $_GET["comm_id"];
        } else {
            echo "0";
        }

         
        $stmt = $con->prepare("SELECT * FROM comments WHERE com_id =  ?");
        $stmt->execute(array($commid));
        $count = $stmt->rowCount();
        if($count > 0)
        {
           $stmt = $con->prepare("UPDATE comments SET `status` = 1 WHERE com_id = ?");
           $stmt->execute(array($commid));
           $themeg = "<div class='alert alert-success'>one comment Accepted...</div>";
           redirect($themeg, "back", 3, null);
        }
        else
        {
            $themeg = "<div class='alert alert-danger'>there is no such ID </div>";
            redirect($themeg, "back", 3, null);
        }

        echo "</div>";
    }
    elseif($do == 'show')
    {
        echo "<div class='container'>";

        if (isset($_GET["comm_id"]) && is_numeric($_GET["comm_id"])) {
            $commid = $_GET["comm_id"];
        } else {
            echo "0";
        }
           
        $stmt = $con->prepare("SELECT comments.* , items.* , users.*
                            FROM comments 
                            INNER JOIN items ON comments.item_id = items.ID 
                            INNER JOIN users ON comments.mem_id  = users.ID
                            WHERE item_id = ?");
        $stmt->execute(array($commid));
        $rows = $stmt->fetchAll();
        $count = $stmt->rowCount();

        $stmt2 =$con->prepare("SELECT `name` FROM items WHERE ID = ?");
        $stmt2->execute(array($commid));
        $row = $stmt2->fetch(); 

        if($count > 0)
        {
          
            ?>

            <h1 class="text-center">comments for [<?php echo $row["name"]  ?>] </h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <td>#ID</td>
                            <td>comment</td>
                            <td>member</td>
                            <td>data</td>
                            <td>control</td>
                        </tr>
                        <?php
                        foreach($rows as $row){
                        ?>
                            <tr>
                                <td>
                                    <?php echo $row["com_id"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["comment"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["username"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["com_data"]; ?>
                                </td>
                                <td>
                                    <a href="comment.php?do=edit&comm_id= <?php echo $row["com_id"] ?> " class="btn btn-success"> <i class="fa fa-edit"></i> Edit</a>
                                    <a href="comment.php?do=delete&comm_id= <?php echo  $row["com_id"]  ?> " class="btn btn-danger confirm"><i class="fa fa-times"></i> Delete</a>
                                    <?php
                                    if ($row["status"] == 0) {
                                        echo '<a href="comment.php?do=approv&comm_id=' . $row["com_id"] . '" class="btn btn-info"> <i class="fas fa-check"></i> Accept</a>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php
                        }

                        ?>
                    </table>
                </div>
            </div>
            <?php
        }


        echo "</div>";

    }
  

    include $footer;
} else {
    header("location:index.php");
    exit();
}
