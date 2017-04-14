<?php
    include_once("Globals.php");
    include_once("YaySon.php");

    function insert_video($id_user,$name,$description,$length,$path){
        // construct SQL insert statement
        $pdo = GLOBALS::getPDO();
        $res = new YaySon();
        $sql_insert = "INSERT INTO video(id_user,name,description,length,date,path)
                       VALUES
                       (" . $id_user . ",". $pdo->quote($name) . "," .$pdo->quote($description) . "," .
                        $pdo->quote($length) . "," . 'current_date' . "," . $pdo->quote($path) .") RETURNING id_video,date";
        $stmt = $pdo->query($sql_insert);
        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if( !isset($arr) ){
            unset($res);
        }else{
            $res->add("id_video",$arr['id_video']);
            $res->add("date",$arr['date']);
            $res->add("status",200);
        }
        return $res;

    }

    function getVideoData($id_video){
        $pdo = GLOBALS::getPDO();
        $res = new YaySon();
        $sql = "SELECT video.id_video, video.description, video.name as video_name, video.date, video.length,
                    (Select Count(id_video) from user_like_video where id_action = 1) as likes,
                    (Select count(id_video) from user_like_video where id_action = 2) as dislikes,
                    users.username as uploader
                    FROM video
                    INNER JOIN users ON video.id_user = users.id_user
                    WHERE video.id_video = $id_video";
        $stmt = $pdo->query($sql);
        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if( !isset($arr) ){
            unset($res);
        }else{
            $res->add("id_video",$arr['id_video']);
            $res->add("description",$arr['description']);
            $res->add("name",$arr['video_name']);
            $res->add("date",$arr['date']);
            $res->add("likes",$arr['likes']);
            $res->add("dislikes",$arr['dislikes']);
            $res->add("username",$arr['uploader']);
        }
        return $res;

    }

    function getVideoComments($id_video){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql = "SELECT comments.message, users.username, users.id_user, video.name, video.id_video
                    FROM comments
                    INNER JOIN users ON comments.id_user = users.id_user
                    INNER JOIN video ON comments.id_video = video.id_video
                    WHERE video.id_video = $id_video";
    $stmt = $pdo->query($sql);
    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if( !isset($arr) ){
        unset($res);
    }else{
        $tmpArray =array();
        foreach($arr as $row){
            $tmp = new YaySon;
            $tmp->add("id_user",$row['id_user']);
            $tmp->add("name",$row['name']);
            $tmp->add("username",$row['username']);
            $tmp->add("comment",$row['message']);
            array_push($tmpArray,$tmp->getArr());
        }
        $res->add("comments",$tmpArray);
    }
    return $res;
}

    function getVideoTags($id_video){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql = "SELECT tag.name, tag.id_tag, video.id_video
                        FROM video
                        INNER JOIN video_tag ON video.id_video = video_tag.id_video
                        INNER JOIN tag ON video_tag.id_tag = tag.id_tag
                        WHERE video.id_video = $id_video";
    $stmt = $pdo->query($sql);
    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if( !isset($arr) ){
        unset($res);
    }else{
        $tmpArray =array();
        foreach($arr as $row){
            $tmp = new YaySon;
            $tmp->add("id_tag",$row['id_tag']);
            $tmp->add("name",$row['name']);
            array_push($tmpArray,$tmp->getArr());
        }
        $res->add("tags",$tmpArray);
    }
    return $res;
}

    function getAllVideos(){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql = "SELECT video.id_video, video.description, video.name as video_name, video.date, video.length,
                    users.username as uploader
                    FROM video
                    INNER JOIN users ON video.id_user = users.id_user";
    $stmt = $pdo->query($sql);
    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if( !isset($arr) ){
        unset($res);
    }else{
        $tmpArray =array();
        foreach($arr as $row){
            $tmp = new YaySon;
            $tmp->add("id_video",$row['id_video']);
            $tmp->add("description",$row['description']);
            $tmp->add("name",$row['video_name']);
            $tmp->add("date",$row['date']);
            $tmp->add("username",$row['uploader']);
            array_push($tmpArray,$tmp->getArr());
        }
        $res->add("videos",$tmpArray);
    }
    return $res;
}

