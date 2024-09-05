<div class="row mt">
    <div class="col-lg-12">
        <div class="content-panel">
            <h4><i class="fa fa-angle-right"></i> Mouvement au parking </h4>
            <div class="showback">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-inline" role="form" action="<?php echo site_url('Admin/MouvementParking'); ?>" method="post">
                            <div class="form-group">
                                Plcace au Parking <br>
                                <select name="parking" id="" class="form-control">
                                    <option value="Tous">Tous
                                    <option>
                                        <?php for($i=0;$i<count($places); $i++){ ?>
                                    <option value="<?php echo $places[$i]->id ?>">Place n°
                                        <?php echo $places[$i]->id; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <!-- <div class="form-group">
                                Tarif <br>
                                <select name="tarif" id="" class="form-control">
                                    <?php for($j=0;$j<count($tarifs); $j++){ ?>
                                        <option value="<?php echo $tarifs[$j]->id ?>"><?php echo $tarifs[$j]->heure.' : '.$tarifs[$j]->minute.' : 00'; ?></option>
                                    <?php } ?>
                                </select>
                            </div> -->
                            <div class="form-group">
                                DateHeure Debut min <br>
                                <input type="datetime-local" class="form-control" name="datymin">
                            </div>
                            <div class="form-group">
                                DateHeure Debut max <br>
                                <input type="datetime-local" class="form-control" name="datymax">
                            </div>
                            <div class="form-group">
                                <br>
                                <button type="submit" class="btn btn-primary">Filtrer</button>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
                <i>On trouve <?php echo $total; ?> resultat(s)</i>
            </div>
        </div>
        <div class="showback">
            <div class="row">
                <div class="col-sm-12">
                    <section id="unseen">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Parking n°</th>
                                    <th>Voiture</th>
                                    <th class="numeric">DateHeure Début</th>
                                    <th class="numeric">Cout</th>
                                    <th class="numeric">Duree</th>
                                    <th class="numeric">DateHeure Fin </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for($i = 0 ; $i<count($listemouvement) ; $i++) { ?>
                                <tr>
                                    <td><?php echo $listemouvement[$i]->idplace_voiture; ?></td>
                                    <td><?php echo $listemouvement[$i]->idplace; ?></td>
                                    <td><?php echo $listemouvement[$i]->immatriculation; ?></td>
                                    <td class="numeric"><?php echo $listemouvement[$i]->datetimedebut; ?></td>
                                    <td class="numeric"><?php echo $listemouvement[$i]->cout; ?></td>
                                    <td class="numeric"><?php echo $listemouvement[$i]->duree; ?></td>
                                    <td class="numeric"><?php echo $listemouvement[$i]->deadline; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </section>
                    <div>
                        <?php  echo $links; ?>
                    </div>
                </div>
                <!-- /content-panel -->
            </div>
        </div>
    </div>
</div>