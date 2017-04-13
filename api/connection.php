<?php
$__USERNAME__ = 'postgres';
$__PASSWORD__ = "masterkey";
  try{
    $_DB = new PDO('pgsql:dbname=You2;host=localhost;user='. $__USERNAME__ .';password=' .$__PASSWORD__);
  } catch (PDOException $e){
    echo $e->getMessage();
  }
?>
