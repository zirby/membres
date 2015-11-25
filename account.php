<?php 
require 'inc/function.php';
auth_needed();

if(!empty($_POST)){
    if(empty($_POST) || $_POST['password'] != $_POST['passwordConfirm']){
        $_SESSION['flash']['danger'] = "les mot de passe ne sont pas identique";
    }else{
        $user_id = $_SESSION['auth']->id;
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        require 'inc/db.php';
        $req = $pdo->prepare("UPDATE zed_users SET password = ? WHERE id=?");
        $req->execute([$password, $user_id]);
        $_SESSION['flash']['success'] = "le mot de passe à bien été mis a jour";
    }
}


?>

<?php require 'inc/header.php'; ?>



<h2>Bonjour <?= $_SESSION['auth']->firstname; ?> <?= strtoupper($_SESSION['auth']->lastname); ?></h2>

<form action="" method="POST" class="form-horizontal">
  <fieldset>
    <legend><h1>Modifier le mot de passe</h1></legend>
    <div class="form-group">
      <label for="password" class="col-lg-2 control-label">Password</label>
      <div class="col-lg-10">
        <input class="form-control" name="password" id="password" placeholder="Changer de mot de passe" type="password">
      </div>
    </div>
    <div class="form-group">
      <label for="passwordConfirm" class="col-lg-2 control-label">Confirmer le Password</label>
      <div class="col-lg-10">
        <input class="form-control" name="passwordConfirm" id="password" placeholder="confirmer mot de passe" type="password">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </fieldset>
</form>

<?php require 'inc/footer.php'; ?>
