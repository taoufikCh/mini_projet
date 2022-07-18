<?php 
session_start();
include('config/dbconn.php');
$id_teacher = $_POST['id_teacher'];
$subject = $_POST['subject'];


$sql = "INSERT INTO `subject_affected`( `idEns`, `idMat`) VALUES 
('$id_teacher', '$subject' )";
$query= mysqli_query($con,$sql);
//$lastId = mysqli_insert_id($con);
if($query ==true)
{
    //send mail password
    $msg="Affectation de la matière est effectué avec success ";
    header("Location: affect_subject.php?id_teacher=".$id_teacher."&success=".$msg);
    exit(0);

}
else
{
    $msg="Affectation echoué ";
    header("Location: affect_subject.php?id_teacher=".$id_teacher."&failed=".$msg);
    exit(0);
} 

?>