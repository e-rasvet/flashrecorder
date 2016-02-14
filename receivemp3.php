<?php

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');  

    $audio     = base64_decode($_POST['audio']);
    $audioname = $_POST['name'];
    $audiotext = $_POST['text']; ///optional
    $p         = $_POST['p']; ///Other optional variables by [p]
    
    $time = time();
    
    $fp = fopen('mp3log.txt', 'a+');
    fwrite($fp, $time."::".$audioname."::".$audiotext."::".$p."\n");
    fclose($fp);
    
    file_put_contents('/var/kut/netcourse.org/www/pr/flashrecorder/mp3tmp/'.$time.'.mp3', $audio);
    
    echo json_encode(array("p1"=>"v1", "p2"=>"v2"));  /// Optional need add to callback js