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
        if($stmt === false){
            unset($res);
            return;
        }
        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if( !isset($arr) ){
            unset($res);
        }else{
            $res->add("id_video",$arr['id_video']);
            $res->add("date",$arr['date']);
        }
        return $res;

    }

    function getVideoData($id_video){
        $pdo = GLOBALS::getPDO();
        $res = new YaySon();
        $sql = "SELECT video.id_video, video.description, video.name as video_name, video.date, video.length, video.path,
                    (Select Count(id_video) from user_like_video where id_action = 1) as likes,
                    (Select count(id_video) from user_like_video where id_action = 2) as dislikes,
                    users.username as uploader
                    FROM video
                    INNER JOIN users ON video.id_user = users.id_user
                    WHERE video.id_video = $id_video";
        $stmt = $pdo->query($sql);
        if($stmt === false){
            unset($res);
            return;
        }
        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if( !isset($arr) ){
            unset($res);
        }else{
            $res->add("id_video",$arr['id_video']);
            $res->add("description",$arr['description']);
            $res->add("name",$arr['video_name']);
            $res->add("date",$arr['date']);
            $res->add("path",$arr['path']);
            $res->add("likes",$arr['likes']);
            $res->add("dislikes",$arr['dislikes']);
            $res->add("username",$arr['uploader']);
        }
        return $res;

    }

    function getVideoAndThumbnail($id_video)
    {
        $res = new YaySon();
        $video = getVideoData($id_video);
        if (isset($video)) {
            $thumb = getThumbnail($id_video);
            if (isset($thumb)) {
                $video->add("thumbnail", $thumb->getArr());

            } else {
                $video->add("thumbnail", "");
            }
            $res->add("data", $video);
            $res->add("status", 200);
        } else {
            $res->add("message", "video not found");
            $res->add("status", 404);

        }
        return $res;
    }

    function getVideoComments($id_video){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql = "SELECT comments.id_comment,comments.message, users.username, users.id_user, video.name, video.id_video
                    FROM comments
                    INNER JOIN users ON comments.id_user = users.id_user
                    INNER JOIN video ON comments.id_video = video.id_video
                    WHERE video.id_video = $id_video";
    $stmt = $pdo->query($sql);
    if($stmt === false){
        unset($res);
        return;
    }
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
            $tmp->add("id_comment",$row['id_comment']);
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
    if($stmt === false){
        unset($res);
        return;
    }
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
    if($stmt === false){
        unset($res);
        return;
    }
    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if( !isset($arr) ){
        unset($res);
    }else{
        $tmpArray =array();
        foreach($arr as $row){
            $tmp = new YaySon;
            $thumb = getThumbnail($row['id_video']);
            if (isset($thumb)) {
                $tmp->add("thumbnail", $thumb->getArr());
            } else {
                $tmp->add("thumbnail", "");
            }
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

function login($email,$password){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql = "SELECT id_user,email,password,username
            FROM users
            WHERE email=" .$pdo->quote($email). "AND password=" . $pdo->quote($password);
    $stmt = $pdo->query($sql);
    if($stmt === false){
        unset($res);
        return;
    }
    $arr = $stmt->fetch(PDO::FETCH_ASSOC);
    if( !isset($arr) ){
        unset($res);
    }else{
        $res->add("id_user",$arr['id_user']);
        $res->add("email",$arr['email']);
        $res->add("password",$arr['password']);
        $res->add("username",$arr['username']);
    }
    return $res;

}

function insertThumbNail($path,$id_video){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql_insert = "INSERT INTO thumbnail (id_video,path)
                    VALUES($id_video," .$pdo->quote($path). ") RETURNING id_thumbnail ";
    $stmt = $pdo->query($sql_insert);
    if($stmt === false){
        unset($res);
        return;
    }
    $arr = $stmt->fetch(PDO::FETCH_ASSOC);
    if( !isset($arr) ){
        unset($res);
    }else{
        $res->add("id_thumbnail",$arr['id_thumbnail']);
    }
    return $res;
}

function getThumbnail($id_video){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql_insert = "SELECT id_thumbnail,path FROM thumbnail WHERE id_video =$id_video";
    $stmt = $pdo->query($sql_insert);
    if($stmt === false){
        unset($res);
        return;
    }
    $arr = $stmt->fetch(PDO::FETCH_ASSOC);
    if( !isset($arr) ){
        unset($res);
    }else{
        $res->add("id_thumbnail",$arr['id_thumbnail']);
        $res->add("path",$arr['path']);
    }
    return $res;
}