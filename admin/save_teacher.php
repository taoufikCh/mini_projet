<?php 
session_start();
include('config/dbconn.php');
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$birthday = $_POST['birthday'];
$email = $_POST['email'];
$date_embauche = $_POST['date_embauche'];
$grade = $_POST['grade'];
// =genere_password = 
$password=md5("123456");


$sql = "INSERT INTO `enseignant`( `nom`, `prenom`, `dateNaissance`, `adresseMail`, `dateEmbauche`, `grade`, `password`) VALUES 
('$lastname', '$firstname', '$birthday', '$email', '$date_embauche', '$grade', '$password' )";
$query= mysqli_query($con,$sql);
//$lastId = mysqli_insert_id($con);
if($query ==true)
{
    //send mail password
    $msg="Insertion de l'enseignant est effectué avec success ";
    header("Location: manage_teacher.php?success=".$msg);
    exit(0);

}
else
{
    $msg="Insertion echoué ";
    header("Location: add_teacher.php?failed=".$msg);
    exit(0);
} 

?>