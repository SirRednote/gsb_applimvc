<?php

?>

<div class="row">
    <div class="col-md-4">
        <?php 
            $uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING);
            if($uc=='validerFrais'|| $uc=='corriger_frais'){
        ?>
        <form action="index.php?uc=corriger_frais&action=afficherFrais" method="post" role="form">
        <?php } else { ?>
        <form action="index.php?uc=SuivrePaiement&action=suivre_LePaiment" method="post" role="form"><?php
    }
?>
           <?php ?>

            <div class="form-group" style="display: inline-block">
                <label for="lstVisiteurs" accesskey="n">Choisir le visiteur : </label>
                <select id="lstVisiteurs" name="lstVisiteurs" class="form-control">
                    <?php
                    foreach ($lesVisiteurs as $unVisiteur) {
                        $id = $unVisiteur['id'];
                        $nom = $unVisiteur['nom'];
                        $prenom = $unVisiteur['prenom'];
                        if ($unVisiteur == $visiteurASelectionner) {
                            ?>
                            <option selected value="<?php echo $id ?>">
                                <?php echo $nom . ' ' . $prenom ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $id ?>">
                                <?php echo $nom . ' ' . $prenom ?> </option>
                            <?php
                        }
                    }
                    ?>    
                </select>
            </div>

            <?php//liste dÃŠroulante des mois?>

            &nbsp;<div class="form-group" style="display: inline-block">
                <label for="lstMois" accesskey="n">Mois : </label>
                <select id="lstMois" name="lstMois" class="form-control">
                    <?php
                    foreach ($lesMois as $unMois) {
                        $mois = $unMois['mois'];
                        $numAnnee = $unMois['numAnnee'];
                        $numMois = $unMois['numMois'];
                        if ($mois == $moisASelectionner) {
                            ?>
                            <option selected value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        }
                    }
                    ?>    

                </select>
            </div>
                <input id="ok" type="submit" value="Valider" class="btn btn-success" role="button">
        </form>
    </div>