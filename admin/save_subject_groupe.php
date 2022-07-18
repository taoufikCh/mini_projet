<?php 
session_start();
include('config/dbconn.php');
$id_groupe = $_POST['id_groupe'];
$subject = $_POST['subject'];


$sql = "INSERT INTO `subject_groupe`( `idGroupe`, `IdMatiere`) VALUES 
('$id_groupe', '$subject' )";
$query= mysqli_query($con,$sql);
//$lastId = mysqli_insert_id($con);
if($query ==true)
{
    //send mail password
    $msg="Affectation de la matière est effectué avec success ";
    header("Location: groupe_details.php?id_groupe=".$id_groupe."&success=".$msg);
    exit(0);

}
else
{
    $msg="Affectation echoué ";
    header("Location: groupe_details.php?id_groupe=".$id_groupe."&failed=".$msg);
    exit(0);
} 

?>