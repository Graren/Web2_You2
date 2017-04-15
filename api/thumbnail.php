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
    if(!isset($_SESSION["email"]) && !isset($_SESSION["name"])){
    }
    else {
    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            if (isset($_GET["id_video"])) {
                $videoData = getVideoAndThumbnail($_GET["id_video"]);
                $path = $videoData->get("data")->get('thumbnail')["path"];
                if (file_exists($path)) {//this can also be a png or jpg
                    //Set the content-type header as appropriate
                    $imageInfo = getimagesize($path);
                    switch ($imageInfo[2]) {
                        case IMAGETYPE_JPEG:
                            header("Content-Type: image/jpeg");
                            break;
                        case IMAGETYPE_GIF:
                            header("Content-Type: image/gif");
                            break;
                        case IMAGETYPE_PNG:
                            header("Content-Type: image/png");
                            break;
                        default:
                            break;
                    }

                    // Set the content-length header
                    header('Content-Length: ' . filesize($path));

                    // Write the image bytes to the client
                    readfile($path);

                }else{
                    echo "FUCK";
                }

            }
    }
}