<?php

/*************************** connect.php in index.php ***************************/
$connection = "C:\\xampp\htdocs\php_mah\\eCommerce\admincp\\connect.php";
include $connection;
/********************************************************************************/

$stpl = "C:\\xampp\htdocs\php_mah\\eCommerce\adminCP\includes\\templates\\"; //for include templates


// Routs
$css = "includes/templates/layout/css";
$js = "includes/templates/layout/js";


$english = "C:\\xampp\htdocs\php_mah\\eCommerce\adminCP\includes\\languages\\en.php";
include $english;

/******************************* AR.php in index.php ********* *************/
//$arbic = "C:\\xampp\htdocs\php_mah\\eCommerce\adminCP\includes\\languages\\AR.php";
//include $arbic;
/******************************************************************************** */

/***************************** include function************************************** */
$func = "C:\\xampp\htdocs\php_mah\\eCommerce\adminCP\includes\\functions\\";
include $func . "fun.php";

$header = $stpl . "header.php";
include $header;

if (!isset($nonav)) {
    $navbar = $stpl . "navbar.php";
    include $navbar;
}



$footer = $stpl . "footer.php";