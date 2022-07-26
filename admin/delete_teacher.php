
<?php 
session_start();
include('config/dbconn.php');
if(ISSET($_REQUEST['id_row'])){
    $id=$_REQUEST['id_row'];


    $delete = "DELETE FROM `enseignant` WHERE numEns='$id'";

    $sql2=mysqli_query($con,$delete);
    if($sql2)

    {
        $list_course="SELECT * from coursesession WHERE id_ens='$id'";
        $res_list=mysqli_query($con, $list_course);
        if($res_list){
            foreach($res_list as $data){
                $delete_assiduite = "DELETE FROM `assiduite` WHERE id_course='".$data['id_seance']."'";
                mysqli_query($con,$delete_assiduite);
            }
            $delete_course = "DELETE FROM `coursesession` WHERE id_ens='$id'";
            mysqli_query($con,$delete_course);
        }

        $delete_sub_aff = "DELETE FROM `subject_affected` WHERE idEns='$id'";
        mysqli_query($con,$delete_sub_aff);

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