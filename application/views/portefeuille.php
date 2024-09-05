<div class="row mt">
<div class="col-md-6">
        <div class="content-panel">
            <table class="table table-striped table-advance table-hover">
                <h4><i class="fa fa-angle-right"></i>RECHARGE PORTEFEUILLE </h4>
                <hr>
                <?php if(isset($message)) { ?><div class="alert alert-success" role="alert">
                    <H5><?php echo $message; ?></H5>
                </div>
                <?php } ?>
                <thead>
                    <tr>
                        <th><i class="fa fa-user"></i> Client </th>
                        <th class="hidden-phone"><i class="fa fa-money"></i> Montant</th>
                        <th class="hidden-phone"><i class="fa fa-calendar"></i> Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php for($i = 0 ; $i<count($portefeuilles) ; $i++) { ?>
                    <tr>
                        <td class="hidden-phone"><?php echo $portefeuilles[$i]->nom.' '.$portefeuilles[$i]->prenom; ?></td>
                        <td class="hidden-phone"><?php echo $portefeuilles[$i]->montant ?> Ar</td>
                        <td class="hidden-phone"><?php echo $portefeuilles[$i]->date_recharge ?></td>
                        <td>
                            <form action="<?php echo site_url('Admin/validationRecharge') ?>" method="post">
                                <input type="hidden" name="id" value="<?php echo $portefeuilles[$i]->id ?>" />
                                <button class="btn btn-primary btn-xs" onclick="alert('Voulez-vous valider ce recharge ?')" type="submit"><i class="fa fa-pencil"></i> Valider </button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- <div class="col-md-6">
        <div class="content-panel">
            <table class="table table-striped table-advance table-hover">
                <h4><i class="fa fa-angle-right"></i>Ajout direct au portefeuille du client </h4>
                <hr>
                <?php if(isset($message)) { ?><div class="alert alert-success" role="alert">
                    <H5><?php echo $message; ?></H5>
                </div>
                <?php } ?>
                <thead>
                    <tr>
                        <th><i class="fa fa-user"></i> Client </th>
                        <th class="hidden-phone"><i class="fa fa-money"></i> Montant</th>
                        <th class="hidden-phone"><i class="fa fa-calendar"></i> Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php for($i = 0 ; $i<count($portefeuilles) ; $i++) { ?>
                    <tr>
                        <td class="hidden-phone"><?php echo $portefeuilles[$i]->nom.' '.$portefeuilles[$i]->prenom; ?></td>
                        <td class="hidden-phone"><?php echo $portefeuilles[$i]->montant ?> Ar</td>
                        <td class="hidden-phone"><?php echo $portefeuilles[$i]->date_recharge ?></td>
                        <td>
                            <form action="<?php echo site_url('Admin/validationRecharge') ?>" method="post">
                                <input type="hidden" name="id" value="<?php echo $portefeuilles[$i]->id ?>" />
                                <button class="btn btn-primary btn-xs" type="submit"><i class="fa fa-pencil"></i> Valider </button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div> -->
</div>