
<?php 
session_start();
include('config/dbconn.php');
if(ISSET($_REQUEST['id_row'])){
    $id=$_REQUEST['id_row'];


    $delete = "DELETE FROM `enseignant` WHERE numEns='$id'";

    $sql2=mysqli_query($con,$delete);
    if($sql2)

    {
        $msg="Suppression de l'enseignant est effectué avec success ";
        header("Location: manage_teacher.php?success=".$msg);
        exit(0);
    
    }
    else
    {
        $msg="Suppression echoué ";
        header("Location: manage_teacher.php?failed=".$msg);
        exit(0);
    } 

}
else{
    $msg="Une erreur s'est produite veuillez reessayer ulterieurement "; 
    header("Location: manage_teacher.php?failed=".$msg);
    exit(0);
}
?>