<?php

/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 4/13/2017
 * Time: 7:35 PM
 */
class YaySon
{
    private $arr;

    function __construct() {
        $this->arr = array();
    }

    public function add($key,$value){
        $this->arr[$key] = $value;
    }

    public function get($key){
        if(array_key_exists($key,$this->arr)){
            return $this->arr[$key];
        }
        return null;
    }

    public function toJSON(){
        return json_encode($this->arr);
    }

    public function getArr()
    {
        return $this->arr;
    }
}

