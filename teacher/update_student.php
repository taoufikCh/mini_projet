<?php 
session_start();
include('config/dbconn.php');
$id = $_GET['id_student'];

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$birthday = $_POST['birthday'];
$email = $_POST['email'];
$num_inscrit = $_POST['num_inscrit'];
$date_inscrit = $_POST['date_inscrit'];
$groupe = $_POST['groupe'];

$update = "UPDATE `etudiant` SET prenomEtd='$firstname', nomEtd='$lastname', DateNaissanceEtd='$birthday', adresseMailEtd='$email' , numInscription='$num_inscrit', dateInscription='$date_inscrit', groupe='$groupe' WHERE numEtd='$id'"; 
 $sql2=mysqli_query($con,$update);
 if($sql2)

{
    
    $msg="La modification de l'étudiant est effectué avec success ";
    header("Location: manage_student.php?success=".$msg);
    exit(0);
}
else
{

  $msg="Modification echoué ";
 header("Location: edit_student.php?id_student=".$id."&failed=".$msg);
 exit(0);
} 

?>