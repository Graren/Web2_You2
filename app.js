function $(id){
  return document.getElementById(id);
}

var xhr = new XMLHttpRequest();
var myFile = "";

function upload(){
  var fd = new FormData();
  fd.append("file", $("file").files[0]);
  fd.append("dildo", "Some unknown data");
  myFile = $("file").files[0].name;

    xhr.onreadystatechange = () => {
      if ( xhr.status === 200 & xhr.readyState === 4){
        $('fileStatus').textContent = xhr.responseText;
      }
    }
    xhr.open("POST", "./api/video.php",true);
    xhr.send(fd);
}

function download(){
//   var xhr = new XMLHttpRequest();
//   var url = "./api/video.php?id_video=41";
//    xhr.open("GET", url, true);
//   xhr.onprogress = function(e) {
//                  console.log(e.target.response);
//                }
//                xhr.onreadystatechange = function() {
//                  if (xhr.readyState == 4) {
//                    console.log("Complete = " + xhr.responseText);
//                  }
//                }
// xhr.send();


  var url = "./api/video.php?id_video=41";
  var source = document.createElement('source');
  source.setAttribute('src', url);
  $("vid").src = url;
  $('vid').play();
}
download();
