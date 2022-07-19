<?php 
session_start();
include('config/dbconn.php');
$id = $_GET['id_subject'];
$name = $_POST['name'];
$coef = $_POST['coefficient'];
$cours = $_POST['hours_cours'];
$tp = $_POST['hours_tp'];

$update = "UPDATE `matieres` SET nom_mat='$name', coefMat='$coef', NbreHeureCours='$cours', NbreHeureTP='$tp' WHERE id_mat='$id'";

 $sql2=mysqli_query($con,$update);
 if($sql2)

{
    
    $msg="Modification de la matière est effectué avec success ";
    header("Location: manage_subjects.php?status=".$msg);
    exit(0);
}
else
{

  $msg="Modification echoué ";
 header("Location: edit_subject.php?id_subject=".$id."&status=".$msg);
 exit(0);
} 

?>