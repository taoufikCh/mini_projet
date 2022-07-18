<?php 
session_start();
include('config/dbconn.php');
$name = $_POST['name'];
$coef = $_POST['coefficient'];
$cours = $_POST['hours_cours'];
$tp = $_POST['hours_tp'];

$sql = "INSERT INTO `matieres`( `nom_mat`, `coefMat`, `NbreHeureCours`, `NbreHeureTP`) VALUES 
('$name', '$coef', '$cours', '$tp' )";
$query= mysqli_query($con,$sql);
$lastId = mysqli_insert_id($con);
if($query ==true)
{
    $_SESSION['message']="Insertion de la matière est effectué avec success ";
    header("Location: manage_subjects.php");
    exit(0);
}
else
{
$_SESSION['message']="Insertion echoué ";
 header("Location: add_subject.php");
 exit(0);
} 

?>