<?php
session_start();
$pagetitle = "Item";
if (isset($_SESSION["user"])) {
    include "init.php";

    $do = "";
    if (isset($_GET["do"])) {
        $do = $_GET["do"];
    } else {
        $do = "mange";
    }

    if ($do == "mange") {


        $sql5 = "SELECT items.* ,
                        categor.thename AS `name of category` ,
                        users.username AS `name of seller`
                FROM
                        items
                INNER JOIN categor ON categor.ID = items.cate_id
                INNER JOIN users ON users.ID     = items.member_id ";
        $stmt = $con->prepare($sql5);
        $stmt->execute();
        $items = $stmt->fetchAll();
?>

        <h1 class="text-center">mange Item</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>name</td>
                        <td>Describe</td>
                        <td>price</td>
                        <td>Date</td>
                        <td>Country</td>
                        <td>category</td>
                        <td>seller</td>
                        <td>control</td>
                        <td>show comments</td>
                    </tr>
                    <?php


                    foreach ($items as $item) {
                    ?>
                        <tr>
                            <td>
                                <?php echo $item["ID"]; ?>
                            </td>
                            <td>
                                <?php echo $item["name"]; ?>
                            </td>
                            <td>
                                <?php echo $item["desk"]; ?>
                            </td>
                            <td>
                                <?php echo $item["price"]; ?>
                            </td>
                            <td>
                                <?php echo $item["add_date"]; ?>
                            </td>
                            <td>
                                <?php echo $item["country_made"]; ?>
                            </td>
                            <td>
                                <?php echo $item["name of category"]; ?>
                            </td>
                            <td>
                                <?php echo $item["name of seller"]; ?>
                            </td>
                            <td>
                                <a href="item.php?do=edit&item_id= <?php echo $item["ID"] ?> " class="btn btn-success"> <i class="fa fa-edit"></i> Edit</a>
                                <a href="item.php?do=delete&item_id= <?php echo $item["ID"] ?> " class="btn btn-danger confirm"><i class="fa fa-times"></i> Delete</a>
                                <?php
                                if ($item["approv"] == 0) {
                                    echo '<a href="item.php?do=approv&item_id=' . $item["ID"] . '" class="btn btn-info"> <i class="fas fa-check"></i> Accept</a>';
                                }
                                ?>
                            </td>
                            <td>
                            <a href="comment.php?do=show&comm_id= <?php echo $item["ID"] ?> " class="btn btn-success"> <i class="fa fa-comment"></i> comments</a>
                            </td>
                        </tr>
                    <?php
                    }

                    ?>
                </table>
            </div>
            <a href="item.php?do=add" class="btn btn-primary"> <i class="fa fa-plus"></i> Add New item</a>
        </div>



    <?php

    } elseif ($do == 'add') {  ?>
        <h1 class="text-center">Add New Item</h1>
        <div class="container">
            <form class="form-horizontal" action="item.php?do=insert" method="POST">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="name" autocomplete="off" required="required" placeholder="name of the item">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Describe</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="des" required="required" placeholder="describe of item">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">price</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="price" required="required" placeholder="price of itrm">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Country</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="country" required="required" required="required" placeholder="country made">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">status</label>
                    <select name="status" class="form-control sele" required="required">
                        <option value="0">...</option>
                        <option value="1">New</option>
                        <option value="2">Like New</option>
                        <option value="3">Used</option>
                        <option value="4">Old</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">member</label>
                    <select name="member" class="form-control sele" required="required">
                        <option value="0">...</option> <?php
                                                        $stmt = $con->prepare("SELECT * FROM users");
                                                        $stmt->execute();
                                                        $users = $stmt->fetchAll();
                                                        foreach ($users as $user) {
                                                        ?>
                            <option value="<?php echo $user["ID"] ?>"><?php echo $user["username"] ?></option>
                        <?php
                                                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Categories</label>
                    <select name="categor" class="form-control sele" required="required">
                        <option value="0">...</option> <?php
                                            $stmt = 
                                            $con->prepare("SELECT * FROM categor WHERE parent = 0");
                                            $stmt->execute();
                                            $cats = $stmt->fetchAll();
                                        foreach ($cats as $cat) {
                                        ?>
                         <option value="<?php echo $cat["ID"] ?>"><?php echo $cat["thename"] ?></option>
                         <?php
                         $stmt2 = $con->prepare("SELECT * FROM categor WHERE parent = ?");
                         $stmt2->execute(array($cat["ID"]));
                         $allchild = $stmt2->fetchAll();
                         foreach($allchild as $c)
                         {
                             ?>
                            <option value="<?php echo $c["ID"] ?>">---<?php echo $c["thename"] ?></option>
                            <?php 
                         }
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
        <?php
    } elseif ($do == 'insert') {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            echo  "<h1 class='text-center'>Insert Item</h1>";
            echo "<div class='container'>";
            $name       = $_POST["name"];
            $des        = $_POST["des"];
            $price      = $_POST["price"];
            $country    = $_POST["country"];
            $stat       = $_POST["status"];
            $member     = $_POST["member"];
            $cats       = $_POST["categor"];
            $tag        = $_POST["tag"];


            $formerr = array();


            if (empty($name)) {
                $formerr[] = " name  <b> can't be  empty </b>";
            }
            if (empty($des)) {
                $formerr[] = " Describe  <b> can't be  empty </b>";
            }

            if (strlen($price) >= 20) {
                $formerr[] = "price <b> can't be  empty </b>";
            }
            if (empty($country)) {
                $formerr[] = " country <b> can't be  empty </b> ";
            }

            if ($stat == 0) {
                $formerr[] =  " <b> you must choose status </b>";
            }
            if ($member == 0) {
                $formerr[] =  " <b> you must choose member </b>";
            }
            if ($cats == 0) {
                $formerr[] =  " <b> you must choose categor </b>";
            }
            if (empty($tag)) {
                $formerr[] = " tag <b> can't be  empty </b> ";
            }

            foreach ($formerr as $error) {
                echo "<div class='alert alert-danger'> $error </div>";
            }

            // check if no error in form or not 

            if (empty($formerr)) {



                $stmt = $con->prepare("INSERT INTO items 
                (`name` , desk ,price ,country_made,`status`,add_date,member_id,cate_id,tag) 
                VALUES(:n , :d , :p ,:c , :s , now(), :m , :cats , :t) ");
                $stmt->execute(array(
                    'n'    => $name,
                    'd'    => $des,
                    'p'    => $price,
                    'c'    => $country,
                    's'    => $stat,
                    'm'    => $member,
                    'cats' => $cats,
                    't'    => $tag
                ));
                $count = $stmt->rowCount();

                if ($count > 0) {
                    $themeg = "<div class='alert alert-success'> recored update ! </div>";
                    redirect($themeg, 'back', 4, null);
                } else {
                    $themeg = "<div class='alert alert-danger'>NO Date Was Inserted</div>";
                    redirect($themeg, null, 4, "homepage");
                }
            }
        } else {
            $themeg = "<div class='alert alert-danger'>you can,t browser directly</div>";
            redirect($themeg, null, 4, "homepage");
        }
    } elseif ($do == 'edit') {
        if (isset($_GET["item_id"]) && is_numeric($_GET["item_id"])) {
            $itemid = $_GET["item_id"];
        } else {
            echo 0;
        }

        $stmt = $con->prepare("SELECT * FROM items WHERE ID = ?");

        $stmt->execute(array($itemid));

        $item = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) {
        ?>
            <h1 class="text-center">Edit New Item</h1>
            <div class="container">
                <form class="form-horizontal" action="item.php?do=update" method="POST">
                    <input type="hidden" name="itemid" value="<?php echo $itemid; ?>">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="name" autocomplete="off" required="required" placeholder="name of the item" value="<?php echo $item["name"] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Describe</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="des" required="required" placeholder="describe of item" value="<?php echo $item["desk"] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">price</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="price" required="required" placeholder="price of item" value="<?php echo $item["price"] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Country</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="country" required="required" required="required" placeholder="country made" value="<?php echo $item["country_made"] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">status</label>
                        <select name="status" class="form-control sele" required="required">
                            <option value="1" <?php if ($item["status"] == 1) {
                                                    echo "selected";
                                                } ?>>New</option>
                            <option value="2" <?php if ($item["status"] == 2) {
                                                    echo "selected";
                                                } ?>>Like New</option>
                            <option value="3" <?php if ($item["status"] == 3) {
                                                    echo "selected";
                                                } ?>>Used</option>
                            <option value="4" <?php if ($item["status"] == 4) {
                                                    echo "selected";
                                                } ?>>Old</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">member</label>
                        <select name="member" class="form-control sele" required="required">
                            <?php
                            $stmt = $con->prepare("SELECT * FROM users");
                            $stmt->execute();
                            $users = $stmt->fetchAll();
                            foreach ($users as $user) {
                            ?>
                                <option value="<?php echo $user["ID"] ?>" <?php if ($item["member_id"] == $user["ID"]) {
                                                                                echo "selected";
                                                                            } ?>>
                                    <?php echo $user["username"] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Categories</label>
                        <select name="categor" class="form-control sele" required="required">
                            <?php
                            $stmt = $con->prepare("SELECT * FROM categor");
                            $stmt->execute();
                            $cats = $stmt->fetchAll();
                            foreach ($cats as $cat) {
                            ?>
                                <option value="<?php echo $cat["ID"] ?>" <?php if ($item["cate_id"] == $cat["ID"]) {
                                                                                echo "selected";
                                                                            } ?>>
                                    <?php echo $cat["thename"] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tags</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="tag" required="required" 
                             value="<?php echo $item["tag"] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 save">
                            <input type="submit" value="Update item" class="form-control btn btn-danger">
                        </div>
                    </div>
                </form>
            </div>
<?php
        } else {
            $themeg =  '<div class="alert alert-danger"> this is any ID with this number </div>';
            redirect($themeg, null, 3, 'homepage');
        }
    } elseif ($do == 'update') {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            echo "<h1 class='text-center'>Update item</h1>";
            echo "<div class='container'>";

            $itemid     = $_POST["itemid"];
            $name       = $_POST["name"];
            $des        = $_POST["des"];
            $price      = $_POST["price"];
            $country    = $_POST["country"];
            $stat       = $_POST["status"];
            $member     = $_POST["member"];
            $cats       = $_POST["categor"];
            $tag        = $_POST["tag"];

            if (!empty($name) && !empty($des) && !empty($price) && !empty($country)) {
                $sql2 = "UPDATE 
                              items
                        SET
                             `name`       = ? ,
                             desk         = ? ,
                             price        = ? ,
                             country_made = ? ,
                             `status`     = ? ,
                             cate_id      = ? ,
                             member_id    = ? ,
                             tag          =?
                        WHERE 
                             `ID` = ? ";
                $stmt = $con->prepare($sql2);
                $stmt->execute(array($name, $des, $price, $country, $stat, $cats, $member, $tag ,$itemid));
                $count = $stmt->rowCount();
                if ($count > 0) {
                    $themeg =  '<div class="alert alert-success">Date Was Updates... </div>';
                    redirect($themeg, "back", 3, null);
                } else {
                    $themeg =  '<div class="alert alert-danger">NO Date Was Updated ! </div>';
                    redirect($themeg, "back", 3, null);
                }
            }
        } else {
            $themeg =  '<div class="alert alert-danger"> you can\'t broswer this page direct </div>';
            redirect($themeg, "back", 3, null);
        }

        echo "</div>";
    } elseif ($do == 'delete') {

        echo  "<h1 class='text-center'>Delete member</h1>";
        echo "<div class='container'>";

        if (isset($_GET["item_id"]) && is_numeric($_GET["item_id"])) {
            $itemid = $_GET["item_id"];
        } else {
            echo 0;
        }
        // fecth date when id =  $userid
        $sql6 = "SELECT * FROM items WHERE ID = ?";
        $stmt = $con->prepare($sql6);
        $stmt->execute(array($itemid));
        $count = $stmt->rowCount();
        if ($count > 0) {
            $stmt = $con->prepare("DELETE FROM items WHERE ID = ? ");
            $stmt->execute(array($itemid));
            $themeg = '<div class="alert alert-success"> this is deleted </div>';
            redirect($themeg, 'back', 3, null);
        } else {
            $themeg =  '<div class="alert alert-danger"> this is any ID with this number </div>';
            redirect($themeg, 'back', 3, 'Backpage');
        }
    } elseif ($do == "approv") {
            
        echo "<h1 class='text-center'>Approval item</h1>";
        echo "<div class='container'>";
        if (isset($_GET["item_id"]) && is_numeric($_GET["item_id"])) {
            $itemid =  $_GET["item_id"];
        } else {
            echo "0";
        }
        $check =  checkitem('ID', 'items', $itemid);

        if($check > 0){
            $stmt=$con->prepare("UPDATE items set approv = 1 WHERE ID = ?");
            $stmt->execute(array($itemid));
            $stmt->fetch();
            $themeg = "<div class='alert alert-success'>this is accepted</div>";
            redirect($themeg, "back", 3, null);
        }
        else
        {
            $themeg = "<div class='alert alert-danger'>this is no such ID</div>";
            redirect($themeg, "back", 3, null);
        }

       echo  '</div>';

    }
    include $footer;
} else {
    header("location:index.php");
}
