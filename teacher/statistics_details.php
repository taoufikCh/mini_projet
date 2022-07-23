<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');

include('config/dbconn.php');


$id_subject = $_POST['subject'];
$id_groupe = $_POST['groupe'];

$id_ens = $_SESSION['auth_user']['codeuser'];

$query_mat="SELECT * from matieres where id_mat='".$id_subject."'";
$res_mat=mysqli_query($con, $query_mat);
$data_mat = mysqli_fetch_assoc($res_mat);

$query_gr="SELECT * from groupe WHERE idGroupe='".$id_groupe."'";
$res_gr = mysqli_query($con, $query_gr) or die ( mysqli_error());
$data_gr = mysqli_fetch_assoc($res_gr);

$query = "SELECT * from coursesession 
     where id_matiere='".$id_subject."' and id_groupe='".$id_groupe."' and id_ens='".$id_ens."'";
$res = mysqli_query($con, $query);
$heure_cours = 0;
$heure_tp = 0;
$nbr_test = 0;
foreach($res as $info){
    $heure_debut = strtotime($info['date_seance']." ".$info['heure_debut']);
    $heure_fin = strtotime($info['date_seance']." ".$info['heure_fin']);
    $totalSecondsDiff = abs($heure_debut-$heure_fin); // en seconde
    $totalHoursDiff   = $totalSecondsDiff/3600; // en hours
    if($info['type_seance']==="1") $heure_cours+= $totalHoursDiff;
    else $heure_tp+= $totalHoursDiff;

    if($info['test_evaluation']==="1") $nbr_test+=1;
    
   
}


?>

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Statistique sur une matière par groupe</h6>
        </div>
        <div class="card-body">
            <div style="background-color:#d8e0e7">
                <div class="mb-3 row">
                    <label class="col-md-3 form-label font-weight-bold text-danger">Nom de la matière : </label>
                    <div class="col-md-3"><?php echo $data_mat['nom_mat']; ?></div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-3 form-label font-weight-bold text-default">Nom du groupe : </label>
                    <div class="col-md-3"><?php echo $data_gr['nomGroupe']; ?></div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-3 form-label font-weight-bold text-primary">Nombre d'heures de cours réalisées : </label>
                    <div class="col-md-3"><?php echo $heure_cours."/".$data_mat['NbreHeureCours']; ?></div>
                </div> 
                <div class="mb-3 row">
                    <label class="col-md-3 form-label font-weight-bold text-success">Nombre d'heures de TP réalisées : </label>
                    <div class="col-md-3"><?php echo $heure_tp."/".$data_mat['NbreHeureTP']; ?></div>
                </div>  
                <div class="mb-3 row">
                    <label class="col-md-3 form-label font-weight-bold text-info">Nombre de Test d'évaluation réalisés : </label>
                    <div class="col-md-3"><?php echo $nbr_test; ?></div>
                </div> 
            </div>
           <div>
           <h6 class="m-0 font-weight-bold"> Répartition des étudiants selon leur moyenne (supérieure/ inférieure à 10) de la matière</h6>
           </div>
            <div>
                            
            </div>
                       
        </div>
</div>
</div>


<?php
include('includes/footer.php');
include('includes/scripts.php');
?>
