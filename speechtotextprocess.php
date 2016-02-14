<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  


$name = $argv[1];

$dir = '/var/kut/netcourse.org/www/pr/flashrecorder/speechtmp/';
$dirtmp = '/var/kut/netcourse.org/www/pr/flashrecorder/mp3tmp/';

exec("/usr/local/bin/sox -t mp3 {$dir}{$name} {$dirtmp}tmp.flac rate 16k");
exec('wget -q -U "Mozilla/5.0" --post-file '.$dirtmp.'tmp.flac --header="Content-Type: audio/x-flac; rate=16000" -O - "http://www.google.com/speech-api/v1/recognize?lang=en-en&client=chromium" > '.$dirtmp.'message.ret');
exec('cat '.$dirtmp.'message.ret | sed \'s/.*utterance":"//\' | sed \'s/","confidence.*//\' > '.$dir.''.$name.'.txt');


