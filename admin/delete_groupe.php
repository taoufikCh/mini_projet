
<?php 
session_start();
include('config/dbconn.php');
if(ISSET($_REQUEST['id_row'])){
    $id=$_REQUEST['id_row'];


    $delete = "DELETE FROM `groupe` WHERE idGroupe='$id'";

    $sql2=mysqli_query($con,$delete);
    if($sql2)

    {
        $msg="Suppression du groupe est effectué avec success ";
        header("Location: manage_groupe.php?success=".$msg);
        exit(0);
    
    }
    else
    {
        $msg="Suppression echoué ";
        header("Location: manage_groupe.php?failed=".$msg);
        exit(0);
    } 

}
else{
    $msg="Une erreur s'est produite veuillez reessayer ulterieurement "; 
    header("Location: manage_groupe.php?failed=".$msg);
    exit(0);
}
?>