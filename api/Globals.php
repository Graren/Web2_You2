<?php

 class Globals
{
    private static $_DB;
    public  static function getVideoPath() {
        return 'C:\xampp\htdocs\Web2_You2\static\\';
    }

    public static function getProjectRoute(){
        return realpath(dirname(__FILE__));
    }

    public static function setPDO($pdo){
        Globals::$_DB = $pdo;
    }

    public static function getPDO(){
        return Globals::$_DB;
    }
}