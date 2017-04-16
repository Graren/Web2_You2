<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 4/14/2017
 * Time: 2:06 PM
 */
    include_once("connection.php");
    include_once ("queries.php");
    include_once("Globals.php");
    include_once("YaySon.php");
    session_start();
    $res = new YaySon();
    header("Content-Type: application/json");
    if(!isset($_SESSION["email"]) && !isset($_SESSION["username"])){
        $res->add("status",403);
        $res->add("message","You are not allowed");
    }
    else{
        $username = isset($_SESSION["name"])?
            $_SESSION["name"] : null;
        $email = isset($_SESSION["email"])?
            $_SESSION["email"] : null;
        if($email && $username){
            $data = closeAcount($email);
            if($data){
                session_destroy();
                $res->add("status",200);
                $res->add('message','Account closed, I hope youtube makes you happier than I do :(');
            }else{
                session_destroy();
                $res->add("status",500);
                $res->add("message","Something went wrong");
            }
        }else{
            $res->add("status",409);
            $res->add("message","Conflict");
        }
    }
    echo $res->toJSON();