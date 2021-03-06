<?php

 class Globals
{
    private static $_DB;
    public  static function getVideoPath() {
        return __DIR__ . '/../static/';
    }

    public static function getProjectRoute(){
        return realpath(dirname(__FILE__));
    }

    public static function setPDO($pdo){
        Globals::$_DB = $pdo;
    }

     public static function closePDO(){
         Globals::$_DB = null;
     }

    public static function getPDO(){
        return Globals::$_DB;
    }
}