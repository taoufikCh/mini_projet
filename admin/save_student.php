<?php 
session_start();
include('config/dbconn.php');
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$birthday = $_POST['birthday'];
$email = $_POST['email'];
$num_inscrit = $_POST['num_inscrit'];
$date_inscrit = $_POST['date_inscrit'];
$groupe = $_POST['groupe'];

// =genere_password = 
$password=md5("123456");


$sql = "INSERT INTO `etudiant`( `nomEtd`, `prenomEtd`, `DateNaissanceEtd`, `adresseMailEtd`, `numInscription`, `dateInscription`, `password`, `groupe`) VALUES 
('$lastname', '$firstname', '$birthday', '$email', '$num_inscrit', '$date_inscrit', '$password', '$groupe' )";
$query= mysqli_query($con,$sql);
//$lastId = mysqli_insert_id($con);
if($query ==true)
{
    //send mail password
    $msg="Insertion de l'étudiant est effectué avec success ";
    header("Location: manage_student.php?success=".$msg);
    exit(0);

}
else
{
    $msg="Insertion echoué ";
    header("Location: add_student.php?failed=".$msg);
    exit(0);
} 

?>