<?php 
session_start();
include('config/dbconn.php');
$id = $_GET['id_row'];

$nomgroupe = $_POST['nomGroupe'];

$update = "UPDATE `groupe` SET nomGroupe='$nomgroupe' WHERE idGroupe='$id'"; 
 $sql2=mysqli_query($con,$update);
 if($sql2)
{
    
    $msg="La modification du groupe est effectué avec success ";
    header("Location: manage_groupe.php?success=".$msg);
    exit(0);
}
else
{

  $msg="Modification echoué ";
 header("Location: edit_groupe.php?id_row=".$id."&failed=".$msg);
 exit(0);
} 

?>