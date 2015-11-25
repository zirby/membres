

<?php 
require_once 'inc/bootstrap.php';


if(!empty($_POST)){
    
    $errors = array();
    
    $db = App::getDatabase();
    
    $validator = new Validator($_POST);
    $validator->isAlpha('username', "Votre username n'est pas valide (alphanumerique)");
    $validator->isUniq('username', $db, 'zed_users', "Votre username existe déjà");
    $validator->isEmail('email',  "Votre e-mail n'est pas valide");
    $validator->isUniq('email', $db, 'zed_users', "Ce mail est déjà utilisé");
    $validator->isConfirmed('password', "Mot de passe non valide");

    if ($validator->isValid()){
        
        $auth = new Auth();
        $auth->register($db, $_POST['username'], $_POST['lastname'], $_POST['firstname'], $_POST['email'], $_POST['password']);
        Session::getInstance()->setFlash('success', "Un e-mail de confirmation vous a été envoyé");
        
        App::redirect('login.php');
        
    }else{
        $errors = $validator->getErrors();
    }
}


?>
<?php require 'inc/header.php'; ?>
<form action="" method="POST" class="form-horizontal">
  <fieldset>
    <legend><h1>S'inscrire</h1></legend>
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
      <label for="username" class="col-lg-2 control-label">Identifiant</label>
      <div class="col-lg-10">
          <input class="form-control" name="username" id="username" placeholder="Identifiant" type="text">
      </div>
    </div>
    <div class="form-group">
      <label for="lastname" class="col-lg-2 control-label">Nom</label>
      <div class="col-lg-10">
          <input class="form-control" name="lastname" id="lastname" placeholder="Nom" type="text">
      </div>
    </div>
    <div class="form-group">
      <label for="firstname" class="col-lg-2 control-label">Prénom</label>
      <div class="col-lg-10">
          <input class="form-control" name="firstname" id="firstname" placeholder="Prénom" type="text">
      </div>
    </div>
    <div class="form-group">
      <label for="email" class="col-lg-2 control-label">Email</label>
      <div class="col-lg-10">
        <input class="form-control" name="email" id="email" placeholder="Email" type="text">
      </div>
    </div>
    <div class="form-group">
      <label for="password" class="col-lg-2 control-label">Password</label>
      <div class="col-lg-10">
        <input class="form-control" name="password" id="password" placeholder="Password" type="password">
      </div>
    </div>
    <div class="form-group">
      <label for="password_confirm" class="col-lg-2 control-label">Password confim</label>
      <div class="col-lg-10">
        <input class="form-control" name="password_confirm" id="password_confirm" placeholder="Password" type="password">
        <div class="checkbox">
          <label>
            <input type="checkbox"> se souvenir de moi
          </label>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" class="btn btn-default">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </fieldset>
</form>


<?php require 'inc/footer.php'; ?>
