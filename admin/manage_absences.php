<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');

include('config/dbconn.php');
$id=$_GET['id_seance'];

$query_course="SELECT coursesession.*, matieres.nom_mat, groupe.nomGroupe from coursesession
LEFT JOIN matieres ON coursesession.id_matiere = matieres.id_mat
LEFT JOIN groupe ON coursesession.id_groupe = groupe.idGroupe  WHERE coursesession.id_seance='".$id."'";
$res_course = mysqli_query($con, $query_course) or die (mysqli_error($con));
$row = mysqli_fetch_assoc($res_course);

$query_assiduite="SELECT *  from assiduite WHERE id_course='".$id."'";
$res_assiduite=mysqli_query($con, $query_assiduite);

$sql="SELECT * from etudiant WHERE groupe='".$row['id_groupe']."'";
$students=mysqli_query($con, $sql);

foreach($students as $data){
    $exist = false;
    foreach($res_assiduite as $info){
        if($data['numEtd']===$info['id_etudiant'])
        {
            $exist = true;
        }
    }
    if(!$exist){
        $id_course = $row['id_seance'];
        $id_etudiant = $data['numEtd'];
        $sql_insert = "INSERT INTO `assiduite`(`id_course`, `id_etudiant`) VALUES ('$id_course', '$id_etudiant')";
        $query= mysqli_query($con,$sql_insert);
    }

}
   
$query_assid="SELECT assiduite.*, etudiant.* from assiduite
LEFT JOIN etudiant ON assiduite.id_etudiant = etudiant.numEtd WHERE assiduite.id_course='".$id."'";
$res_assuiduite=mysqli_query($con, $query_assid);
    
?>

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Information sur la séance du cours</h6>
        </div>
        <?php if(isset($_GET['success'])){
                echo '<div class="card bg-success text-white shadow"><div class="card-body">'.$_GET['success'].'</div></div>';
               } ?>
                        <?php if(isset($_GET['failed'])){
                                echo '<div class="card bg-danger text-white shadow"><div class="card-body">'.$_GET['failed'].'</div></div>';
                        } ?>
        <div class="card-body">
                <div style="color:#000">
                    <table class="table"  width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Matière</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Heure début</th>
                                <th>Heure fin</th>
                                <th>Groupe</th>
                                <th>Test </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="background-color:#fddddd">
                                <td><?php echo $row['nom_mat']; ?></td>
                                <td>
                                    <?php if($row['type_seance']=="1") echo "Cours";
                                        if($row['type_seance']=="2") echo "TP";  ?>
                                </td>
                                <td><?php echo $row['date_seance']; ?></td>
                                <td><?php echo $row['heure_debut']; ?></td>
                                <td><?php echo $row['heure_fin']; ?></td>
                                <td><?php echo $row['nomGroupe']; ?></td>
                                <td>
                                    <?php if($row['test_evaluation']=="0") echo "Non";
                                        if($row['test_evaluation']=="1") echo "Oui";  ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> 
            
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Suivi Absences</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Absence</th>
                                        <th>Note Test</th>
                                    </tr>
                                </thead>
                            <tbody>
                                <?php foreach($res_assuiduite as $data){ ?>
                                    <tr>
                                        <td><?php echo $data['numEtd']; ?></td>
                                        <td><?php echo $data['nomEtd']; ?></td>
                                        <td><?php echo $data['prenomEtd']; ?></td>
                                        <td><input type="checkbox" disabled id="sltAbs<?php echo $data['id_assiduite']; ?>"  <?php if($data['isAbsent']==="1") echo "checked" ?> > </td>
                                        <td><?php if($row['test_evaluation']=="1"){?>
                                            <input type="number" disabled   value="<?php echo $data['note_test']; ?>"  > 
                                            <?php } ?> 
                                        </td>
                                    </tr>                                        
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
 
</script>
<?php
include('includes/footer.php');
include('includes/scripts.php');
?>
