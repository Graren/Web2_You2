<?php
    include_once("Globals.php");
    include_once("YaySon.php");
// Fix every function, get every $arr under an else, if stmt fails, it must not execute
///////////////////////////////////video/////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
    function insert_video($id_user,$name,$description,$length,$path,$tags){
        // construct SQL insert statement
        $pdo = GLOBALS::getPDO();
        $res = new YaySon();
        $sql_insert = "INSERT INTO video(id_user,name,description,length,date,path)
                       VALUES
                       (" . $id_user . ",". $pdo->quote($name) . "," .$pdo->quote($description) . "," .
                        $pdo->quote($length) . "," . 'current_date' . "," . $pdo->quote($path) .") RETURNING id_video,date";
        $stmt = $pdo->query($sql_insert);
        if($stmt === false){
            $res = false;;

        }
        else{
            $arr = $stmt->fetch(PDO::FETCH_ASSOC);
            if( $arr === false ){
                $res = false;;
            }else{
                foreach($tags as $tag){
                    $found = getTagByName($tag);
                    $id_tag = null;
                    if($found->get('found')){
                        $id_tag = $found->get('id_tag');
                    }
                    else{
                        $id_tag = insertTag($tag)->get('id_tag');
                    }
                    $done = insertTagsToVideo($arr['id_video'],$id_tag)->get('created');
                    if($done == false){
                        $res->add('message','something went wrong adding tags');
                    }
                }
                $res->add("id_video",$arr['id_video']);
                $res->add("date",$arr['date']);
            }
        }
        return $res;
    }


    function getVideoData($id_video){
        $pdo = GLOBALS::getPDO();
        $res = new YaySon();
        $sql = "SELECT video.id_video, video.description, video.name as video_name, video.date, video.length, video.path,
                    (Select Count(id_video) from user_like_video where id_action = 1 and id_video=$id_video) as likes,
                    (Select count(id_video) from user_like_video where id_action = 2 and id_video=$id_video) as dislikes,
                    users.username as uploader
                    FROM video
                    INNER JOIN users ON video.id_user = users.id_user
                    WHERE video.id_video = $id_video";
        $stmt = $pdo->query($sql);
        if($stmt === false){
            $res = false;;
        }
        else{
            $arr = $stmt->fetch(PDO::FETCH_ASSOC);
            if( $arr === false ){
                $res = false;;
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
        }
        return $res;

    }

    function getVideosByNamePaginated($query,$page){
        $limit=10;
        $offset= 10 * ($page-1);
        $pdo = GLOBALS::getPDO();
        $res = new YaySon();
        $sql = "SELECT video.id_video, video.description, video.name as video_name, video.date, video.length, video.path,
                users.username as uploader
                FROM video
                INNER JOIN users ON video.id_user = users.id_user ";
        $words = explode(" ",$query);
        $index = 0;
        foreach($words as $word){
            if($index === 0){
                $sql .= "WHERE video.name LIKE '%" .$word. "%' ";
            }
            else{
                $sql .= "OR video.name LIKE '%" .$word. "%' ";
            }
            $index++;
        }
        $sql .= "LIMIT $limit OFFSET $offset";
        $stmt = $pdo->query($sql);
        if($stmt === false){
            $res = false;;
        }
        else{
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if( $arr === false ){
                $res = false;;
            }else{
                $tmpArray =array();
                foreach($arr as $row){
                    $tmp = new YaySon;
                    $tmp->add("id_video",$row['id_video']);
                    $tmp->add("description",$row['description']);
                    $tmp->add("name",$row['video_name']);
                    $tmp->add("date",$row['date']);
                    $tmp->add("path",$row['path']);
                    $tmp->add("username",$row['uploader']);
                    array_push($tmpArray,$tmp->getArr());
                }
                $res->add("videos",$tmpArray);
            }
        }
        return $res;
    }

    function getUserVideosPaginated($id_user,$page){
        $limit=10;
        $offset= 10 * ($page-1);
        $pdo = GLOBALS::getPDO();
        $res = new YaySon();
        $sql = "SELECT video.id_video, video.description, video.name as video_name, video.date, video.length, video.path,
                    users.username as uploader
                    FROM video
                    INNER JOIN users ON video.id_user = users.id_user
                    WHERE users.id_user= $id_user ";
        $sql .= "LIMIT $limit OFFSET $offset";
        $stmt = $pdo->query($sql);
        if($stmt === false){
            $res = false;;
        }
        else{
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if( $arr === false ){
                $res = false;;
            }else{
                $tmpArray =array();
                foreach($arr as $row){
                    $tmp = new YaySon;
                    $tmp->add("id_video",$row['id_video']);
                    $tmp->add("description",$row['description']);
                    $tmp->add("name",$row['video_name']);
                    $tmp->add("date",$row['date']);
                    $tmp->add("path",$row['path']);
                    $tmp->add("username",$row['uploader']);
                    $thumb = getThumbnail($row['id_video']);
                    if (isset($thumb)) {
                        $tmp->add("thumbnail", $thumb->getArr());

                    } else {
                        $tmp->add("thumbnail", "");
                    }
                    array_push($tmpArray,$tmp->getArr());
                }
                $res->add("videos",$tmpArray);
            }
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

function getAllVideos(){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql = "SELECT video.id_video, video.description, video.name as video_name, video.date, video.length,
                    users.username as uploader
                    FROM video
                    INNER JOIN users ON video.id_user = users.id_user";
    $stmt = $pdo->query($sql);
    if($stmt === false){
        $res = false;;
    }
    else{
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if( $arr === false ){
            $res = false;;
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
    }
    return $res;
}

function getAllVideosPaginated($page){
    $limit=10;
    $offset= 10 * ($page-1);
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql = "SELECT video.id_video, video.description, video.name as video_name, video.date, video.length,
                    users.username as uploader
                    FROM video
                    INNER JOIN users ON video.id_user = users.id_user
                    LIMIT $limit OFFSET $offset";
    $stmt = $pdo->query($sql);
    if($stmt === false){
        $res = false;;
    }
    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if( $arr === false ){
        $res = false;;
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
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////Likes///////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
function likeVideo($id_video,$id_user){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $hasLiked = hasUserLiked($id_video,$id_user);
    $sql=null;
    if(!$hasLiked){
        $sql = "INSERT INTO user_like_video(id_video,id_user,id_action,date)
                       VALUES (".$id_video .",". $id_user .",1" .",". "current_date" .") RETURNING id_video,id_user";
    }
    else{
        $sql = "UPDATE user_like_video SET id_action=1, date=current_date
                WHERE id_video=$id_video AND id_user=$id_user RETURNING id_video,id_user" ;
    }
    $stmt = $pdo->query($sql);
    if($stmt === false){
        $res->add('created',false);
    }
    else {
        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if( $arr === false ){
            $res->add('created',false);
        }else{
            $res->add("id_video",$arr['id_video']);
            $res->add("id_user",$arr['id_user']);
            $res->add("created",true);
        }
    }
    return $res;
}

function dislikeVideo($id_video,$id_user){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $hasLiked = hasUserLiked($id_video,$id_user);
    $sql=null;
    if(!$hasLiked){
        $sql = "INSERT INTO user_like_video(id_video,id_user,id_action)
                       VALUES (".$id_video .",". $id_user .",". "2"  .",". "current_date" .") RETURNING id_video,id_user";
    }
    else{
        $sql = "UPDATE user_like_video SET id_action=2, date=current_date
                WHERE id_video=$id_video AND id_user=$id_user RETURNING id_video,id_user";
    }
    $stmt = $pdo->query($sql);
    if($stmt === false){
        $res->add('created',false);
    }
    else {
        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if( $arr === false ){
            $res->add('created',false);
        }else{
            $res->add("id_video",$arr['id_video']);
            $res->add("id_user",$arr['id_user']);
            $res->add("created",true);
        }
    }
    return $res;
}

function hasUserLiked($id_video,$id_user){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql = "SELECT id_video, id_user FROM user_like_video
                    WHERE id_user=$id_user AND id_video=$id_video" ;
    $stmt = $pdo->query($sql);
    if($stmt === false){
        return false;
    }
    else {
        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if( $arr === false ){
            return false;
        }else{
            return true;
        }
    }
}

function getLastWeekLikes($id_video){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql = "Select (select count(id_action) FROM user_like_video WHERE date = current_date AND id_action=1 AND id_video = $id_video) as day_7, (Select current_date) as d7,
	(select count(id_action) FROM user_like_video WHERE date = current_date - interval '1 day' AND id_action=1 AND id_video = $id_video) as day_6, (Select current_date - interval '1 day') as d6,
	(select count(id_action) FROM user_like_video WHERE date = current_date - interval '2 day' AND id_action=1 AND id_video = $id_video) as day_5, (Select current_date - interval '2 day') as d5,
	(select count(id_action) FROM user_like_video WHERE date = current_date - interval '3 day' AND id_action=1 AND id_video = $id_video) as day_4, (Select current_date - interval '3 day') as d4,
	(select count(id_action) FROM user_like_video WHERE date = current_date - interval '4 day' AND id_action=1 AND id_video = $id_video) as day_3, (Select current_date - interval '4 day') as d3,
	(select count(id_action) FROM user_like_video WHERE date = current_date - interval '5 day' AND id_action=1 AND id_video = $id_video) as day_2, (Select current_date - interval '5 day') as d2,
	(select count(id_action) FROM user_like_video WHERE date = current_date - interval '6 day' AND id_action=1 AND id_video = $id_video) as day_1, (Select current_date - interval '6 day') as d1";

    $stmt = $pdo->query($sql);
    if($stmt === false){
        $res = false;;
    }
    else{

        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if( $arr === false ){
            $res->add('finished',false);
            $res = false;;
        }else{
            $dayData =new YaySon();
            for($i = 1; $i < 8; $i++){
                $y = new YaySon();
                $y->add("date",$arr["d$i"]);
                $y->add("day_$i",$arr["day_$i"]);
                $dayData->add("day_$i",$y->getArr());
            }
            $res->add("data",$dayData->getArr());
            $res->add("finished",true);
        }
    }
    return $res;
}

function getLastWeekDislikes($id_video){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql = "Select (select count(id_action) FROM user_like_video WHERE date = current_date AND id_action=2 AND id_video = $id_video) as day_7, (Select current_date) as d7,
	(select count(id_action) FROM user_like_video WHERE date = current_date - interval '1 day' AND id_action=2 AND id_video = $id_video) as day_6, (Select current_date - interval '1 day') as d6,
	(select count(id_action) FROM user_like_video WHERE date = current_date - interval '2 day' AND id_action=2 AND id_video = $id_video) as day_5, (Select current_date - interval '2 day') as d5,
	(select count(id_action) FROM user_like_video WHERE date = current_date - interval '3 day' AND id_action=2 AND id_video = $id_video) as day_4, (Select current_date - interval '3 day') as d4,
	(select count(id_action) FROM user_like_video WHERE date = current_date - interval '4 day' AND id_action=2 AND id_video = $id_video) as day_3, (Select current_date - interval '4 day') as d3,
	(select count(id_action) FROM user_like_video WHERE date = current_date - interval '5 day' AND id_action=2 AND id_video = $id_video) as day_2, (Select current_date - interval '5 day') as d2,
	(select count(id_action) FROM user_like_video WHERE date = current_date - interval '6 day' AND id_action=2 AND id_video = $id_video) as day_1, (Select current_date - interval '6 day') as d1";

    $stmt = $pdo->query($sql);
    if($stmt === false){
        $res = false;;
    }
    else{

        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if( $arr === false ){
            $res->add('finished',false);
            $res = false;;
        }else{
            $dayData =new YaySon();
            for($i = 1; $i < 8; $i++){
                $y = new YaySon();
                $y->add("date",$arr["d$i"]);
                $y->add("day_$i",$arr["day_$i"]);
                $dayData->add("day_$i",$y->getArr());
            }
            $res->add("data",$dayData->getArr());
            $res->add("finished",true);
        }
    }
    return $res;
}
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////comment//////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
    function insertVideoComment($id_video,$id_user,$comment){
        $pdo = GLOBALS::getPDO();
        $res = new YaySon();
        $sql_insert = "INSERT INTO comment(id_video,id_user,message)
                       VALUES (".$id_video .",". $id_user .",". $pdo->quote($comment).") RETURNING id_comment,id_video,id_user,message" ;
        $stmt = $pdo->query($sql_insert);
        if($stmt === false){
            $res->add('created',false);
        }
        else {
            $arr = $stmt->fetch(PDO::FETCH_ASSOC);
            if( $arr === false ){
                $res->add('created',false);
            }else{
                $res->add("id_video",$arr['id_video']);
                $res->add("id_user",$arr['id_user']);
                $res->add("id_comment",$arr['id_comment']);
                $res->add("message",$arr['message']);
                $res->add("created",true);
            }
        }
        return $res;
    }

    function getVideoComments($id_video){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql = "SELECT comment.id_comment,comment.message, users.username, users.id_user, video.name, video.id_video
                    FROM comment
                    INNER JOIN users ON comment.id_user = users.id_user
                    INNER JOIN video ON comment.id_video = video.id_video
                    WHERE video.id_video = $id_video";
    $stmt = $pdo->query($sql);
    if($stmt === false){
        $res = false;;
        return;
    }
    else{
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if( $arr === false ){
            $res = false;;
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
    }
    return $res;
}
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////TAGS///////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
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
        $res = false;;
        return;
    }
    else{
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if( $arr === false ){
            $res = false;;
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
    }
    return $res;
}
function getTagByName($tag){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql_insert = "SELECT id_tag FROM tag WHERE name=$tag";
    $stmt = $pdo->query($sql_insert);
    if($stmt === false){
        $res->add('found',false);
    }
    else {
        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if( $arr === false ){
            $res->add('found',false);
        }else{
            $res->add("id_tag",$arr['id_tag']);
            $res->add("found",true);
        }
    }
    return $res;
}
function insertTagsToVideo($id_video,$id_tag){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql_insert = "INSERT INTO video_tag
                      (id_video,id_tag) values($id_video,$id_tag) returning id_tag";
    $stmt = $pdo->query($sql_insert);
    if($stmt === false){
        $res->add('created',false);
    }
    else {
        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if( $arr === false ){
            $res->add('created',false);
        }else{
            $res->add("id_tag",$arr['id_tag']);
            $res->add("created",true);
        }
    }
    return $res;
}
function insertTag($name){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql_insert = "INSERT INTO tag
                      (name) values( " . $pdo->quote($name) .")RETURNING id_tag";
    $stmt = $pdo->query($sql_insert);
    if($stmt === false){
        $res->add('created',false);
    }
    else {
        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if( $arr === false ){
            $res->add('created',false);
        }else{
            $res->add("id_tag",$arr['id_tag']);
            $res->add("created",true);
        }
    }
    return $res;
}
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////user///////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
function login($email,$password){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql = "SELECT id_user,email,password,username
            FROM users
            WHERE email=" .$pdo->quote($email). "AND password=" . $pdo->quote($password) ." AND is_active =true";
    $stmt = $pdo->query($sql);
    if($stmt === false){
        $res = false;
    }
    else{
        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if( $arr === false ){
            $res = false;
        }else{
            $res->add("id_user",$arr['id_user']);
            $res->add("email",$arr['email']);
            $res->add("password",$arr['password']);
            $res->add("username",$arr['username']);
        }
    }
    return $res;
}

function signUp($email,$password,$username){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql = "INSERT INTO users (email,password,username,creation_date,is_active)
            VALUES(".$pdo->quote($email). ","
                    .$pdo->quote($password).","
                    .$pdo->quote($username).",".
                    "current_date,".
                    "true".") RETURNING id_user,email,username";
    $stmt = $pdo->query($sql);
    if($stmt === false){
        $res = false;;
        return;
    }
    else{
        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if( $arr === false ){
            $res = false;;
        }else{
            $res->add("id_user",$arr['id_user']);
            $res->add("email",$arr['email']);
            $res->add("username",$arr['username']);
        }
    }
    return $res;
}

function closeAcount($email){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql_insert = "UPDATE users SET end_date=current_date, is_active=FALSE
                    WHERE email=". $pdo->quote($email).
        "AND is_active=true " ."RETURNING id_user";
    $stmt = $pdo->query($sql_insert);
    if($stmt === false){
        $res = false;;
        return;
    }
    else{
        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if( $arr === false ){
            $res = false;;
        }else{
            $res->add("id_user",$arr['id_user']);
        }
    }
    return $res;
}

function getUserData($username){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql = "SELECT id_user,email,username
            FROM users
            WHERE username=" . $pdo->quote($username) ;
    $stmt = $pdo->query($sql);
    if($stmt === false){
        $res = false;;
        return;
    }
    else{
        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if( $arr === false ){
            $res = false;;
        }else{
            $res->add("id_user",$arr['id_user']);
            $res->add("email",$arr['email']);
            $res->add("username",$arr['username']);
        }
    }
    return $res;
}

function getProfileData($username,$page){
    $res = new YaySon();
    $user = getUserData($username);
    $videos = getUserVideosPaginated($user->get('id_user'),$page);
    $res->add('user',$user->getArr());
    $res->add('videos',$videos->getArr());
    return $res;
}
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////thumbnail///////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
function insertThumbNail($path,$id_video){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql_insert = "INSERT INTO thumbnail (id_video,path)
                    VALUES($id_video," .$pdo->quote($path). ") RETURNING id_thumbnail ";
    $stmt = $pdo->query($sql_insert);
    if($stmt === false){
        $res = false;;
        return;
    }
    else{
        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if( $arr === false ){
            $res = false;;
        }else{
            $res->add("id_thumbnail",$arr['id_thumbnail']);
        }
    }
    return $res;
}

function getThumbnail($id_video){
    $pdo = GLOBALS::getPDO();
    $res = new YaySon();
    $sql_insert = "SELECT id_thumbnail,path FROM thumbnail WHERE id_video =$id_video";
    $stmt = $pdo->query($sql_insert);
    if($stmt === false){
        $res = false;;
        return;
    }
    else{
        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if( $arr === false ){
            $res = false;;
        }else{
            $res->add("id_thumbnail",$arr['id_thumbnail']);
            $res->add("path",$arr['path']);
        }
    }
    return $res;
}

/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
