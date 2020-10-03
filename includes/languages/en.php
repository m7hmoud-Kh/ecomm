<?php 

  function lang ($phrase)
  {
      static $lang = array
      (
          //navbar.php
            "home"    => "Homepage ",
            "cate"     => "categories",
            "item"    =>  "Item",
            "members" =>"Members",
            "comm"    => "Comments",
            "stat"    => "STATISTICS",
            "logs"    => "LOGS",
      );

      return $lang[$phrase];
  }