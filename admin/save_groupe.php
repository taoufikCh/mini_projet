<?php 
session_start();
include('config/dbconn.php');
$nomgroupe = $_POST['nomGroupe'];
$date_create = date('d-m-Y');

$sql = "INSERT INTO `groupe`( `nomGroupe`, `dateCreation`) VALUES 
('$nomgroupe', '$date_create')";
$query= mysqli_query($con,$sql);
//$lastId = mysqli_insert_id($con);
if($query ==true)
{
    //send mail password
    $msg="Insertion du groupe est effectué avec success ";
    header("Location: manage_groupe.php?success=".$msg);
    exit(0);

}
else
{
    $msg="Insertion echoué ";
    header("Location: add_groupe.php?failed=".$msg);
    exit(0);
} 

?>