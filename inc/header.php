
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>membres</title>

    <!-- Bootstrap core CSS -->
    <link href="css/app.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">



    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <a class="navbar-brand" href="index.php">Membres</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
              <?php if (isset($_SESSION['auth'])): ?>
                <li><a href="logout.php">Se déconnecter</a></li>
              <?php else: ?>
                <li><a href="register.php">S'inscrire</a></li>
                <li><a href="login.php">Se connecter</a></li>            
              <?php endif; ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
        
        <?php if(Session::getInstance()->hasFlashes()): ?>
            <?php foreach (Session::getInstance()->getFlashes() as $type => $message): ?>
                <div class="alert alert-<?=$type;?>">
                    <?=$message;?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>


