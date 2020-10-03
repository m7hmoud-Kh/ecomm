<!doctype html>
<html>

<head>
    <meta charset="UTF-8" />
    <title><?php getTile(); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?php echo $css; ?>/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $css; ?>/fontawes/font1/css/all.css">
    <link rel="stylesheet" href="<?php echo $css; ?>/front.css">
</head>

<body>
    <div class="upernav">
        <div class="container">
            <div class="row">
                <?php
                if(isset($_SESSION["username"]))
                {
                    
                 echo  "<div class='welco'>". "welcome " .  $_SESSION["username"] . " <wbr> " . "</div>";
                 $countstatus =  checkstatus ($_SESSION["username"]);                      
                 if ($countstatus > 0)
                 {
                     echo  " you are not active sir by admin" ;
                 }else
                 {
                     echo "<div class='col-lg-8'>";
                        echo "<a href='porfile.php'> portfile  </a>"."<wbr>";
                        echo "<a href='newad.php'>   New Ads</a>";
                        echo "<a href='logout.php'>  logout </a>";
                     echo "</div>";
                 }
                 

                }
                else{
                ?>
                <div class="col-lg-9"></div>
                <div class="upnav col-lg-3">
                <a href="login.php">login|signup</a>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg text-center">
        <a class="navbar-brand color col-lg-5" href="index.php"><?php echo lang("home") ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto col-lg-7 text-right">
                <?php
                $stmt = $con->prepare("SELECT * FROM categor WHERE parent = 0 ORDER BY ID ASC");
                $stmt->execute();
                $cats = $stmt->fetchAll();

                foreach ($cats as $cat) {
                ?>
                    <li class="nav-item active">
                        <a class="nav-link color" href="catego.php?pagecat=<?php echo $cat["ID"]; ?>"><?php echo $cat["thename"]; ?></a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
        
    </nav>