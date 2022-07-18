
<?php 
session_start();
include('config/dbconn.php');
if(ISSET($_REQUEST['id_sub'])){
    $id=$_REQUEST['id_sub'];
    $id_groupe=$_GET['id_groupe'];


    $delete = "DELETE FROM `subject_groupe` WHERE idSG ='$id'";

    $sql2=mysqli_query($con,$delete);
    if($sql2)

    {
        $msg="Suppression de l'affectation est effectué avec success ";
        header("Location: groupe_details.php?id_groupe=".$id_groupe."&success=".$msg);
        exit(0);
    
    }
    else
    {
        $msg="Suppression echoué ";
        header("Location: groupe_details.php?id_groupe=".$id_groupe."&failed=".$msg);
        exit(0);
    } 

}
else{
    $msg="Une erreur s'est produite veuillez reessayer ulterieurement "; 
    header("Location: groupe_details.php?id_groupe=".$id_groupe."&failed=".$msg);
    exit(0);
}
?>