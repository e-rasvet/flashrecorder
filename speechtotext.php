<?php

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');  

    $audio = base64_decode($_POST['audio']); /// .wav
    $audioname = $_POST['name'];
    $key   = $_POST['key'];  /// it is key from flash var [key]
    
    $time = time();
    //$a = $_GET['a'];
    
    /*
    $fp = fopen('speechlog.txt', 'a+');
    fwrite($fp, $a."::".$time."::".$audioname."::".$key."\n");
    fclose($fp);
    */
    
    $newname = $audioname.'_'.$key;
    
    $dirroot = '/var/kut/netcourse.org/www/pr/flashrecorder/';
    $ext = 'wav';
    
    $name = $newname.'.'.$ext;
    
    file_put_contents($dirroot.'speechtmp/'.$name, $audio);


///Converting process
    
    $dir = '/var/kut/netcourse.org/www/pr/flashrecorder/speechtmp/';
    $dirtmp = '/var/kut/netcourse.org/www/pr/flashrecorder/mp3tmp/';

    exec("/usr/local/bin/sox -t mp3 {$dir}{$name} {$dirtmp}tmp.flac rate 16k");
    exec('wget -q -U "Mozilla/5.0" --post-file '.$dirtmp.'tmp.flac --header="Content-Type: audio/x-flac; rate=16000" -O - "http://www.google.com/speech-api/v1/recognize?lang=en-en&client=chromium" > '.$dirtmp.'message.ret');
    exec('cat '.$dirtmp.'message.ret | sed \'s/.*utterance":"//\' | sed \'s/","confidence.*//\' > '.$dir.''.$name.'.txt');

    
    echo file_get_contents($dirroot.'speechtmp/'.$newname.'.'.$ext.'.txt');
    
    //echo "Speech text";
    
    
    /*
    if ($a == "s") {
    
      file_put_contents($dir.'speechtmp/'.$newname.'.'.$ext, $audio);
      
      shell_exec('nohup php '.$dir.'speechtotextprocess.php '.$newname.'.'.$ext.' > /dev/null &');
      
      echo "File was received";
    
    } else if ($a == "r"){
      
      if (is_file($dir.'speechtmp/'.$newname.'.'.$ext.'.txt')) {
        echo file_get_contents($dir.'speechtmp/'.$newname.'.'.$ext.'.txt');
      } else {
        echo "In process";
      }

    } else {
      //shell_exec('nohup php /var/kut/netcourse.org/www/pr/flashrecorder/speechtotextprocess.php test.wav > /dev/null &');
      echo "Please use ?a=s or ?a=r";
    }
    */
    
    