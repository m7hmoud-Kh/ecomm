<?php

/*
  categories =>  [mange | add | edit | delete | insert]
*/

$do = '';

if (isset($_GET["do"])) {
    $do = $_GET["do"]; // after ?
} else {
    $do = "mange";
}

if ($do == "mange") {
    echo "<a href='page.php?do=add'> add new categories</a>";
} elseif ($do == "add") {
    echo "welecom in Add page";
} elseif ($do == "insert") {
    echo "welecome in insert page";
} else {
    echo "ERROR there was no page with this name";
}
