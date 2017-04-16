<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 4/14/2017
 * Time: 7:40 PM
 */

    include_once("connection.php");
    include_once ("queries.php");
    include_once("Globals.php");
    include_once("YaySon.php");
    session_start();
    $res = new YaySon();
    header("Content-Type: application/json");
    if(!isset($_SESSION["email"]) or !isset($_SESSION["name"]) or $_SERVER['REQUEST_METHOD'] !== "GET"){
        $res->add("status",403);
        $res->add("message","Forbidden");
    }
    else{
        $query = $_GET['q'];
        $page = $_GET['page'];
        $resultJSON = getVideosByNamePaginated($query,$page);
        if($resultJSON){
            $res->add("data",$resultJSON->getArr());
            $res->add("status",200);
        }
        else{
            $res->add("status",500);
            $res->add("message","Nothing Found");
        }
    }
    echo $res->toJSON();