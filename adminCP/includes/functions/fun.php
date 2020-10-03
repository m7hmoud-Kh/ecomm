<?php

/*
 *work function get title in header  
 */
function getTile()
{
    global $pagetitle;

    if (isset($pagetitle)) {
        echo $pagetitle;
    } else {
        echo "defalut";
    }
}

/*
 * redirect function [this function accept parmeter]
 * $themeg = echo the themessage if error or success or waring
 * $url    = echo the location of page
 * $second = second before rediect
 * $name   = echo the name of page are redirect you by defalut Backpage
 */

function redirect($themeg, $url = null, $sec = 3, $name = null)
{
    if ($url === null) {
        $url = "index.php";
    } else {
        if (isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] !== "") {
            $url = $_SERVER["HTTP_REFERER"];
        }
    }
    if ($name === null) {
        $name = "Backpage";
    } else {
        $name = "homepage";
    }
    echo $themeg;
    echo "<div class='alert alert-info'>You will Redirect in $name after $sec second</div>";
    header("refresh:$sec;url=$url");
    exit();
}


/**
 * Function check item in database
 * $select this item selected from table
 * $from this is name of database
 * $value this is value of select
 */

function checkitem($select, $from, $value)
{
    global $con;

    $sql = "SELECT $select FROM $from WHERE $select = '$value'";

    $stmt = $con->prepare($sql);

    $stmt->execute();

    $count = $stmt->rowCount();
    
    return $count ;
}



/**
 * item = item to choose to count
 * table = table in database
 * 
 */


 function countitem($item , $table)
 {
     global $con ;
     $s1 = "SELECT COUNT($item) FROM $table";
     $stmt = $con->prepare($s1);
     $stmt->execute();
     $count = $stmt->fetchColumn();
     
     return $count;
 }
/**
 * Function lastest item from database [username | comments]
 * 
 */
function getlast($select , $table , $order , $limit = 5 )
{
    global $con;
    $stmt = $con->prepare("SELECT $select FROM $table ORDER BY $order  DESC LIMIT $limit");
    $stmt->execute();
    $row = $stmt->fetchAll();
  
    return $row;

        
}
