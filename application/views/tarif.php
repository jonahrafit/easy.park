<div class="row mt">
    <div class="col-md-12">
        <div class="content-panel">
            <table class="table table-striped table-advance table-hover">
                <h4><i class="fa fa-angle-right"></i>TARIF</h4>
                <?php if(isset($message)) { ?>
                <div class="alert alert-success" role="alert">
                    <H5><?php echo $message; ?></H5>
                </div>
                <?php } if(isset($error)) { ?>
                <div class="alert alert-danger" role="alert">
                    <H5><?php echo $error; ?></H5>
                </div>
                <?php } ?>
                <hr>
                <div class="col-xs-4 col-xs-offset-8">
                    <button class="btn btn-sm btn-clear" data-toggle="modal" data-target="#ajouternouveautarif">
                        Ajouter Nouveau Tarif
                    </button>
                </div>
                <thead>
                    <tr>
                        <th><i class="fa fa-bell"></i> Temps </th>
                        <th class="hidden-phone"><i class="fa fa-money"></i> Coût </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php for($i = 0 ; $i<count($tarifs) ; $i++) { ?>
                    <tr>
                        <td class="hidden-phone"><?php echo $tarifs[$i]->heure.' : '.$tarifs[$i]->minute.' : 00'; ?>
                        </td>
                        <td class="hidden-phone"><?php echo $tarifs[$i]->cout ?> Ar</td>
                        <td>
                            <button class="btn btn-success btn-xs" title="<?php echo $tarifs[$i]->id; ?>"
                                data-toggle="modal" data-target="#edittarif<?php echo $tarifs[$i]->id; ?>"><i
                                    class="fa fa-pencil"></i></button>
                            <button class="btn btn-danger btn-xs" data-toggle="modal"
                                data-target="#deletetarif<?php echo $tarifs[$i]->id; ?>"><i
                                    class="fa fa-trash-o "></i></button>
                        </td>
                    </tr>

                    <div class="modal fade" id="edittarif<?php echo $tarifs[$i]->id; ?>" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                    <h5 class="modal-title" id="myModalLabel">Modification </h4>
                                </div>
                                <form action="<?php echo site_url('Admin/modificationtarif') ?>" method="post">
                                    <input type="hidden" name="id" value="<?php echo $tarifs[$i]->id ?>" />
                                    <div class="modal-body">
                                        Temps
                                        <select name="heure">
                                            <option value="0">0</option>
                                            <?php for($j=1;$j<25;$j++) { ?>
                                            <option value="<?php echo $j; ?>"
                                                <?php if($tarifs[$i]->heure == $j) echo 'selected'; ?>><?php echo $j; ?>
                                            </option>
                                            <?php } ?>
                                        </select> h
                                        <select name="minute">
                                            <?php for($k=0;$k<60;$k++) { ?>
                                            <option value="<?php echo $k; ?>"
                                                <?php if($tarifs[$i]->minute == $k) echo 'selected'; ?>>
                                                <?php echo $k; ?></option>
                                            <?php } ?>
                                        </select> min
                                        <br>
                                        <br>
                                        Coût
                                        <input type="text" name="cout" value="<?php echo $tarifs[$i]->cout; ?>"> Ar
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Annuler</button>
                                        <button type="SUBMIT" class="btn btn-success">Modifier</button></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deletetarif<?php echo $tarifs[$i]->id; ?>" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                    <h5 class="modal-title" id="myModalLabel">
                                        </h4>
                                </div>
                                <div class="modal-body">
                                    <h3>Voulez-vous supprimer ce tarif ? </h3>
                                </div>
                                <form action="<?php echo site_url('Admin/supprimerTarif') ?>" method="post">
                                    <input type="hidden" name="id" value="<?php echo $tarifs[$i]->id ?>" />
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                                        <button type="SUBMIT" class="btn btn-primary">Oui</button></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /content-panel -->
    </div>
    <!-- /col-md-12 -->
</div>
<!-- /row -->

<div class="modal fade" id="ajouternouveautarif" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="myModalLabel">Nouveau Tarif</h4>
            </div>
            <form action="<?php echo site_url('Admin/nouveautarif') ?>" method="post">
                <div class="modal-body">
                    Temps
                    <select name="heure">
                        <option value="0">0</option>
                        <?php for($j=1;$j<25;$j++) { ?>
                        <option value="<?php echo $j; ?>">
                            <?php echo $j; ?>
                        </option>
                        <?php } ?>
                    </select> h
                    <select name="minute">
                        <?php for($k=0;$k<60;$k++) { ?>
                        <option value="<?php echo $k; ?>">
                            <?php echo $k; ?></option>
                        <?php } ?>
                    </select> min
                    <br>
                    <br>
                    Coût
                    <input type="text" name="cout" value=""> Ar
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="SUBMIT" class="btn btn-success">Ajouter</button></a>
                </div>
            </form>
        </div>
    </div>
</div>