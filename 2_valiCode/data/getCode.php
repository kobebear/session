<?php
header("Content-Type:image/PNG");
$num=4; $w=60; $h=20;
$data="abcdefghijkmnpqrstuvwxyQWERTYUIOPLKJHGFDSAZXCVBNM3456789";
$code="";
for($i=0;$i<$num;$i++){
  $code.=substr($data,rand(0,strlen($data)-1),1);
}
session_start();
$_SESSION["code"]=$code;
$im=imagecreate($w,$h);
$black=imagecolorallocate($im,0,0,0);
$gray=imagecolorallocate($im,200,200,200);
$bgcolor=imagecolorallocate($im,255,255,255);
imagefill($im,0,0,$gray);//填充背景
imagerectangle($im,0,0,$w-1,$h-1,$black);//画边框
for($i=0;$i<80;$i++){
  imagesetpixel($im,rand(0,$w),rand(0,$h),$black);
}
$strx=rand(3,8);
for($i=0;$i<$num;$i++){
  $stry=rand(1,6);
  imagestring(
    $im,5,$strx,$stry,substr($code,$i,1),$black
  );
  $strx+=rand(8,12);
}
imagepng($im);
imagedestroy($im);
