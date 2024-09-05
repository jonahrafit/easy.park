<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <title>PARKING SYSTEM</title>

    <!-- Favicons -->
    <link href="<?php echo img_url('favicon.png') ?>" rel="icon">
    <link href="<?php echo img_url('apple-touch-icon.png') ?>" rel="apple-touch-icon">

    <!-- Bootstrap core CSS -->
    <link href="<?php echo lib_url('bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo lib_url('font-awesome/css/font-awesome.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo css_url('zabuto_calendar.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo lib_url('gritter/css/jquery.gritter.css') ?>" />
    <!-- Custom styles for this template -->
    <link href="<?php echo css_url('style.css') ?>" rel="stylesheet">
    <link href="<?php echo css_url('style-responsive.css') ?>" rel="stylesheet">
    <script src="<?php echo lib_url('chart-master/Chart.js') ?>"></script>


</head>

<body>
    <section id="container">
        <!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
        <!--header start-->
        <header class="header black-bg">
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
            </div>
            <!--logo start-->
            <a href="#" class="logo"><b>PARKING S<span>YSTEM</span></b></a>
            <div class="top-menu">
                <ul class="nav pull-right top-menu">
                    <?php if(isset($_SESSION['compte'])) { ?>
                    <li><a class="logout" href="<?php echo site_url('Compte/logout') ?>">Deconnexion</a></li>
                    <?php } else { ?>
                    <li><a class="logout" href="<?php echo site_url('Compte') ?>">Se connecter</a></li>
                    <?php } ?>
                </ul>
            </div>
        </header>
        <?php if(isset($_SESSION['compte'])) { ?>
        <aside>
            <div id="sidebar" class="nav-collapse ">
                <!-- sidebar menu start-->
                <ul class="sidebar-menu" id="nav-accordion">

                    <p class="centered"><img src="<?php echo img_url('user.png') ?>"
                                class="img-circle" width="80"></p>
                    <h5 class="centered"><?php echo $_SESSION['compte']['nom'] ?></h5>

                    <?php if($_SESSION['compte']['fonction'] == 'admin') { ?>
                    <li><a href="<?php echo site_url('Admin') ?>"> <i
                                class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
                    <li><a href="<?php echo site_url('Admin/Tarif') ?>"> <i
                                class="fa fa-dollar"></i><span>Tarif</span></a></li>
                    <li><a href="<?php echo site_url('Admin/Portefeuille') ?>"> <i
                                class="fa fa-eur"></i><span>Portefeuille Client</span></a></li>
                    <!-- <li><a href="<?php echo site_url('Admin/MouvementParking') ?>"> <i
                                class="fa fa-tasks"></i><span>Mouvements au parking</span></a></li> -->
                    <li><a href="<?php echo site_url('Admin/SituationParking') ?>"> <i
                                class="fa fa-inbox"></i><span>Situation de parking</span></a></li>
                    <?php } ?>

                    <li><a href="<?php echo site_url('Parking') ?>"> <i class="fa fa-road"></i><span>Parking</span></a>
                    </li>

                    <?php if($_SESSION['compte']['fonction'] != 'admin') { ?>
                    <li><a href="<?php echo site_url('Compte/Fiche') ?>"> <i class="fa fa-gear"></i><span>Mon
                                Compte</span></a></li>
                    <?php } ?>
                </ul>
            </div>
        </aside>
        <?php } ?>
        <section id="main-content">
            <section class="wrapper">
                <div class="chat-room mt">
                    <?php if($_SESSION['compte']['fonction'] == 'admin') { ?>
                    <aside class="mid-side">
                        <footer>
                            <form action="<?php echo site_url('Admin/Changegetnow') ?>" method="post">
                            <div class="chat-txt">
                                <input type="datetime-local" name="getnow" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-theme">Changer getnow</button>
                            </form>
                        </footer>
                    </aside>
                    <?php } ?>
                    <aside class="right-side">
                        <div class="user-head">
                            <H3> <?php echo $getnow; ?></H3>
                        </div>
                    </aside>
                </div>
                <?php include($page); ?>
            </section>
        </section>
    </section>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo lib_url('jquery/jquery.min.js') ?>"></script>
    <script src="<?php echo lib_url('bootstrap/js/bootstrap.min.js') ?>"></script>
    <!-- js placed at the end of the document so the pages load faster -->
    <script class="include" type="text/javascript" src="<?php echo lib_url('jquery.dcjqaccordion.2.7.js') ?>"></script>
    <script src="<?php echo lib_url('jquery.scrollTo.min.js') ?>"></script>
    <script src="<?php echo lib_url('jquery.nicescroll.js') ?>" type="text/javascript"></script>
    <script src="<?php echo lib_url('jquery.sparkline.js') ?>"></script>
    <!--common script for all pages-->
    <script src="<?php echo lib_url('common-scripts.js') ?>"></script>
    <script type="text/javascript" src="<?php echo lib_url('gritter/js/jquery.gritter.js') ?>"></script>
    <script type="text/javascript" src="<?php echo lib_url('gritter-conf.js') ?>"></script>
    <!--script for this page-->
    <script src="<?php echo lib_url('sparkline-chart.js') ?>"></script>
    <script src="<?php echo lib_url('zabuto_calendar.js') ?>"></script>
</body>

</html>