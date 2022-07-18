
<?php 
session_start();
include('config/dbconn.php');
if(ISSET($_REQUEST['id_sub'])){
    $id=$_REQUEST['id_sub'];
    $id_teacher=$_GET['id_teacher'];


    $delete = "DELETE FROM `subject_affected` WHERE idSA='$id'";

    $sql2=mysqli_query($con,$delete);
    if($sql2)

    {
        $msg="Suppression de l'affectation est effectué avec success ";
        header("Location: affect_subject.php?id_teacher=".$id_teacher."&success=".$msg);
        exit(0);
    
    }
    else
    {
        $msg="Suppression echoué ";
        header("Location: affect_subject.php?id_teacher=".$id_teacher."&failed=".$msg);
        exit(0);
    } 

}
else{
    $msg="Une erreur s'est produite veuillez reessayer ulterieurement "; 
    header("Location: affect_subject.php?id_teacher=".$id_teacher."&failed=".$msg);
    exit(0);
}
?>