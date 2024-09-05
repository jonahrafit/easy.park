
<div class="row mt">
    <div class="col-lg-12">
        <div class="content-panel">
            <h4><i class="fa fa-angle-right"></i> Situation de parking </h4>
            <div class="showback">
                <h6>Reference : <?php echo $reference; ?></h6>
                <div class="row">
                    <div class="col-sm-12">
                        <section id="unseen">
                            <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>Voiture</th>
                                        <th class="numeric">DateHeure Début</th>
                                        <th class="numeric">Duree</th>
                                        <th class="numeric">DateHeure Fin </th>
                                        <th class="numeric">DateHeure Départ</th>
                                        <th class="numeric">Montant parking</th>
                                        <th class="numeric">Montant amende</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for($i = 0 ; $i<count($stats) ; $i++) { ?>
                                    <tr>
                                        <td>
                                            <form action="<?php echo site_url('Parking/pdf_ticket') ?>" method="post">
                                                <input type="hidden" name="immatriculation"
                                                    value=" <?php echo $stats[$i]->immatriculation; ?>">
                                                <input type="hidden" name="cout"
                                                    value=" <?php echo $stats[$i]->cout; ?>">
                                                <?php if($stats[$i]->remise != null) { ?>
                                                <input type="hidden" name="remise"
                                                    value=" <?php echo $stats[$i]->remise; ?>">
                                                <?php } ?>
                                                <input type="hidden" name="cout_final"
                                                    value=" <?php echo $stats[$i]->cout_final; ?>">
                                                <input type="hidden" name="heure"
                                                    value=" <?php echo $stats[$i]->heure_tarif; ?>">
                                                <input type="hidden" name="minute"
                                                    value=" <?php echo $stats[$i]->minute_tarif; ?>">
                                                <input type="hidden" name="datetimedebut"
                                                    value=" <?php echo $stats[$i]->datetimedebut; ?>">
                                                <input type="hidden" name="deadline"
                                                    value=" <?php echo $stats[$i]->deadline; ?>">
                                                <button class="btn btn-success"
                                                    type="submit"><?php echo $stats[$i]->immatriculation; ?></button>
                                            </form>
                                        </td>
                                        <td class="numeric"><?php echo $stats[$i]->datetimedebut; ?></td>
                                        <td class="numeric">
                                            <?php if($stats[$i]->heure_tarif != 0) echo $stats[$i]->heure_tarif.'h'; if($stats[$i]->minute_tarif != 0) echo $stats[$i]->minute_tarif.'mn'; ?>
                                        </td>
                                        <td class="numeric"><?php echo $stats[$i]->deadline; ?></td>
                                        <td class="numeric"><?php echo $stats[$i]->datetimesortie; ?></td>
                                        <td class="numeric"><?php echo $stats[$i]->cout_final; ?></td>
                                        <td class="numeric"><?php echo $stats[$i]->amende; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>