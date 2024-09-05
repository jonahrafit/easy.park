<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <title> PARKING SYSTEM</title>

    <!-- Favicons -->
    <link href="img/favicon.png" rel="icon">
    <link href="img/apple-touch-icon.png" rel="apple-touch-icon">
    <!-- Bootstrap core CSS -->
    <link href="<?php echo lib_url('bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo lib_url('font-awesome/css/font-awesome.css') ?>" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="<?php echo css_url('style.css') ?>" rel="stylesheet">
    <link href="<?php echo css_url('style-responsive.css') ?>" rel="stylesheet">

</head>

<body>
    <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
    <div class="row mt">
    <div class="col-md-4">
            <div class="content-panel">
                <form class="form-login" action="<?php echo site_url('Compte/validate') ?>" method="post">
                    <h2 class="form-login-heading">BIENVENU DANS PARKING SYSTEM</h2>
                    <div class="login-wrap">
                        <input type="text" class="form-control" name="login" placeholder="Id Utilisateur" value="admin@gmail.com">
                        <br>
                        <input type="password" class="form-control" name="mdp" placeholder="Mot de passe" value="admin">
                        <br>
                        <button class="btn btn-theme btn-block" type="submit"> SE CONNECTER</button>
                        <?php if(isset($message)) { ?>
                        <i style="color : red"><?= $message; ?> </i>
                        <?php } ?>
                        <hr>
                        <div class="registration">
                            <a href="<?php echo site_url('Compte/inscription') ?>"> Créer un compte </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="content-panel">
                <form class="form-login" action="<?php echo site_url('Compte/validate') ?>" method="post">
                    <h2 class="form-login-heading">BIENVENU DANS PARKING SYSTEM</h2>
                    <div class="login-wrap">
                        <input type="text" class="form-control" name="login" placeholder="Id Utilisateur" value="client1@test.com">
                        <br>
                        <input type="password" class="form-control" name="mdp" placeholder="Mot de passe" value="client1">
                        <br>
                        <button class="btn btn-theme btn-block" type="submit"> SE CONNECTER</button>
                        <?php if(isset($message)) { ?>
                        <i style="color : red"><?= $message; ?> </i>
                        <?php } ?>
                        <hr>
                        <div class="registration">
                            <a href="<?php echo site_url('Compte/inscription') ?>"> Créer un compte </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="content-panel">
                <form class="form-login" action="<?php echo site_url('Compte/validate') ?>" method="post">
                    <h2 class="form-login-heading">BIENVENU DANS PARKING SYSTEM</h2>
                    <div class="login-wrap">
                        <input type="text" class="form-control" name="login" placeholder="Id Utilisateur" value="client2@test.com">
                        <br>
                        <input type="password" class="form-control" name="mdp" placeholder="Mot de passe" value="client2">
                        <br>
                        <button class="btn btn-theme btn-block" type="submit"> SE CONNECTER</button>
                        <?php if(isset($message)) { ?>
                        <i style="color : red"><?= $message; ?> </i>
                        <?php } ?>
                        <hr>
                        <div class="registration">
                            <a href="<?php echo site_url('Compte/inscription') ?>"> Créer un compte </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?php echo lib_url('jquery/jquery.min.js') ?>"></script>
    <script src="<?php echo lib_url('bootstrap/js/bootstrap.min.js') ?>"></script>
</body>

</html>