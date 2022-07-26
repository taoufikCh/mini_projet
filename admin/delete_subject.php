
<?php 
session_start();
include('config/dbconn.php');
if(ISSET($_REQUEST['id_subject'])){
    $sub_id=$_REQUEST['id_subject'];


    $delete = "DELETE FROM `matieres` WHERE id_mat='$sub_id'";

    $sql2=mysqli_query($con,$delete);
    if($sql2)

    {
        $list_course="SELECT * from coursesession WHERE id_matiere='$sub_id'";
        $res_list=mysqli_query($con, $list_course);
        if($res_list){
            foreach($res_list as $data){
                $delete_assiduite = "DELETE FROM `assiduite` WHERE id_course='".$data['id_seance']."'";
                mysqli_query($con,$delete_assiduite);
            }
            $delete_course = "DELETE FROM `coursesession` WHERE id_matiere='$sub_id'";
            mysqli_query($con,$delete_course);
        }

        $delete_sub_aff = "DELETE FROM `subject_affected` WHERE idMat='$sub_id'";
        mysqli_query($con,$delete_sub_aff);

        $delete_sub_gr = "DELETE FROM `subject_groupe` WHERE IdMatiere ='$sub_id'";
        mysqli_query($con,$delete_sub_gr);
        
        
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