
<?php 
require 'inc/bootstrap.php';
require 'inc/function.php';


session_start();
reconnect_cookie();
if(!empty($_POST) && !empty($_POST['email']) && !empty($_POST['password'])){
    require 'inc/db.php';
    $req = $pdo->prepare("SELECT * FROM zed_users WHERE email = ?");
    $req->execute([$_POST['email']]);
    $user = $req->fetch();
    if($user && password_verify($_POST['password'], $user->password)){
        $_SESSION['auth'] = $user;
        $_SESSION['flash']['success']="Vous êtes bien connecté";
        if($_POST['remember']){
            $remember_token = str_random(250);
            $req = $pdo->prepare("UPDATE zed_users SET remember_token = ? WHERE id = ?");
            $req->execute([$remember_token, $user->id]);
            setcookie('remember', $user->id . '==' . $remember_token . sha1($user->id . 'totoestgrand'), time() + 60 * 60* 24*7);
        }
        header('Location: account.php');
        exit();
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
