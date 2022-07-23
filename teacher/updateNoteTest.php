<?php 
session_start();
include('config/dbconn.php');
$id_assiduite = $_POST['id'];
$note = $_POST['note'];

//$id_ens=$_SESSION['auth_user']['codeuser'];

$update = "UPDATE `assiduite` SET note_test='$note' WHERE id_assiduite='$id_assiduite'"; 
 $sql2=mysqli_query($con,$update);

if($sql2)
{
   echo true;

}
else
{
    echo false;
} 

?>