
<?php 
require 'inc/bootstrap.php';
$db = App::getDatabase();
$auth = App::getAuth();
$auth->connectFromCookie($db);
if($auth->user()){
    App::redirect ('account.php');
}

 if(!empty($_POST) && !empty($_POST['email']) && !empty($_POST['password'])){
     $user = $auth->login($db, $_POST['email'],$_POST['password'],$_POST['remeber'] );
     if ($user){
         $_SESSION['flash']['success']="Vous êtes bien connecté";
         header('Location: account.php');
     }else{
         $_SESSION['flash']['danger']="Email ou mot de passe incorrect";
     }
 }
?>
<?php require 'inc/header.php'; ?>
<form action="" method="POST" class="form-horizontal">
  <fieldset>
    <legend><h1>Se connecter</h1></legend>
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
        <input class="form-control" name="email" id="email" placeholder="Email" type="text">
      </div>
    </div>
    <div class="form-group">
        <label for="password" class="col-lg-2 control-label">Mot de passe</label>
      <div class="col-lg-10">
        <input class="form-control" name="password" id="password" placeholder="Mot de passe" type="password">
        <span class="help-block"><a href="forget.php">(j'ai oublié mon mot de passe)</a></span>
        <div class="checkbox">
          <label>
              <input name="remember" value="1" type="checkbox"> Se souvenir
          </label>
        </div>

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
