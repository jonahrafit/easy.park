<br>
<div class="row">
    <!-- WEATHER PANEL -->
    <div class="col-md-3 mb">
        <div class="twitter-panel pn">
            <i class="fa fa-euro fa-4x"></i>
            <p>
            <h3>Solde de mon compte</h3>
            </p>
            <h1>
                <p><?php echo $soldes['solde']; ?> Ar</p>
            </h1>
        </div>
    </div>
    <div class="col-md-3 mb">
        <div class="message-p pn">
            <div class="message-header">
                <h5>Ajout de monnaie dans portefeuille </h5>
            </div>
            <div class="row-mt">
                <div class="col-md-12">
                    <form class="form-horizontal" role="form"
                        action="<?php echo site_url('Compte/ajoutDansPortfeuille'); ?>" method="post">
                        <label class="sr-only" for="montant">Montant </label>
                        <input type="number" class="form-control" id="montant" name="montant"
                            placeholder="Taper le montant"><br>
                        <button type="submit" class="btn btn-theme">Ajouter</button>
                    </form>
                </div>
            </div>
            <?php if(isset($message)) { ?>
            <br>
            <br>
            <H4 style="color: green"><?php echo $message; ?></H4>
            <?php } ?>
        </div>
    </div>
    <!-- <div class="col-md-3 col-sm-3 mb">
        <div class="green-panel pn">
            <div class="green-header">
                <h5>PAYER UNE AMENDE</h5>
            </div>
            <div class="row-mt">
                <div class="col-md-12">
                    <form class="form-horizontal" role="form"
                        action="<?php echo site_url('Compte/ajoutDansPortfeuille'); ?>" method="post">
                        Montant
                        <input type="number" class="form-control" id="montant" name="montant" value="150000"
                            placeholder="Taper le montant" disabled><br>
                        Voiture
                        <input type="text" class="form-control" name="voiture">
                        <br>
                        <!-- <button type="submit" class="btn btn-primary" disable>Payer</button> -->
                    <!-- </form>
                </div>
            </div>
            <?php if(isset($message)) { ?>
            <br>
            <br>
            <H4 style="color: green"><?php echo $message; ?></H4>
            <?php } ?> -->
        </div>
    </div>
</div>