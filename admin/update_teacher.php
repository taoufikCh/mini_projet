<?php 
session_start();
include('config/dbconn.php');
$id = $_GET['id_row'];

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$birthday = $_POST['birthday'];
$email = $_POST['email'];
$date_embauche = $_POST['date_embauche'];
$grade = $_POST['grade'];

$update = "UPDATE `enseignant` SET prenom='$firstname', nom='$lastname', dateNaissance='$birthday', adresseMail='$email' , dateEmbauche='$date_embauche', grade='$grade' WHERE numEns='$id'"; 
 $sql2=mysqli_query($con,$update);
 if($sql2)
{
    
    $msg="La modification de l'enseignant est effectué avec success ";
    header("Location: manage_teacher.php?success=".$msg);
    exit(0);
}
else
{

  $msg="Modification echoué ";
 header("Location: edit_teacher.php?id_row=".$id."&failed=".$msg);
 exit(0);
} 

?>