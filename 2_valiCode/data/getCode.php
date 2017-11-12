<?php
//位数,宽,高
$num=4;$w=60;$h=20;
$data = 'abcdefghijkmnpqrstuvwxyQWERTYUIOPLKJHGFDSAZXCVBNM3456789';
$code = ""; 
for ($i = 0; $i < $num; $i++) { 
  $code .= substr($data, rand(0, strlen($data)-1), 1); 
} 
//4位验证码也可以用rand(1000,9999)直接生成 
//将生成的验证码写入session，备验证时用 
session_start();
$_SESSION["code"] = $code;
//创建图片，定义颜色值 
header("Content-type: image/PNG"); 
$im = imagecreate($w, $h); 
$black = imagecolorallocate($im, 0, 0, 0); 
$gray = imagecolorallocate($im, 200, 200, 200); 
$bgcolor = imagecolorallocate($im, 255, 255, 255); 
//填充背景 
imagefill($im, 0, 0, $gray); 

//画边框 
imagerectangle($im, 0, 0, $w-1, $h-1, $black); 

//在画布上随机生成大量黑点，起干扰作用; 
for ($i = 0; $i < 80; $i++) { 
  imagesetpixel($im, rand(0, $w), rand(0, $h), $black); 
} 
//将数字随机显示在画布上,字符的水平间距和位置都按一定波动范围随机生成 
$strx = rand(3, 8); 
for ($i = 0; $i < $num; $i++) { 
    //y坐标在1~6之间随机
    $strpos = rand(1, 6); 
    imagestring(
    //图片 字体大小 x y坐标       要绘制的字符串       字体颜色
      $im, 5, $strx, $strpos, substr($code,$i,1), $black
    ); 
    //每绘制完一个字，就x向右移动一个随机位置。
    $strx += rand(8, 12); 
} 
imagepng($im);//输出图片 
imagedestroy($im);//释放图片所占内存  

/*
  imagecreate()：创建一个新图像

imagecolorallocate()：为图像分配颜色

imagefill()：填充图像

imagerectangle()：画一个矩形（边框）

imagesetstyle()：设置画线风格

imageline()：画一条线段

imagesetpixel()：画点像素

imagepng()：以PNG格式将图像输出到浏览器或文件

imagedestroy()：释放图片所占内存
*/