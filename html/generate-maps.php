<?php
#$output = shell_exec('ls -lart');
#$output = shell_exec('java test');

#$fp = fsockopen("localhost", 60009, $errno, $errstr, 30);
$fp = fsockopen("172.16.32.9", 60009, $errno, $errstr, 30);
if (!$fp) {
    echo "$errstr ($errno)<br />\n";
} else {
    $out = "a b c d\n";
    fwrite($fp, $out);

        echo fgets($fp);
    fclose($fp);
}

#$output = shell_exec('/usr/bin/java LoadPrograms');
#echo "<pre>$output</pre>";
#echo "called after all\n";

$con = mysql_connect("localhost","root","linhtinh");
#echo "$con";
if (!$con){
  die('Could not connect: ' . mysql_error());
}

$senderArray = array();
$recArray = array();
$prrArray = array();

$result = mysql_query("SELECT send_addr, rec_addr, PRR FROM auth.linkQuality");
while ($row = mysql_fetch_array($result)) {
array_push($senderArray,$row{'send_addr'});
array_push($recArray,$row{'rec_addr'});
array_push($prrArray,$row{'PRR'});
}
mysql_close($con);


// create a 400*400 image
$img = imagecreatetruecolor(400, 400);

// allocate some colors
$white = imagecolorallocate($img, 255, 255, 255);
$red   = imagecolorallocate($img, 255,   0,   0);
$green = imagecolorallocate($img,   0, 255,   0);
$blue  = imagecolorallocate($img,   0,   0, 255);

imagearc($img,  60,  75,  50,  50,  0, 360, $red); // Node A
imagearc($img, 240,  75,  50,  50,  0, 360, $white); // Node B
imagearc($img, 60, 240, 50, 50, 0, 360, $green); // Node C
//imagearc($img, 240, 240, 50, 50, 0, 360, $blue); // Node D

for($i=0; $i < count($senderArray); ++$i){

if($senderArray[$i] == 0){
$aToBprr = $prrArray[$i];
$aToCprr = $prrArray[$i+1];
if($aToBprr < 90){
$color = $white;
}else{
$color = $blue;
}
imageline($img,60,75,240,75,$color);
if($aToCprr < 90){
$color = $white;
}else{
$color = $blue;
}
imageline($img, 60,75,60,240,$color);


//imageline($img,60,75,240,240,$color);
}
if($senderArray[$i] == 1){
$bToAprr = $prrArray[$i];
$bToCprr = $prrArray[$i+1];
if($bToAprr < 90){
$color = $white;
}else{
$color = $blue;
}
imageline($img, 240,75,60,85,$color);
if($bToCprr < 90){
$color = $white;
}else{
$color = $blue;
}
imageline($img,240,75,70,240,$color);

//imageline($img,240,75,250,240,$color);

}
if($senderArray[$i] == 2){
$cToAprr = $prrArray[$i];
$cToBprr = $prrArray[$i+1];
if($cToAprr < 90){
$color = $white;
}else{
$color = $blue;
}
imageline($img, 60,240,70,75,$color);
if($cToBprr < 90){
$color = $white;
}else{
$color = $blue;
}
imageline($img, 60,240,240,75,$color);


//imageline($img,60,240,240,240,$color);
}
}
//imageline($img, 240,240,70,75,$blue);
//imageline($img,240,240,240,75,$blue);
//imageline($img,240,250,60,240,$blue);
// output image in the browser
header("Content-type: image/png");
#imagejpeg($img,'connectivity.jpg');
imagejpeg($img);

// free memory
imagedestroy($img);


?>
