<?php

session_start();
include('includes/header.php');
include('includes/navbar.php');

include('config/dbconn.php');

$id=$_SESSION['auth_user']['codeuser'];

//$query="SELECT * from subject_affected WHERE idEns='$id'";
$query="SELECT subject_affected.*, matieres.* from subject_affected
LEFT JOIN matieres ON subject_affected.idMat = matieres.id_mat WHERE subject_affected.idEns='".$id."'";


$res=mysqli_query($con, $query);
 
?>

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Bienvenue <?php echo $_SESSION['auth_user']['user_prenomnom']; ?></span>
</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadowsm"><i
        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>
        <!-- Ajout -->
        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Vos matières</h6>
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
                                        foreach($res as $data){
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

