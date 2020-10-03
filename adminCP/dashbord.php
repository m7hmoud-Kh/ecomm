<?php
session_start();
if (isset($_SESSION["user"])) {
    $pagetitle = "dashbord";
    include "init.php";

    $lastuser = 5 ;
    $thelastuser = getlast("*","users","ID",$lastuser);

    $lastitem = 5 ; 
    $thelastitem = getlast("*","items","ID", $lastitem);

    $lastcomment = 5;
    $thelastcomments = getlast("*","comments","com_id", $lastcomment);
?>
                <div class="container home_stat text-center">
                    <h1 class="text-center">Dashbord</h1>
                    <div class="row ">
                        <div class="col-md-3">
                         <div class="stat st-member">
                               <i class="fa fa-users"></i>
                                <div class="info">
                                    total member
                                    <p> <a href="member.php"><?php echo countitem('ID','users' ); ?></a></p>
                                 </div>
                            </div>
                          </div>
                        <div class="col-md-3">
                            <div class="stat  st-pending">
                                <i class="fa fa-user-plus"></i>
                              <div class="info">
                              pending member
                                <p><a href="member.php?page=pending"><?php echo checkitem('regstatus','users',0 ); ?></a></p>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat st-item">
                                <i class="fa fa-tags"></i>
                               <div class="info">
                               total item
                                <p><a href="item.php"><?php echo countitem('ID','items'); ?></a></p>
                               </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat st-comment">
                                <i class="fa fa-comment"></i>
                              <div class="info">
                              total comments
                                <p><a href="comment.php"> <?php echo  countitem("com_id" ,"comments") ?></a></p>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container lastest">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="panel">
                                <div class="panel_head">
                                    <i class="fa fa-users"></i> lastest <?php echo $lastuser ; ?> register users
                                    <div class="toggleplus">
                                       <i class="fa fa-plus"></i>
                                     </div>
                                </div>
                                <div class="panel_body">
                                <ul class="list-unstyled last_user">
                                        <?php foreach($thelastuser as $user)
                                                {
                                                    echo "<li>". $user["username"] ; 
                                                    echo '<a class="btn btn-success" href="member.php?do=edit&userid='.$user["ID"] .'">
                                                    <i class="fa fa-edit"></i> Edit</a>';
                                                    if ($user["regstatus"] == 0) {
                                                        echo '<a href="member.php?do=active&userid=' . $user["ID"] . '" class="btn btn-info"> <i class="fas fa-check"></i> Accept</a>';
                                                    }
                                                    echo  '</li>';
                                                }
                                        ?>
                                        </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel">
                                <div class="panel_head">
                                    <i class="fa fa-tag"></i> lastest <?php echo  $lastitem  ?> Item tag
                                    <div class="toggleplus">
                                       <i class="fa fa-plus"></i>
                                     </div>
                                </div>
                                <div class="panel_body">
                                <ul class="list-unstyled last_user">
                                    <?php foreach($thelastitem as $items)
                                            {
                                                echo "<li>". $items["name"] ; 
                                                echo '<a class="btn btn-success" href="item.php?do=edit&item_id='.$items["ID"] .'">
                                                <i class="fa fa-edit"></i> Edit</a>';
                                                if ($items["approv"] == 0) {
                                                    echo '<a href="item.php?do=approv&item_id=' . $items["ID"] . '" class="btn btn-info"> <i class="fas fa-check"></i> Approv</a>';
                                                }
                                                echo  '</li>';
                                            }
                                    ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel comments">
                                <div class="panel_head">
                                    <i class="fa fa-comments"></i> lastest <?php echo  $lastcomment ; ?> comments tag
                                    <div class="toggleplus to_com">
                                       <i class="fa fa-plus"></i>
                                     </div>
                                </div>
                                <div class="panel_body">
                                <ul class="list-unstyled last_user">
                                  <?php
                                  
                                  $stmt = $con->prepare("SELECT comments.* , items.* , users.*
                                                        FROM comments 
                                                        INNER JOIN items ON comments.item_id = items.ID 
                                                        INNER JOIN users ON comments.mem_id  = users.ID
                                                        ORDER BY comments.com_id DESC LIMIT $lastcomment");

                                 $stmt->execute();
                               $formations =  $stmt->fetchAll();
                                 $count = $stmt->rowCount();
                                 if($count > 0)
                                 {
                                     foreach($formations as $for){
                                     ?>
                                       <div class="commentbox">
                                        <span class="name_c">
                                            <?php echo $for["username"]; ?> 
                                            [<a href="item.php"><?php echo $for["name"]; ?></a> ] </span>
                                        <p class="comment"><?php echo $for["comment"]; ?></p>
                                       </div>

                                     <?php
                                     }
                                 }
                                 else
                                 {
                                     echo "<div class='alert alert-info'>no comments here !!</div>";
                                 }



                                



                                  ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php
    include $footer;
 

  
} else {
    header("location:index.php");
    exit();
}

