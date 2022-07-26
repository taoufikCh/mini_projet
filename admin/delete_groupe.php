
<?php 
session_start();
include('config/dbconn.php');
if(ISSET($_REQUEST['id_row'])){
    $id=$_REQUEST['id_row'];


    $delete = "DELETE FROM `groupe` WHERE idGroupe='$id'";

    $sql2=mysqli_query($con,$delete);
    if($sql2)

    {   $list_course="SELECT * from coursesession WHERE id_groupe='$id'";
        $res_list=mysqli_query($con, $list_course);
        if($res_list){
            foreach($res_list as $data){
                $delete_assiduite = "DELETE FROM `assiduite` WHERE id_course='".$data['id_seance']."'";
                mysqli_query($con,$delete_assiduite);
            }
            $delete_course = "DELETE FROM `coursesession` WHERE id_groupe='$id'";
            mysqli_query($con,$delete_course);
        }
        $list_student="SELECT * from etudiant WHERE groupe='$id'";
        $res_student=mysqli_query($con, $list_student);
        if($res_student){
            foreach($res_student as $data){
                $update_student = "UPDATE `etudiant` SET groupe='' WHERE numEtd='".$data['numEtd']."'"; 
                mysqli_query($con,$update_student);
            }
        }
        $delete_sub_gr = "DELETE FROM `subject_groupe` WHERE idGroupe ='$id'";
        mysqli_query($con,$delete_sub_gr);

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