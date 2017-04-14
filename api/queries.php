<?php
    include_once("Globals.php");
    include_once("YaySon.php");
    function insert_video($pdo,$id_user,$name,$description,$length,$path){
        // construct SQL insert statement
        $res = new YaySon();
        $sql_insert = "INSERT INTO video(id_user,name,description,length,date,path)
                       VALUES
                       (" . $id_user . ",". $pdo->quote($name) . "," .$pdo->quote($description) . "," .
                        $pdo->quote($length) . "," . 'current_date' . "," . $pdo->quote($path) .") RETURNING id_video,date";
        $stmt = $pdo->query($sql_insert);
        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if( !isset($arr) ){
            $res->add("status",500);
            $res->add("message","An error has ocurred");
        }else{
            $res->add("id_video",$arr['id_video']);
            $res->add("date",$arr['date']);
            $res->add("status",200);
        }
        return $res;
}