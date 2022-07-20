<?php 
session_start();
include('config/dbconn.php');
$id_groupe = $_POST['groupe'];
$id_matiere = $_POST['subject'];
$date_seance = $_POST['date_seance'];
$heure_debut = $_POST['heure_debut'];
$heure_fin = $_POST['heure_fin'];
$type_seance = $_POST['type_seance'];
$test_eval = $_POST['test_eval'];
//$id_ens=$_SESSION['auth_user']['codeuser'];

$id = $_GET['id_row'];

$update = "UPDATE `coursesession` SET id_matiere='$id_matiere', id_groupe='$id_groupe', date_seance='$date_seance', heure_debut='$heure_debut',
 heure_fin='$heure_fin',type_seance='$type_seance', test_evaluation='$test_eval'  WHERE id_seance='$id'"; 
 $sql2=mysqli_query($con,$update);

if($sql2 ==true)
{
    //send mail password
    $msg="modification de la séance du cours est effectué avec success ";
    header("Location: manage_course_sessions.php?success=".$msg);
    exit(0);

}
else
{
    $msg="modification echoué ";
    header("Location: edit_courseSeance.php?id_seance=".$id."&failed=".$msg);
    exit(0);
} 

?>