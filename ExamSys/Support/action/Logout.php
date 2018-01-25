<?php

session_start();
header('Content-type:text/html;charset=utf-8');
if (isset($_SESSION['UserId']) && $_SESSION['UserId']!="") {
    session_unset();//free all session variable
    session_destroy();//销毁一个会话中的全部数据
    setcookie(session_name(), '', time() - 3600);//销毁与客户端的卡号
    header('location:../../index.php');
} else {
    echo "<script> alert('注销过程中出现未知错误'); </script>";
}