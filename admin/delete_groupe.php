
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