<?php
session_start();
$pagetitle = "categories";
if (isset($_SESSION["user"])) {
    include "init.php";
    $do = '';
    if (isset($_GET["do"])) {
        $do = $_GET["do"];
    } else {
        $do = 'mange';
    }


    if ($do == 'mange') {

        $sort = 'ASC';
        $sortarr = array('ASC', 'DESC');
        if (isset($_GET["sort"]) && in_array($_GET["sort"], $sortarr)) {
            $sort = $_GET["sort"];
        }

        $stmt = $con->prepare("SELECT * FROM categor WHERE parent = 0  ORDER BY ordering  $sort");
        $stmt->execute();
        $rows = $stmt->fetchAll();  ?>

        <style>
            .child a 
            {
                display: block;
                background-color: #eee;
                color: #f64b4b;
                margin: 5px 0;
                padding: 5px;
                text-decoration: none;
            }
            .child_de
            {
                padding: 0;
                margin: 0;
                margin-left: 0;
                color: #ff0202;
                position: relative;
                top: 0;
                left: -69px;
                margin-right: 88%;
                display: none;
            }
            .child_de a 
            {
                color: #f00 !important;
                position: static;
                margin-left: 0% !important;
                padding: 0;
            }
            .panel_body .last_user li:nth-of-type(2n+1)
            {
                background-color:  transparent !important;
            }
        </style>
        <h1 class="text-center"> mange category</h1>
        <div class="container category">
            <div class="panel">
                <div class="panel_head">
                    <span><i class="fa fa-edit"></i> mange category</span>
                    <div class="ord"><i class="fa fa-sort"></i> Ordering [
                        <a class="<?php if ($sort == 'ASC') {
                                        echo 'active';
                                    } ?>" href="categor.php?sort=ASC">ASC</a> |
                        <a class="<?php if ($sort == 'DESC') {
                                        echo 'active';
                                    } ?>" href="categor.php?sort=DESC">DESC</a>] <wbr>
                        <i class="fa fa-eye"></i> View [ <wbr>
                        <span class="active" data-view="full">Full</span> |
                        <span>classic</span> ]
                    </div>
                </div>
                <div class="panel_body">
                    <ul class="list-unstyled last_user">
                        <?php
                        foreach ($rows as $row) {
                            echo "<div class='cats'>";
                            echo "<div class='hidden_button'>";
                            echo "<a href='categor.php?do=edit&catid=" . $row["ID"] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>";
                            echo "<a href='categor.php?do=delete&catid=" . $row["ID"] . "' class='confirm btn btn-danger'><i class='fa fa-times'></i> Delete</a>";
                            echo "</div>";
                            echo "<h3>" . $row["thename"] . "</h3>";
                            echo "<div class='full_view'>";
                            echo "<p>";
                            if ($row["deck"] == "") {
                                echo "this category has no describtion";
                            } else {
                                echo $row["deck"];
                            }
                            echo "</p>";
                            if ($row["visible"] == 1) {
                                echo "<span class='visble'>Hidden</span>";
                            }
                            if ($row["comment"] == 1) {
                                echo "<span class='commenting'>comment Disable</span>";
                            }
                            if ($row["ads"] == 1) {
                                echo "<span class='ads'>ads Disable</span>";
                            }
                            echo "</div>";
                            echo "</div>";
                            $stmt = $con->prepare("SELECT * FROM categor WHERE parent = ? ORDER BY ID DESC");
                            $stmt->execute(array($row["ID"]));
                            $childcat = $stmt->fetchAll();
                            $count = $stmt->rowCount();
                            if($count > 0){
                                echo "<h3>Child category</h3>";
                           echo "<ul class='list-unstyled child'>";
                            foreach($childcat as $c)
                            {
                            echo "<a href='categor.php?do=edit&catid=" . $c["ID"] ."'>" 
                            . $c["thename"] ."</a>";
                                  ?>
                                    <li class="confirm child_de"> 
                                        <a href="categor.php?do=delete&catid=<?php echo $c["ID"] ; ?>">Delete</a> 
                                    </li>
                                <?php 
                            }
                            echo "</ul>";
                           }
                            echo "<hr>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <a class="btn btn-primary addcat" href="categor.php?do=add"><i class="fa fa-plus"></i> Add New Category</a>
        </div>
    <?php
    } elseif ($do == 'add') {   ?>
        <h1 class="text-center">Add New category</h1>
        <div class="container">
            <form class="form-horizontal" action="categor.php?do=insert" method="POST">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="name" autocomplete="off" required="required" placeholder="name of the category">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Describe</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="des">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">ordering</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="order">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">parent?</label>
                    <select name="parent" class="form-control">
                        <option value="0">none</option>
                        <?php
                        $stmt = $con->prepare("SELECT * FROM categor WHERE parent = 0 ORDER BY ID DESC");
                        $stmt->execute();
                        $cats = $stmt->fetchAll();
                        foreach ($cats as $cat) {
                        ?>
                            <option value="<?php echo $cat["ID"]; ?>"><?php echo $cat["thename"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">visible</label>
                    <div class="col-sm-10">
                        <div>
                            <input id="vis-yes" type="radio" name="vis" value="0" checked>
                            <label for="vis-yes">Yes</label>
                        </div>
                        <div>
                            <input id="vis-no" type="radio" name="vis" value="1">
                            <label for="vis-no">No</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Allow Comment</label>
                    <div class="col-sm-10">
                        <div>
                            <input id="com-yes" type="radio" name="com" value="0" checked>
                            <label for="com-yes">Yes</label>
                        </div>
                        <div>
                            <input id="com-no" type="radio" name="com" value="1">
                            <label for="com-no">No</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Allow Ads</label>
                    <div class="col-sm-10">
                        <div>
                            <input id="ads-yes" type="radio" name="ads" value="0" checked>
                            <label for="ads-yes">Yes</label>
                        </div>
                        <div>
                            <input id="ads-no" type="radio" name="ads" value="1">
                            <label for="ads-no">No</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 save">
                        <input type="submit" value="Add category" class="form-control btn btn-danger">
                    </div>
                </div>
            </form>
        </div>
        <?php
    } elseif ($do == 'insert') {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            echo  "<h1 class='text-center'>Insert category</h1>";
            echo "<div class='container'>";
            $name  = $_POST["name"];
            $des   = $_POST["des"];
            $order = $_POST["order"];
            $parent = $_POST["parent"];
            $vis   = $_POST["vis"];
            $com   = $_POST["com"];
            $ads   = $_POST["ads"];


            if (!empty($name)) {

                $check = checkitem('name', 'categor', $name);

                if ($check == 0) {

                    $stmt = $con->prepare("INSERT INTO categor 
                    (thename , deck ,ordering, parent ,visible ,comment ,ads) 
                     VALUES(:n, :d , :o , :p ,:v , :c , :a ) ");
                    $stmt->execute(array(
                        'n' => $name,
                        'd' => $des,
                        'o' => $order,
                        'p' => $parent,
                        'v' => $vis,
                        'c' => $com,
                        'a' => $ads,
                    ));

                    $themeg = "<div class='alert alert-success'> recored update ! </div>";
                    redirect($themeg, 'back', 4, null);
                } else {
                    $themeg = "<div class='alert alert-danger'> the name of categor is exist </div>";
                    redirect($themeg, "back", 4, null);
                }
            } else {
                $themeg = "<div class='alert alert-danger'>the name is empty sir </div>";
                redirect($themeg, 'back', 4, null);
            }
        } else {
            $themeg = "<div class='alert alert-danger'> You can't browsing this page directly </div>";
            redirect($themeg, null, 4, "homepage");
        }
        echo "<div/>";
    } elseif ($do == 'edit') {

        if (isset($_GET["catid"]) && is_numeric($_GET["catid"])) {
            $catid = $_GET["catid"];
        } else {
            echo 0;
        }
        $sql = "SELECT * FROM categor WHERE ID = ? LIMIT 1 ";

        $stmt = $con->prepare($sql);
        $stmt->execute(array($catid));
        $cat  = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count > 0) {
        ?>
            <h1 class="text-center">Edit category</h1>
            <div class="container">
                <form class="form-horizontal" action="categor.php?do=update" method="POST">
                    <input type="hidden" name="catid" value="<?php echo $catid; ?>">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="name" placeholder="name of the category" value="<?php echo $cat["thename"] ?>" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Describe</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="des" placeholder="Describe of the category" value="<?php echo $cat["deck"] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">ordering</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="order" value="<?php echo $cat["ordering"] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">parent?</label>
                        <select name="parent" class="form-control">
                            <option value="0">none</option>
                            <?php
                            $stmt = $con->prepare("SELECT * FROM categor WHERE parent = 0  ORDER BY ID DESC");
                            $stmt->execute();
                            $cats = $stmt->fetchAll();
                            foreach ($cats as $c) {
                            ?>
                                <option value="<?php echo $c["ID"] ?>" 
                                <?php
                                    if ($cat["parent"] == $c["ID"] )
                                    {
                                        echo "selected";
                                    }
                                ?>
                                >
                                <?php echo $c["thename"] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">visible</label>
                        <div class="col-sm-10">
                            <div>
                                <input id="vis-yes" type="radio" name="vis" value="0"
                                 <?php if ($cat["visible"] == 0) {
                                    echo 'checked';
                                 }  ?>>
                                <label for="vis-yes">Yes</label>
                            </div>
                            <div>
                                <input id="vis-no" type="radio" name="vis" value="1" <?php if ($cat["visible"] == 1) {
                                                                                            echo 'checked';
                                                                                        }  ?>>
                                <label for="vis-no">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Allow Comment</label>
                        <div class="col-sm-10">
                            <div>
                                <input id="com-yes" type="radio" name="com" value="0" <?php if ($cat["comment"] == 0) {
                                                                                            echo 'checked';
                                                                                        }  ?>>
                                <label for="com-yes">Yes</label>
                            </div>
                            <div>
                                <input id="com-no" type="radio" name="com" value="1" <?php if ($cat["comment"] == 1) {
                                                                                            echo 'checked';
                                                                                        }  ?>>
                                <label for="com-no">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Allow Ads</label>
                        <div class="col-sm-10">
                            <div>
                                <input id="ads-yes" type="radio" name="ads" value="0" <?php if ($cat["ads"] == 0) {
                                                                                            echo 'checked';
                                                                                        }  ?>>
                                <label for="ads-yes">Yes</label>
                            </div>
                            <div>
                                <input id="ads-no" type="radio" name="ads" value="1" <?php if ($cat["ads"] == 1) {
                                                                                            echo 'checked';
                                                                                        }  ?>>
                                <label for="ads-no">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 save">
                            <input type="submit" value="Update" class="form-control btn btn-info">
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
            echo  "<h1 class='text-center'>Update category</h1>";
            echo "<div class='container'>";
            $catid  =  $_POST["catid"];
            $name  = $_POST["name"];
            $des   = $_POST["des"];
            $order = $_POST["order"];
            $parent= $_POST["parent"];
            $vis   = $_POST["vis"];
            $com   = $_POST["com"];
            $ads   = $_POST["ads"];

            // password trick 


            if (!empty($name)) {
                $stmt = $con->prepare("UPDATE categor SET thename = ? , deck = ? , ordering = ?, parent = ? , visible = ? ,comment = ?, ads = ?  WHERE  ID = ? ");
                $stmt->execute(array($name, $des, $order, $parent , $vis, $com, $ads, $catid));
                $count = $stmt->rowCount();
                if ($count > 0) {
                    $themeg = "<div class='alert alert-success'> recored update ! </div>";
                    redirect($themeg, 'back', 2, null);
                } else {
                    $themeg = "<div class='alert alert-danger'>NO DATA was Updated</div>";
                    redirect($themeg, 'back', 4, null);
                }
            }
        } else {
            $themeg = "<div class='alert alert-danger'>you can't browser Updata page directly </div>";
            redirect($themeg, null, 4, "homepage");
        }
        echo "<div/>";
    } elseif ($do == 'delete') {

        echo  "<h1 class='text-center'>Delete category</h1>";
        echo "<div class='container'>";

        //this is check for userid
        if (isset($_GET["catid"]) && is_numeric($_GET["catid"])) {
            $catid = $_GET["catid"];
        } else {
            echo 0;
        }
        $check = checkitem('ID', 'categor', $catid);
        if ($check > 0) {

            $stmt = $con->prepare("DELETE FROM categor WHERE ID = ? ");
            $stmt->execute(array($catid));
            $themeg = '<div class="alert alert-success"> this is deleted </div>';
            redirect($themeg, 'back', 3, null);
        } else {
            $themeg =  '<div class="alert alert-danger"> this is any ID with this number </div>';
            redirect($themeg, 'back', 3, 'Backpage');
        }
    }


    include $footer;
} else {
    header("loaction:index.php");
}
