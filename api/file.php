<?php
include_once("connection.php");
$allowedExts = array("mp4","ogg","webm");
$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
var_dump($_FILES['file']);
$rows = $_DB->query("Select * from actions");
if($rows !== false){
  foreach ($rows as $row) {
    print_r($row);
  }
}
if ( ( ($_FILES["file"]["type"] == "video/mp4")
        || ($_FILES["file"]["type"] == "video/ogg")
        || ($_FILES["file"]["type"] == "video/webm")
        && in_array($extension, $allowedExts)) )
    {
    if ($_FILES["file"]["error"] > 0)
      {
      echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
      }
    else
      {
      echo "Upload: " . $_FILES["file"]["name"] . "<br />";
      echo "Type: " . $_FILES["file"]["type"] . "<br />";
      echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
      echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

      if (file_exists("upload/" . $_FILES["file"]["name"]))
        {
        echo $_FILES["file"]["name"] . " already exists. ";
        }
      else
        {
        // move_uploaded_file($_FILES["file"]["tmp_name"],
        // "upload/" . $_FILES["file"]["name"]);
        echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
        }
      }
  }
else
  {
  echo "Invalid file";
  }
?>
