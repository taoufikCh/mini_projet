<?php
session_start();

if($_SESSION['auth']!=true){
    $_SESSION['message']="Vous devez connecter ";
    header("Location: login.php");
    exit(0);
}

if($_SESSION['role']==="1"){
    header("Location: admin/index.php");
    exit(0);
}

if($_SESSION['role']==="2"){
    header("Location: teacher/index.php");
    exit(0);
}

if($_SESSION['role']==="3"){
    header("Location: student/index.php");
    exit(0);
}

?>