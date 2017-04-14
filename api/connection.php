<?php
    include_once ("Globals.php");
    $__USERNAME__ = 'postgres';
    $__PASSWORD__ = "masterkey";
    try{
      $_DB = new PDO('pgsql:dbname=You2;host=localhost;user='. $__USERNAME__ .';password=' .$__PASSWORD__);
      Globals::setPDO($_DB);
    } catch (PDOException $e){
      echo $e->getMessage();
    }

?>
