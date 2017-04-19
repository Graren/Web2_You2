<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 4/18/2017
 * Time: 5:17 PM
 */

echo __DIR__ . '../static/';
echo $data = shell_exec("ffmpeg -i ". "C:/Users/Oscar/Desktop/necrofantasia.mp4" . " 2>&1 | grep \"Duration\"| cut -d ' ' -f 4 | sed s/,// | sed 's@\..*@@g' | awk '{ split($1, A, \":\"); split(A[3], B, \".\"); print 3600*A[1] + 60*A[2] + B[1] }'");
var_dump( explode("\n",$data)[1]);