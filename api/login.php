<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 4/13/2017
 * Time: 10:54 PM
 */
    header("Content-Type: application/json");
    include_once("connection.php");
    include_once ("queries.php");
    include_once("Globals.php");
    include_once("YaySon.php");
    session_start();
    $res = new YaySon();
    if(isset($_SESSION["email"]) or isset($_SESSION["name"])){
        $res->add("status",403);
        $res->add("message","You are alredy logged in");
    }
    else{
        $email = isset($_POST["email"])?
            $_POST["email"] : null;
        $password = isset($_POST["password"])?
            $_POST["password"] : null;
        if($email && $password){
            $data = login($email,$password);
            if($data){
                $_SESSION["name"] = $data->get('username');
                $_SESSION["email"] = $email;
                $_SESSION["id_user"] = $data->get("id_user");
                $res->add("status",200);
                $res->add("data",$data->getArr());
            }else{
                $res->add("status",404);
                $res->add("message","User not found");
            }
        }else{
            $res->add("status",409);
            $res->add("message","Conflict");
        }
    }
echo $res->toJSON();
