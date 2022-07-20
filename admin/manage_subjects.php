<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');

include('config/dbconn.php');

$query="SELECT * from matieres";
$res=mysqli_query($con, $query);
 
?>

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"></h1>
        <a href="add_subject.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadowsm"><i
        class="text-white-50"></i> <b> + </b>Ajouter </a>
        
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Liste des matières</h6>
                        </div>
                        <div class="card-body">
                        <?php if(isset($_GET['status'])){
                                    echo '<div class="card bg-info text-white shadow"><div class="card-body">'.$_GET['status'].'</div></div>';
                                    } ?>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nom de la matière</th>
                                            <th>Coefficient</th>
                                            <th>Nbre Heure Cours</th>
                                            <th>Nbre Heure TP</th>
                                            <th>Operations</th>
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
                                            <td>
                                                <a href="edit_subject.php?id_subject=<?php echo $data['id_mat']; ?>" title="Modifier" class="icon-lg text-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="" data-target="#modal_delete<?php echo $data['id_mat']?>" data-toggle="modal" class="icon-lg text-danger ">
                                                    <i class="fas fa-trash"></i>
                                                </a>    
                                            </td>
                                        </tr>                                        
                                        <div class="modal fade" id="modal_delete<?php echo $data['id_mat']?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Suppression d'une matière</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <b><span class="text-danger">Souhaitez -vous supprimer cette matière!</span></b>
                                                </div>
                                                <div class="modal-footer">
                                                    <a type="button" class="btn btn-danger" href="delete_subject.php?id_subject=<?php echo $data['id_mat']?>">Supprimer</a>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                                    
                                                </div>
                                                </div>
                                            </div>
                                            </div>
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
