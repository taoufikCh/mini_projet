
<?php 
session_start();
include('config/dbconn.php');
if(ISSET($_REQUEST['id_seance'])){
    $id=$_REQUEST['id_seance'];


    $delete = "DELETE FROM `coursesession` WHERE id_seance='$id'";

    $sql2=mysqli_query($con,$delete);
    if($sql2)

    {
        $msg="Suppression de la séance du cours est effectué avec success ";
        header("Location: manage_course_sessions.php?success=".$msg);
        exit(0);
    
    }
    else
    {
        $msg="Suppression echoué ";
        header("Location: manage_course_sessions.php?failed=".$msg);
        exit(0);
    } 

}
else{
    $msg="Une erreur s'est produite veuillez reessayer ulterieurement "; 
    header("Location: manage_course_sessions.php?failed=".$msg);
    exit(0);
}
?>