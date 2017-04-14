<?php
    include_once("connection.php");
    include_once ("queries.php");
    include_once("Globals.php");
    include_once("YaySon.php");

    function RandomString()
    {
        return substr(md5(rand()), 0, 7);
    }

    function getSingleVideo($id_video){
        $res = new YaySon();
        $data = getVideoData($_GET["id_video"]);

        if(!isset($data)){
            $res->add("status",404);
            $res->add("message","File not found");
        }
        else{
            $data->add("comments",getVideoComments($id_video)->get('comments'));
            $data->add("tags",getVideoTags($id_video)->get('tags'));
            $res->add("status",200);
            $res->add("data", $data->getArr());
        }
        return $res;
    }

    function getAll(){
        //I AM NOT GENERATING THUMBNAILS, SEE react-native-asset-thumbnail
        // CONSIDER THE FOLLOWING WITH exec_shell or exec ffmpeg -i $filename -vframes 1 -an -s 400x360 -ss 20 $outputFileName . ".jpg"
        //        -i = Inputfile name
        //        -vframes 1 = Output one frame
        //        -an = Disable audio
        //        -s 400x222 = Output size
        //        -ss 30 = Grab the frame from 30 seconds into the video
        $res = new YaySon();
        $data = getAllVideos();
        if(!isset($data)){
            $res->add("status",404);
            $res->add("message","File not found");
        }
        else{
            $res->add("status",200);
            $res->add("data", $data->get('videos'));
        }
        return $res;
    }

    header("Content-Type: application/json");
    $res = new YaySon();
    session_start();
    if(!isset($_SESSION["email"]) && !isset($_SESSION["username"])){
        $res->add("status",403);
        $res->add("message","FUCK MAN LOGIN");
        echo $res->toJSON();
    }
    else{
        switch($_SERVER['REQUEST_METHOD']){
            case "GET":
                if(isset($_GET["id_video"])){
                    $id_video = $_GET["id_video"];
                    $res = getSingleVideo($id_video);
                }
                else{
                    $res = getAll();
                }
                echo $res->toJSON();
                break;
            case"POST":
                //I AM NOT GENERATING THUMBNAILS, SEE react-native-asset-thumbnail
                // CONSIDER THE FOLLOWING WITH exec_shell or exec ffmpeg -i $filename -vframes 1 -an -s 400x360 -ss 20 $outputFileName . ".jpg"
                //        -i = Inputfile name
                //        -vframes 1 = Output one frame
                //        -an = Disable audio
                //        -s 400x222 = Output size
                //        -ss 30 = Grab the frame from 30 seconds into the video
                if(!is_uploaded_file($_FILES['file']['tmp_name'])){

                    $res->add("status",403);
                    $res->add("message","File required");
                }
                else{
                    $allowedExts = array("mp4","ogg","webm","pdf");
                    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                    $data = new YaySon();
                    $data->add('id_user',$_POST["id_user"]);
                    $data->add('description',$_POST["description"]);
                    $data->add('length',$_POST["length"]);
                    $data->add('name',$_FILES["file"]["name"]);
                    if ( ( ($_FILES["file"]["type"] == "video/mp4")
                        || ($_FILES["file"]["type"] == "video/ogg")
                        || ($_FILES["file"]["type"] == "video/webm")
                        || ($_FILES["file"]["type"] == "application/pdf")
                        && in_array($extension, $allowedExts)) )
                    {
                        if ($_FILES["file"]["error"] > 0)
                        {
                            $res->add("status",500);
                            $res->add("message","An error has ocurred");
                        }
                        else
                        {
                            $savedName = RandomString()."_". $_FILES["file"]["name"];
                            if(!file_exists(Globals::getProjectRoute(). "../../static")){
                                echo "MAKING DIR";
                                mkdir(Globals::getProjectRoute(). "../../static");
                            }
                            $insertResult =insert_video($_POST["id_user"],$_FILES["file"]["name"],$_POST["description"],
                                $_POST["length"],Globals::getVideoPath() . $savedName);

                            if(isset($insertResult)){
                                move_uploaded_file($_FILES["file"]["tmp_name"],
                                    Globals::getVideoPath(). $savedName) or die ("FAGGOT");
                                $data->add("id_video",$insertResult->get('status'));
                                $data->add("date",$insertResult->get('date'));
                                $res->add("status",200);
                                $res->add("data", $data->getArr());
                            }
                            else{
                                $res->add("status",500);
                                $res->add("message","An error has ocurred");
                            }
                        }
                    }
                    else
                    {
                        $res->add("status",403);
                        $res->add("message","Invalid file type");
                    }
                }
                echo $res->toJSON();
                break;
        }
    }
?>
