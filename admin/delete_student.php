
<?php 
session_start();
include('config/dbconn.php');
if(ISSET($_REQUEST['id_student'])){
    $id=$_REQUEST['id_student'];


    $delete = "DELETE FROM `etudiant` WHERE numEtd='$id'";

    $sql2=mysqli_query($con,$delete);
    if($sql2)

    {
        $msg="Suppression de l'étudiant est effectué avec success ";
        header("Location: manage_student.php?success=".$msg);
        exit(0);
    
    }
    else
    {
        $msg="Suppression echoué ";
        header("Location: manage_student.php?failed=".$msg);
        exit(0);
    } 

}
else{
    $msg="Une erreur s'est produite veuillez reessayer ulterieurement "; 
    header("Location: manage_student.php?failed=".$msg);
    exit(0);
}
?>