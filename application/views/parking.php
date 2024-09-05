<style>
.placeparking {
    border: none;
    color: white;
    padding: 5px;
    width: 50px;
    height: 70px;
    margin: 3px;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 10%;
}
</style>

<?php 
$total = count($places);
$occupe = 0;
$infract = 0;
$indisp = 0;
$libre = 0;
?>

<div class="row mt">
    <div class="col-sm-12">
        <div class="form-panel">
            <div class="row mt">
                <div class="col-sm-9">
                    <h4 class="mb"><i class="fa fa-angle-right"></i> ETAT DE PARKING ,
                        <?php if(isset($daty)) { echo $daty; } else { echo 'Actuel'; } ?></h4>
                    <?php if($_SESSION['compte']['fonction'] == 'admin') { ?>

                    <div class="showback">
                        <div class="row">
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-default" data-toggle="modal"
                                    data-target="#myModal"><i class="fa fa-plus-circle"> </i> Ajouter nouveau
                                    place</button>
                            </div>
                            <!-- <div class="col-sm-6">
                        <form action="<?php echo site_url('Parking') ?>" method="post">
                            <input type="datetime-local" name="daty">
                            <button type="submit" class="btn btn-info"><i class="fa fa-eye"> </i> Voir etat de place
                            </button>
                        </form>
                    </div> -->
                        </div>
                    </div>

                    <br>
                    <?php } if(isset($error)) { ?><div class="alert alert-danger" role="alert">
                        <H5><?php echo $error; ?></H5>
                    </div>
                    <?php } if(isset($message)) { ?><div class="alert alert-success" role="alert">
                        <H5><?php echo $message; ?></H5>
                    </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-12">
                            <?php $nb = 0;
                    $boucle = 13;
                    $compt = -1;

                    while($nb < count($places)) {
                    for($i=$nb;$i<($nb+$boucle);$i++) {
                    $couleur = 'green';
                    $compt = $compt + 1 ; 
                    
                    if($compt == count($places)) { break; } 
                    if($places[$i]->statut == 'OCCUPE') { 
                        $occupe ++; 
                        $couleur = 'red';
                    }
                    else if($places[$i]->statut == 'INFRACT') { 
                        $infract ++; 
                        $couleur = 'yellow';
                    } 
                    else if($places[$i]->statut == 'INDISP') { 
                        $indisp ++;  
                        $couleur = 'black';
                    } 
                    else 
                    {
                        $libre ++; 
                    }
                    ?>

                            <input type="hidden" name="hho" id="tooltip<?php echo $places[$i]->idplacee; ?>">
                            <a data-toggle="tooltip<?php echo $places[$i]->idplacee; ?>" data-placement="auto">
                                <button class="placeparking" style="background-color : <?php echo $couleur; ?>">
                                    <?php echo $places[$i]->idplacee; ?>
                                </button>
                            </a>

                            <!-- MODAL AJOUTER NA ENLEVER -->
                            <div class="modal fade" id="ajoutvoiture<?php echo $places[$i]->idplacee ?>" tabindex="-1"
                                role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <?php if($places[$i]->statut == 'LIBRE') { 
                                    if($solde !=0 ) { ?>
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                            <h5 class="modal-title" id="myModalLabel">Ajouter une voiture sur
                                                PN<?php echo $places[$i]->idplacee ?></h4>
                                        </div>
                                        <form action="<?php echo site_url('Parking/ajoutervoiture') ?>" method="post">
                                            <input type="hidden" name="idplace"
                                                value="<?php echo $places[$i]->idplacee ?>" />
                                            <div class="modal-body">
                                                Immatriculation de voiture
                                                <input class="form-control" type="text" name="immatriculation" />
                                                <br>
                                                Tarif
                                                <select name="tarif" class="form-control">
                                                    <?php for($k=0;$k<count($tarifs);$k++) { ?>
                                                    <option value="<?php echo $tarifs[$k]->id; ?>">
                                                        <?php if($tarifs[$k]->heure != 0) echo $tarifs[$k]->heure.'h'; if($tarifs[$k]->minute != 0) { echo $tarifs[$k]->minute.'mn';  }  echo '('.$tarifs[$k]->cout.' Ar)'; ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                                <br>
                                                Datetime début
                                                <input class="form-control" type="datetime-local" name="datetimedebut"
                                                    value="<?php echo $getnow; ?>" />
                                                <br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Annuler</button>
                                                <button type="SUBMIT" class="btn btn-primary">OK</button></a>
                                            </div>
                                        </form>
                                        <?php } else { ?>
                                        <div class="modal-body">
                                            <div class="alert alert-danger" role="alert">
                                                <H5>Ce n'est pas possible , car assez d'argent!</H5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Ok</button>
                                            </div>
                                        </div>
                                        <?php } 
                                } else { ?>
                                        <br>
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                            <h5 class="modal-title" id="myModalLabel">Faire sortir ce vehicule
                                                <?php echo $places[$i]->immatriculation ?></h4>
                                        </div>
                                        <form action="<?php echo site_url('Parking/enlevervoiture') ?>" method="post">
                                            <input type="hidden" name="idplacevoiture"
                                                value="<?php echo $places[$i]->idplace_voiture ?>" />
                                            <input type="hidden" name="amende"
                                                value="<?php echo $places[$i]->amende ?>" />
                                            <input type="hidden" name="immatriculation"
                                                value="<?php echo $places[$i]->immatriculation ?>" />
                                            Datetime sortie
                                            <input class="form-control" type="datetime-local" name="datetimesortie"
                                                value="<?php echo $getnow; ?>" max="<?php echo $getnow; ?>" />
                                            <div class="modal-body"> <button type="submit"
                                                    class="btn btn-primary btn-lg btn-block">Enlever ce vehicule
                                                    <?php echo $places[$i]->immatriculation ?></button></div>
                                            <div class="modal-footer"> <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Annuler</button> </div>
                                        </form>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL MODIFIER VOITURE -->
                            <div class="modal fade" id="modifiervoiture<?php echo $places[$i]->idplacee ?>"
                                tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                            <h5 class="modal-title" id="myModalLabel"> Modification du donnée du voiture
                                                au
                                                PN<?php echo $places[$i]->idplacee ?></h4>
                                        </div>
                                        <form action="<?php echo site_url('Parking/modifiervoiture') ?>" method="post">
                                            <input type="hidden" name="idplace_voiture"
                                                value="<?php echo $places[$i]->idplace_voiture ?>" />
                                            <div class="modal-body">
                                                Immatriculation de voiture
                                                <input class="form-control" type="text" name="immatriculation"
                                                    value="<?php echo $places[$i]->immatriculation ?>" disabled />
                                                <br>
                                                Tarif
                                                <select name="tarif" class="form-control">
                                                    <?php for($k=0;$k<count($tarifs);$k++) { ?>
                                                    <option value="<?php echo $tarifs[$k]->id; ?>"
                                                        title="<?php echo $tarifs[$k]->id; ?>"
                                                        <?php if($tarifs[$k]->heure == $places[$i]->heure_tarif and $tarifs[$k]->minute == $places[$i]->minute_tarif) { echo 'selected'; } ?>
                                                        disabled>
                                                        <?php if($tarifs[$k]->heure != 0) echo $tarifs[$k]->heure.'h'; if($tarifs[$k]->minute != 0) { echo $tarifs[$k]->minute.'mn'; } echo '('.$tarifs[$k]->cout.' Ar)'; ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                                <br>
                                                Datetime début
                                                <input class="form-control" type="datetime-local" name="datetimedebut"
                                                    value="<?php echo $places[$i]->datetimedebut; ?>" />
                                                <br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Annuler</button>
                                                <button type="SUBMIT" class="btn btn-primary">OK</button></a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- MODAL GESTION DE PLACE -->
                            <div class="modal fade" id="gestionplace<?php echo $places[$i]->idplacee ?>" tabindex="-1"
                                role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                            <h5 class="modal-title" id="myModalLabel"> Gestion de etat de place au
                                                parking</h5>
                                        </div>
                                        <form action="<?php echo site_url('Parking/gestionplace') ?>" method="post">
                                            <div class="modal-body">
                                                <div class="modal-body">
                                                    <input type="hidden" name="idplace"
                                                        value="<?php echo $places[$i]->idplacee; ?>" />
                                                    <input type="hidden" name="statut_actuel"
                                                        value="<?php echo $places[$i]->statut; ?>" />
                                                    <?php if($places[$i]->statut == 'INDISP') { ?>
                                                    <button type="submit"
                                                        class="btn btn-default btn-lg btn-block">Activer ce
                                                        place</button>
                                                    <?php } if($places[$i]->statut != 'INDISP') { ?>
                                                    <button type="submit"
                                                        class="btn btn-theme04 btn-lg btn-block">Désactiver ce
                                                        place</button>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- MODAL TICKET -->
                            <div class="modal fade" id="ticket<?php echo $places[$i]->idplacee ?>" tabindex="-1"
                                role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                            <h5 class="modal-title" id="myModalLabel"> TICKET DE
                                                <?php echo $places[$i]->immatriculation; ?> au
                                                PN<?php echo $places[$i]->idplacee; ?></h5>
                                        </div>
                                        <div class="modal-body">
                                            <h5> Forfait de poste de stationnement (FPS) </h5>
                                            <h4> Ticket de : <?php echo $places[$i]->immatriculation; ?> </h4>
                                            Montant :
                                            <?php if($places[$i]->remise != NULL) { echo $places[$i]->cout.' Ar =>  '; } echo $places[$i]->cout_final;  ?>
                                            Ar <br>
                                            <?php if($places[$i]->remise != NULL) { echo 'Remise : '.$places[$i]->remise.' % <br>'; } ?>
                                            Durée :
                                            <?php if($places[$i]->heure_tarif != 0) echo $places[$i]->heure_tarif.'h'; if($places[$i]->minute_tarif != 0) echo $places[$i]->minute_tarif.'mn'; ?>
                                            <br>
                                            Date Heure début : <?php echo $places[$i]->datetimedebut; ?> <br>
                                            Date Heure fin : <?php echo $places[$i]->deadline; ?> <br>
                                        </div>
                                        <form action="<?php echo site_url('Parking/pdf_ticket') ?>" method="post">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Annuler</button>
                                                <input type="hidden" name="immatriculation"
                                                    value=" <?php echo $places[$i]->immatriculation; ?>">
                                                <input type="hidden" name="cout"
                                                    value=" <?php echo $places[$i]->cout; ?>">
                                                <input type="hidden" name="remise"
                                                    value=" <?php echo $places[$i]->remise; ?>">
                                                <input type="hidden" name="cout_final"
                                                    value=" <?php echo $places[$i]->cout_final; ?>">
                                                <input type="hidden" name="heure"
                                                    value=" <?php echo $places[$i]->heure_tarif; ?>">
                                                <input type="hidden" name="minute"
                                                    value=" <?php echo $places[$i]->minute_tarif; ?>">
                                                <input type="hidden" name="datetimedebut"
                                                    value=" <?php echo $places[$i]->datetimedebut; ?>">
                                                <input type="hidden" name="deadline"
                                                    value=" <?php echo $places[$i]->deadline; ?>">
                                                <button class="btn btn-success" type="submit"><i class="fa fa-file"></i>
                                                    Imprimer </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- TOOLTIPS -->
                            <script src="<?php echo lib_url('jquery/jquery.min.js') ?>"></script>
                            <script src="<?php echo lib_url('bootstrap/js/bootstrap.min.js') ?>"></script>
                            <script>
                            $(document).ready(function() {
                                $('[data-toggle="tooltip<?php echo $places[$i]->idplacee; ?>"]').tooltip({
                                    delay: {
                                        "show": 500,
                                        "hide": 100
                                    },
                                    title: "<strong class='txt-highlight'>PN <?php echo $places[$i]->idplacee; ?> <br>" +
                                        "Etat : <?php echo $places[$i]->statut; ?> <i class ='fa fa-circle' style='color : <?php echo $couleur; ?>'> </i> " +
                                        "<?php if($places[$i]->statut != 'LIBRE' && $places[$i]->statut != 'INDISP') { ?>" +
                                        "<br>Temps d'arrivée : <?php echo $places[$i]->datetimedebut ?>" +
                                        "<br>Temps de depart : <?php echo $places[$i]->deadline ?>" +
                                        "<br>Durée : <?php if($places[$i]->heure_tarif != 0) echo $places[$i]->heure_tarif.'h'; if($places[$i]->minute_tarif != 0) echo $places[$i]->minute_tarif.'mn'; ?>" +
                                        "<?php if($places[$i]->statut == 'OCCUPE') { ?>" +
                                        "<br>Départ dans <?php if($places[$i]->heure_rebours != 0) echo $places[$i]->heure_rebours.'h'; if($places[$i]->minute_rebours != 0) echo $places[$i]->minute_rebours.'mn'; ?>" +
                                        "<?php } ?>" +
                                        "<?php } ?>" +
                                        "<h5> <?php echo $places[$i]->immatriculation; ?> </h5>" +
                                        "<?php if($places[$i]->amende != null) { echo 'Amende:'.$places[$i]->amende.'Ar '; } ?>" +
                                        "<?php if(isset($_SESSION['compte'])) { ?>" +
                                        "<?php if($places[$i]->statut == 'LIBRE') { ?>" +
                                        "<button type='button' class='btn btn-primary btn-xs' data-toggle='modal' data-target='#ajoutvoiture<?php echo $places[$i]->idplacee; ?>' title='Ajouter une voiture'><i class='fa fa-truck'></i> </button>       " +
                                        "<button type='button' class='btn btn-theme04 btn-xs' data-toggle='modal' data-target='#gestionplace<?php echo $places[$i]->idplacee; ?>' title='Déscativer ce place'><i class='fa fa-power-off'></i></button>" +
                                        "<?php } else if($places[$i]->statut == 'INDISP') { ?>" +
                                        "<button type='button' class='btn btn-default btn-xs' data-toggle='modal' data-target='#gestionplace<?php echo $places[$i]->idplacee; ?>'>Activer ce place </button>" +
                                        "<?php } else { ?>" +
                                        "<br><button type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#ticket<?php echo $places[$i]->idplacee; ?>' title='Voir Ticket PDF'><i class='fa fa-file'></i></button> " +
                                        "<button type='button' class='btn btn-warning btn-xs' data-toggle='modal' data-target='#ajoutvoiture<?php echo $places[$i]->idplacee; ?>' title='Enlever ce voiture'><i class='fa fa-sign-out'></i></button> " +
                                        "<button type='button' class='btn btn-theme btn-xs' data-toggle='modal' data-target='#modifiervoiture<?php echo $places[$i]->idplacee; ?>' title='Modifier'> <i class='fa fa-edit'></i> </button>" +
                                        "<?php } } ?>",
                                    html: true,
                                });
                            });
                            </script>
                            <?php } echo '<br>';
                        $nb = $nb + $boucle; ?>
                            <div class="col-md-12" style="background-color : white; height : 50px;"></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <canvas id="chartoccup" height="120" width="250"></canvas>
                    <script>
                    var doughnutData = [{
                            value: <?php echo ($occupe * 100) / $total; ?>,
                            color: "red"
                        },
                        {
                            value: <?php echo ($infract * 100) / $total; ?>,
                            color: "yellow"
                        },
                        {
                            value: <?php echo ($indisp * 100) / $total; ?>,
                            color: "black"
                        },
                        {
                            value: <?php echo ($libre * 100) / $total; ?>,
                            color: "green"
                        }
                    ];
                    var myDoughnut = new Chart(document.getElementById("chartoccup").getContext("2d")).Pie(doughnutData);
                    </script>
                    <h4>Total = <?php echo $total; ?> places </h4>
                    <h5><i class='fa fa-circle' style='color : red'> </i> <?php echo $occupe; ?> Occupé(s) <br>
                        <i class='fa fa-circle' style='color : yellow'> </i> <?php echo $infract; ?> En infraction <br>
                        <i class='fa fa-circle' style='color : black'> </i> <?php echo $indisp; ?> Indisponible <br>
                        <i class='fa fa-circle' style='color : green'> </i> <?php echo $libre; ?> Libre
                    </h5>
                    <!-- /grey-panel -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="myModalLabel">NOUVEAU PLACE</h4>
            </div>
            <div class="modal-body">
                Voulez-vous ajouter un nouveau place dans votre parking ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <a href="<?php echo site_url('Parking/nouveauplace') ?>"><button type="button"
                        class="btn btn-primary">OK</button></a>
            </div>
        </div>
    </div>
</div>