<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 4/13/2017
 * Time: 10:54 PM
 */
    include_once("connection.php");
    include_once ("queries.php");
    include_once("Globals.php");
    include_once("YaySon.php");
    session_start();
    $res = new YaySon();

    if(!isset($_SESSION["email"]) or !isset($_SESSION["name"])){
        $res->add("status",403);
        $res->add("message","You have to log in");
    }
    else{
        session_destroy();
        header("Content-Type: application/json");
        $res->add("status",200);
        $res->add("message","Logged out");
    }
    echo $res->toJSON();

