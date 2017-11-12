<?php
require_once("init.php");
@$uname=$_REQUEST["uname"];
@$upwd=$_REQUEST["upwd"];
if($uname&&$upwd){
  $sql="select uid from xz_user where uname='$uname' and binary upwd='$upwd'";
  $result=mysqli_query($conn,$sql);
  $user=mysqli_fetch_row($result);
  if($user){
    session_start();
    $_SESSION["uid"]=$user[0];
    echo "true";
  }else{
    echo "false";
  }
}