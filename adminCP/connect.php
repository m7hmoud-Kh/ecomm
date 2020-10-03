<?php
$host = "mysql:host=localhost;dbname=shop";
$user = "root";
$password = "";


try
{
  $con =new PDO($host,$user,$password);
}
catch(PDOException $e)
{
  echo "not connected " . $e->getMessage();
}

