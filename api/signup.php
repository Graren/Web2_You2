<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 4/13/2017
 * Time: 10:54 PM
 */

if(isset($_SESSION["email"]) or isset($_SESSION["username"])){
    $res->add("status",403);
    $res->add("message","FUCK MAN LOGIN");
    echo $res->toJSON();
}