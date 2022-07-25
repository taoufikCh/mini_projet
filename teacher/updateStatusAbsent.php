<?php 
session_start();
include('config/dbconn.php');
$id_assiduite = $_POST['id'];
$isAbsent = $_POST['absent'];

//$id_ens=$_SESSION['auth_user']['codeuser'];


$update = "UPDATE `assiduite` SET isAbsent='$isAbsent' WHERE id_assiduite='$id_assiduite'"; 
 $sql2=mysqli_query($con,$update);

if($sql2 ==true)
{
    if($isAbsent==="1")
    { 
        $updatenote = "UPDATE `assiduite` SET note_test='0' WHERE id_assiduite='$id_assiduite'";
        mysqli_query($con,$updatenote); 
    }
   echo true;

}
else
{
    echo false;
} 

?>