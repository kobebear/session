<?php
//接收客户端发来的code
@$code=$_REQUEST["code"];
//用客户端的code和session中提前保存好的code比较
//要用session中的数据，必须先打开session
session_start();
//不区分大小写
if(strtolower($code)
    ==strtolower($_SESSION["code"]))
  echo "true";
else
  echo "false";