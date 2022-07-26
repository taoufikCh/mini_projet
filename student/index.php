<?php

session_start();
include('includes/header.php');
include('includes/navbar.php');

include('config/dbconn.php');

$id_student = $_SESSION['auth_user']['codeuser'];

$query="SELECT groupe from etudiant WHERE numEtd = '$id_student'";
$res_groupe = mysqli_query($con, $query) or die (mysqli_error($con));
$row = mysqli_fetch_assoc($res_groupe);

$id_groupe = $row['groupe'];

$sql_subject="SELECT subject_groupe.*, matieres.* from subject_groupe
LEFT JOIN matieres ON subject_groupe.IdMatiere = matieres.id_mat WHERE subject_groupe.idGroupe='".$id_groupe."'";
$res_subject=mysqli_query($con, $sql_subject);
 
?>

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h2 class="h3 mb-0 text-gray-800">Bienvenue <?php echo $_SESSION['auth_user']['user_prenomnom']; ?></span>
            </h2>
    </div>
        <!-- Ajout -->
        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Mes cours</h6>
                            </div>
                           
                            <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Matière</th>
                                            <th>Coefficient</th>
                                            <th>Nbre Heure Cours</th>
                                            <th>Nbre Heure TP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0;
                                        foreach($res_subject as $data){
                                            $i++; ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $data['nom_mat']; ?></td>
                                            <td><?php echo $data['coefMat']; ?></td>
                                            <td><?php echo $data['NbreHeureCours']; ?></td>
                                            <td><?php echo $data['NbreHeureTP']; ?></td>  
                                        </tr>                                        
                                        
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
</div>
<!-- /.container-fluid -->

<?php
include('includes/footer.php');
include('includes/scripts.php');
?>

