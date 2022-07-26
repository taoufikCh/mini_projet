<?php
session_start();
session_destroy();
include('includes/header.php');
//include('includes/navbar.php');
?>
<div class="py-5">
 <div class="container">
 <div class="row justify-content-center">
 <div class="col-md-5">
 <div class="card">
 <div class="card-header">
 <h4 class="font-weight-bold text-center text-info">Connexion</h4>
 </div>
 <div class="card-body">
 <form action="logincode.php" method="POST">
 <?php if(isset($_SESSION['message'])){
        echo '<div class="card bg-danger text-white shadow"><div class="card-body">'.$_SESSION['message'].'</div></div>';
    } ?>
 <div class="form-group mb-3">
 <label class="font-weight-bold text-primary">Email ID</label>
 <input type="text" name="email" required
placeholder="Saisir votre adresse mail"
 class="form-control">
 </div>
<div class="form-group mb-3">
 <label class="font-weight-bold text-primary">Mot de passe</label>
 <input type="password" name="password" required placeholder="Saisir votre mot de passe" class="form-control">
</div>
<div class="form-group mb-3">
 <label class="font-weight-bold text-primary">Vous êtes </label>
 <select name="you_are" id="you_are" class="form-control" required>
        <option value="1">Administrateur</option>
        <option value="2">Enseignant</option>
        <option value="3">Etudiant</option>  
  </select>
</div>
<div class="form-group mb-3 text-center">
 <button type="submit" name="login_btn" class="btn btn-success">Se connecter</button>
 </div>
 </form>
 </div>
 </div>
 </div>
 </div>
 </div>
</div>
<?php
include('includes/footer.php');
?> 