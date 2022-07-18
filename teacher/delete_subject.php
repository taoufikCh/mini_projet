
<?php 
session_start();
include('config/dbconn.php');
if(ISSET($_REQUEST['id_subject'])){
    $sub_id=$_REQUEST['id_subject'];


    $delete = "DELETE FROM `matieres` WHERE id_mat='$sub_id'";

    $sql2=mysqli_query($con,$delete);
    if($sql2)

    {
        $msg="Suppression de la matière est effectué avec success ";
    
    }
    else
    {
    $msg="Suppression echoué ";
    } 

}
else{
    $msg="Une erreur s'est produite veuillez reessayer ulterieurement ";
    } 
    header("Location: manage_subjects.php?status=".$msg);
    exit(0);

?>