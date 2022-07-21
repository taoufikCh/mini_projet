<?php 
session_start();
include('config/dbconn.php');
$id_assiduite = $_POST['id'];
$isAbsent = $_POST['absent'];

//$id_ens=$_SESSION['auth_user']['codeuser'];

$id = $_GET['id_row'];

$update = "UPDATE `assiduite` SET isAbsent='$isAbsent' WHERE id_assiduite='$id_assiduite'"; 
 $sql2=mysqli_query($con,$update);

if($sql2 ==true)
{
   return true;

}
else
{
    return false;
} 

?>