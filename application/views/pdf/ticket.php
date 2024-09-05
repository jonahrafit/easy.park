<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo lib_url('bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo lib_url('font-awesome/css/font-awesome.css') ?>" rel="stylesheet" />
</head>

<body>
    <section id="container">
        <section id="main-content">
            <section class="wrapper">
                <div class="row mt">
                    <div class="col-sm-3">
                        <address>
                            <strong>Ticket de parking pour : <h3> <?php echo $immatriculation; ?></h3></strong><br>
                        </address>
                        <table>
                            <tbody>
                                <tr>
                                    <td>Montant : </td>
                                    <td style="text-align : right">
                                        <?php if($cout < $cout_final)  { echo $cout_final.' Ar'; }  ?>
                                        <?php if($cout == $cout_final)  { echo $cout_final.' Ar'; }  ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Durée : </td>
                                    <td style="text-align : right">
                                        <?php if($heure > 0) { echo $heure.'h '; } if($minute > 0 ) { echo $minute.'min'; }?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date heure début: </td>
                                    <td style="text-align : right"><?php echo $datetimedebut; ?></td>
                                </tr>
                                <tr>
                                    <td>Date heure fin: </td>
                                    <td style="text-align : right"><?php echo $deadline; ?></td>
                                </tr>
                                    <tr>
                                    <td>Remise : </td>
                                    <td style="text-align : right"><?php if($remise != null) { echo $remise; } else { '0'; } ?> %</td>
                                </tr>
                                <tr>
                                    <td>Montant avec remise : </td>
                                    <td style="text-align : right"><?php echo $cout_final; ?> Ar</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </section>
    </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo lib_url('jquery/jquery.min.js') ?>"></script>
    <script src="<?php echo lib_url('bootstrap/js/bootstrap.min.js') ?>"></script>
</body>

</html>