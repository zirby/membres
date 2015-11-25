<?php require 'inc/function.php'; ?>
<?php 
session_start();
if(!empty($_POST) && !empty($_POST['email']) ){
    require 'inc/db.php';
    $req = $pdo->prepare("SELECT * FROM zed_users WHERE email = ?");
    $req->execute([$_POST['email']]);
    $user = $req->fetch();
    if($user){
        $reset_token = str_random(60);
        $req = $pdo->prepare("UPDATE zed_users SET reset_token = ? , reset_at = NOW() WHERE id = ?");
        $req->execute([$reset_token, $user->id]);
        doMail($_POST['email'], 'Réinitialisation de votre mot de passe', "Afin de réinitialiser votre mot de passe merci de cliquer sur ce lien:<br/>http://countrytickets.eu/membres/reset.php?id={$user->id}&token=$reset_token");
        $_SESSION['flash']['success']="Les instruction du rappel de mot de passe vous ont été envoyées par email";
        header('Location: login.php');
        exit();
    }else{
        $_SESSION['flash']['danger']="aucun compte ne correspont à cet email";
    }
}
?>
<?php require 'inc/header.php'; ?>
<form action="" method="POST" class="form-horizontal">
  <fieldset>
    <legend><h1>Mot de passe oublié</h1></legend>
    <?php if(!empty($errors)):?>
        <div class="alert alert-danger">
            <ul>
            <?php  foreach($errors as $error): ?>
                <li><?= $error; ?></li>
            <?php  endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <div class="form-group">
      <label for="email" class="col-lg-2 control-label">Email</label>
      <div class="col-lg-10">
        <input class="form-control" name="email" id="email" placeholder="Email" type="email">
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
