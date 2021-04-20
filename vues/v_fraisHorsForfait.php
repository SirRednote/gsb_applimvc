<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<hr>
</br>
<div class="col-md-12" >
    <div class="panel panel-info">
        <div class="panel-heading">Descriptif des éléments hors forfait</div>
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th class="date">Date</th>
                    <th class="libelle">Libellé</th>  
                    <th class="montant">Montant</th>  
                    <th class="action">&nbsp;</th> 
                </tr>
            </thead>  
            <tbody>
                <?php
                $nbJustificatifs=0;
                foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                    $nbJustificatifs++;
                    $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                    $libelle=  substr($libelle,0,20);
                    $date = $unFraisHorsForfait['date'];
                    $montant = $unFraisHorsForfait['montant'];
                    $id = $unFraisHorsForfait['id'];
                ?>
                <form action="index.php?uc=corriger_frais&action=horsforfait"  method="post" role="form">
                <tr> 
                    <td><input class="form-control"  type="text" id="iddate" size="10" name="lesFraisD[<?php echo $id ?>]" value="<?php echo $date ; ?>" ></td>
                    <td><input class="form-control" type="text" id="idlib" size="10"  name="lesFraisL[<?php echo $id ?>]" value="<?php echo $libelle ; ?>" ></td>    
                    <td><input class="form-control" type="text" id="idmontant" size="10" name="lesFraisM[<?php echo $id ?>]" value="<?php echo $montant ;?>" ></td>
                    <input id="id"  name="FraisHorsForfait[<?php echo $id ?>]" value="<?php echo $id ?>" type="hidden">
                    <td>
                        <button class="btn btn-success" type="submit" class="btn btn-default" name="corriger" value="corriger">Corriger</button>
                        <button class="btn btn-success" type="submit" class="btn btn-default" name="reporter" value="reporter">reporter</button>
                        <button class="btn btn-danger" type="reset" class="btn btn-default" >Reinitialiser</button>
                    </td>     
                    <!--  <input class="form-control" value="<?php //echo $nbJustificatifs; ?>" name="nbJustificatifs" type="hidden"> -->
                    </form>
                </tr>
        </div>                           
        <?php
            }
        ?>
            </tbody>
        </table>
    </div>
       
<div class="form-group ">
    <form action="index.php?uc=corriger_frais&action=valider_frais"  method="post" role="form"> 
    <label  class="col-sm-2 col-form-label">Nombre de justifiquatifs:</label>
    <input class="form-control" id="nbJustificatifs" name="nbJustificatifs" value="<?php echo $nbJustificatifs; ?>" name="nbJustificatifs" style="width:50px;">
        <button class="btn btn-success" type="submit">Valider</button> 
        <button class="btn btn-danger" type="reset">Reinitialiser</button>  
    </form>
</div>