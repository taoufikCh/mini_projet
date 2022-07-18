<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');

include('config/dbconn.php');

//$query="SELECT * from coursesession";
$query="SELECT coursesession.*, matieres.nom_mat, groupe.nomGroupe 
    from coursesession LEFT JOIN matieres ON coursesession.id_matiere = matieres.id_mat
    LEFT JOIN groupe ON coursesession.id_groupe = groupe.idGroupe ";

$res=mysqli_query($con, $query);
 
?>

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"></h1>
        <a href="add_courseSeance.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadowsm"><i
        class="text-white-50"></i> <b> + </b>Ajouter </a>
        
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Liste des seances du cours</h6>
                        </div>
                        <div class="card-body">
                        <?php if(isset($_GET['success'])){
                                echo '<div class="card bg-success text-white shadow"><div class="card-body">'.$_GET['success'].'</div></div>';
                        } ?>
                        <?php if(isset($_GET['failed'])){
                                echo '<div class="card bg-danger text-white shadow"><div class="card-body">'.$_GET['failed'].'</div></div>';
                        } ?>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Matière</th>
                                            <th>Date</th>
                                            <th>Heure début</th>
                                            <th>Heure Fin</th>
                                            <th>Type</th>
                                            <th>Test</th>
                                            <th>Groupe</th>
                                            <th>Operations</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        <?php $i = 0;
                                        foreach($res as $data){
                                            $i++; ?>
                                        <tr>
                                            <td><?php echo $data['id_seance']; ?></td>
                                            <td><?php echo $data['nom_mat']; ?></td>
                                            <td><?php echo $data['date_seance']; ?></td>
                                            <td><?php echo $data['heure_debut']; ?></td>
                                            <td><?php echo $data['heure_fin']; ?></td>
                                            <td>
                                                <?php if($data['type_seance']=="1") echo "Cours";
                                                if($data['type_seance']=="2") echo "TP";  ?>
                                            </td>
                                            <td>
                                                <?php if($data['test_evaluation']=="0") echo "Non";
                                                if($data['test_evaluation']=="1") echo "Oui";  ?>
                                            </td>
                                            <td><?php echo $data['nomGroupe']; ?></td>
                                            <td>
                                            <a href="manage_absences.php?id_seance=<?php echo $data['id_seance']; ?>" title="Liste des matières affectué" class="icon-lg text-suucess">
                                                <i class="fas fa-users"></i>
                                                </a>
                                                <a href="edit_courseSeance.php?id_seance=<?php echo $data['id_seance']; ?>" title="Modifier" class="icon-lg text-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="" data-target="#modal_delete<?php echo $data['id_seance']?>" data-toggle="modal" class="icon-lg text-danger ">
                                                    <i class="fas fa-trash"></i>
                                                </a>    
                                            </td>
                                        </tr>                                        
                                        <div class="modal fade" id="modal_delete<?php echo $data['id_seance']?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered"">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Suppression d'un étuduant</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <b><span class="text-danger">Souhaitez -vous supprimer cette ligne!</span></b>
                                                </div>
                                                <div class="modal-footer">
                                                    <a type="button" class="btn btn-danger" href="delete_courseSeance.php?id_seance=<?php echo $data['id_seance']?>">Supprimer</a>
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
