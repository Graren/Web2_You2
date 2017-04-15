<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 4/14/2017
 * Time: 7:24 PM
 */

    include_once("connection.php");
    include_once ("queries.php");
    include_once("Globals.php");
    include_once("YaySon.php");
    session_start();
    $res = new YaySon();
    header("Content-Type: application/json");
    if(!isset($_SESSION["email"]) or !isset($_SESSION["name"]) or $_SERVER['REQUEST_METHOD'] !== "POST"){
        $res->add("status",403);
        $res->add("message","Forbidden");
    }
    else{
        $id_video = $_POST['id_video'];
        $id_user = $_POST['id_user'];
        $resultJSON = dislikeVideo($id_video,$id_user);
        if($resultJSON->get('created') !== false){
            $res->add("data",$resultJSON->getArr());
            $res->add("status",200);
        }
        else{
            $res->add("status",500);
            $res->add("message","Error disliking");
        }
    }
    echo $res->toJSON();