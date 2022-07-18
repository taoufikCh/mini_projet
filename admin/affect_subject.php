<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');

include('config/dbconn.php');

$query="SELECT * from matieres";
$res_mat=mysqli_query($con, $query);


$id=$_GET['id_teacher'];

//$query="SELECT * from subject_affected WHERE idEns='$id'";
$query="SELECT subject_affected.*, matieres.nom_mat from subject_affected
LEFT JOIN matieres ON subject_affected.idMat = matieres.id_mat WHERE subject_affected.idEns='".$id."'";


$res=mysqli_query($con, $query);

$query2="SELECT * from enseignant WHERE numEns='".$id."'";

$result = mysqli_query($con, $query2) or die ( mysqli_error());
$data = mysqli_fetch_assoc($result);
 
?>

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"></h1>
        
        <a href="" data-target="#modal_add" data-toggle="modal" class="btn btn-primary ">
        <i class="text-white-50"></i> <b> + </b>Affecter à une matière
        </a>
        
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des matières affectuées</h6>
        </div>
        
        <div class="card-body">
            <div style="color:#000">
            <b>Information sur l'enseignant</b><br>
        <table class="table"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                 
                                            <th>Prénom</th>
                                            <th>Nom</th>
                                            <th>Date naissance</th>
                                            <th>Email</th>
                                            <th>Date Embauche</th>
                                            <th>Grade</th>
                                            
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                    
                                        <tr style="background-color:#fddddd">
                                           
                                            <td><?php echo $data['prenom']; ?></td>
                                            <td><?php echo $data['nom']; ?></td>
                                            <td><?php echo $data['dateNaissance']; ?></td>
                                            <td><?php echo $data['adresseMail']; ?></td>
                                            <td><?php echo $data['dateEmbauche']; ?></td>
                                            <td><?php echo $data['grade']; ?></td>
    </tr>
    </tbody>
    </table>
</div>
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
                                            <td>
                                                <a href="" data-target="#modal_delete<?php echo $data['idSA']?>" data-toggle="modal" class="icon-lg text-danger ">
                                                    <i class="fas fa-trash"></i>
                                                </a>    
                                            </td>
                                        </tr>                                        
                                        <div class="modal fade" id="modal_delete<?php echo $data['idSA']?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Suppression d'une matière</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <b><span class="text-danger">Souhaitez -vous supprimer cette affectation!</span></b>
                                                </div>
                                                <div class="modal-footer">
                                                    <a type="button" class="btn btn-danger" href="delete_subject_affected.php?id_sub=<?php echo $data['idSA']?>&id_teacher=<?php echo $id?>">Supprimer</a>
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
<div class="modal fade" id="modal_add" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
           <div class="modal-header">
                    <h5 class="modal-title">Affecter une matière</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                   </div>
                   <form id="" action="save_subject_affect.php" method="post"> 
                     <div class="modal-body">
                     
                            <input type="hidden"  id="id_teacher" name="id_teacher" value="<?php echo $id; ?>" required>
                            <div class="mb-4 row">
                            <label for="subject" class="col-md-4 form-label" style="color:#000"><b>Choisir une matière : </b></label>
                            <div class="col-md-8">
                                <select name="subject" id="subject" class="form-control" required>
                                    <option value=""><--Choisir--></option>
                                    <?php foreach($res_mat as $mat){ ?>
                                        <option value="<?php echo $mat['id_mat'] ?>"><?php echo $mat['nom_mat']; ?></option>
                                <?php } ?>  
                                </select>
                            </div>
                            </div>
            
           
                    </div>
                   <div class="modal-footer">
                   <button type="submit" class="btn btn-danger">Affecter</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                                    
                </div>
            </div>
        </form> 
    </div>
</div>

<?php
include('includes/footer.php');
include('includes/scripts.php');
?>
