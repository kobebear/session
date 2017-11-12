<?php
$filename='online.txt';//数据文件
$onlinetime=30;//在线有效时间，单位：秒 (即600等于10分钟)
/*****每次执行php，都先遍历并检查现有online.txt文件内容****/
$online=file($filename);
//PHP file() 函数把整个文件读入一个数组中。与 file_get_contents() 类似，不同的是 file() 将文件作为一个数组返回。数组中的每个单元都是文件中相应的一行，包括换行符在内。如果失败，则返回 false
//获得请求时，服务器的时间
$nowtime=$_SERVER['REQUEST_TIME'];
//定义新的数组，准备保存未过期的用户会话列表
$nowonline=[];
//得到仍然有效的数据
foreach($online as $line){
  $row=explode('|',$line);
  $sesstime=trim($row[1]);
  if(($nowtime - $sesstime)<=$onlinetime){//如果仍在有效时间内，则数据继续保存，否则被放弃不再统计
    $nowonline[$row[0]]=$sesstime;//获取在线列表到数组，会话ID为键名，最后通信时间为键值
  }
}
/************处理完现有session记录后，再判断新session是否需要被记录************/
session_start();
@$uid=$_SESSION["uid"];
if($uid==null){//如果没有SESSION即是初次访问
  $vid=0;//初始化访问者ID
  do{//给用户一个新ID
    $vid++;
    $uid='U'.$vid;
  }while(array_key_exists($uid,$nowonline));
  var_dump($uid);
  $_SESSION["uid"]=$uid;
}
$nowonline[$uid]=$nowtime;//更新现在的时间状态
//统计现在在线人数
$total_online=count($nowonline);
//写入数据
if($fp=@fopen($filename,'w')){
  if(flock($fp,LOCK_EX)){
    rewind($fp);
    foreach($nowonline as $fuid=>$ftime){
      $fline=$fuid.'|'.$ftime."\n";
      @fputs($fp,$fline);
    }
    flock($fp,LOCK_UN);
    fclose($fp);
  }
}
echo 'document.write("'.$total_online.'");';