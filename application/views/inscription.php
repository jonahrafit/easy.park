<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <title> PARKING SYSTEM </title>

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
    <div id="login-page">
        <div class="container">
            <div class="row mt">
                <div class="col-md-12">
                    <div class="content-panel">
                        <div class="showback">
                            <a href="<?php echo site_url('Compte/login') ?>">
                                <h4> << Se connecter</h4>
                            </a>
                            <h2>Inscription</h2>
                            <form action="<?php echo site_url('Compte/do_inscription') ?>" method="post">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <br><input type="text" name="nom" placeholder="Nom"
                                            value="<?php if(isset($error)) echo $values['nom'] ?>"
                                            class="form-control placeholder-no-fix">
                                        <br><input type="text" name="prenom" placeholder="Prénom"
                                            value="<?php if(isset($error)) echo $values['prenom'] ?>"
                                            class="form-control placeholder-no-fix">
                                        <br><input type="text" name="login" placeholder="Login"
                                            value="<?php if(isset($error)) echo $values['login'] ?>"
                                            class="form-control placeholder-no-fix">
                                        <br><input type="text" name="mdp" placeholder="Mot de passe"
                                            value="<?php if(isset($error)) echo $values['mdp'] ?>"
                                            class="form-control placeholder-no-fix">
                                        <br><input type="text" name="mdp_retap"
                                            value="<?php if(isset($error)) echo $values['mdp_retap'] ?>"
                                            placeholder="Retaper votre Mot de passe"
                                            class="form-control placeholder-no-fix">
                                        <br>
                                        <?php if(isset($error)) { ?>
                                        <i style="color : red"><?= $error; ?> </i>
                                        <?php } ?>
                                        <?php if(isset($message)) { ?>
                                        <h3 style="color : green"><?= $message; ?> </h3>
                                        <?php } ?>
                                        <button class="btn btn-theme" type="submit">S'inscrire</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo lib_url('jquery/jquery.min.js') ?>"></script>
    <script src="<?php echo lib_url('bootstrap/js/bootstrap.min.js') ?>"></script>
</body>

</html>