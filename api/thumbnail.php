<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 4/14/2017
 * Time: 11:26 AM
 */
include_once("connection.php");
include_once ("queries.php");
include_once("Globals.php");
include_once("YaySon.php");
include_once("Stream.php");
$res = new YaySon();
session_start();
//if(!isset($_SESSION["email"]) && !isset($_SESSION["name"])){
//}
//else {
    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            if (isset($_GET["id_video"])) {
                $videoData = getVideoAndThumbnail($_GET["id_video"]);
                $path = $videoData->get("data")->get('thumbnail')["path"];
            }
    }
//}
