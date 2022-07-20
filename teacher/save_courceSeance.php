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
$id_ens=$_SESSION['auth_user']['codeuser'];

$sql = "INSERT INTO `coursesession`(  `id_matiere`, `id_groupe`, `id_ens`, `date_seance`, `heure_debut`, `heure_fin`, `type_seance`, `test_evaluation`) VALUES 
('$id_matiere', '$id_groupe', '$id_ens', '$date_seance', '$heure_debut', '$heure_fin', '$type_seance', '$test_eval' )";
$query= mysqli_query($con,$sql);
//$lastId = mysqli_insert_id($con);
if($query ==true)
{
    //send mail password
    $msg="Insertion de la séance du cours est effectué avec success ";
    header("Location: manage_course_sessions.php?success=".$msg);
    exit(0);

}
else
{
    $msg="Insertion echoué ";
    header("Location: manage_course_sessions.php?failed=".$msg);
    exit(0);
} 

?>