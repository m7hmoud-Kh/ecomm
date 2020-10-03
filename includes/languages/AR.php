<?php 

  function lang ($phrase)
  {
      static $lang = array
      (
        "home" => "صفحه الادمن",
        "cate" => "الفئات",
        "item"    =>  "العناصر",
        "members" =>"الاعضاء",
        "stat"    => "الاحصائيات",
        "logs"    => "التسجيل",
        
      );

      return $lang[$phrase];
  }