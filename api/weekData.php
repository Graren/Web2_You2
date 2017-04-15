<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 4/14/2017
 * Time: 10:12 PM
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
            $likes = getLastWeekLikes($id_video);
            $dislikes = getLastWeekDislikes($id_video);
            if(isset($likes) && isset($dislikes)){
                $tmp = new YaySon();
                $tmp->add("likes",$likes->get('data'));
                $tmp->add("dislikes",$dislikes->get('data'));
                $res->add("data",$tmp->getArr());
                $res->add("status",200);
            }
            else{
                $res->add("status",500);
                $res->add("message","Nothing Found");
            }
        }
    echo $res->toJSON();