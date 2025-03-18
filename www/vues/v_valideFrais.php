<?php
/**
 * Vue État de Frais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
?>
<form action="index.php?uc=validerFrais&action=corrigerFraisForfait" 
       method="post" role="form">
<div class="class-row">
<label for="lstVisiteur" >Choisir un visiteur : </label>
<select id="lstVisiteur" name="lstVisiteur" class="form-control">
    <?php
    foreach ($lesVisiteurs as $unVisiteur) {
        $id = $unVisiteur['id'];
        $nom = $unVisiteur['nom'];
        $prenom = $unVisiteur['prenom'];
        if ($id == $visiteurASelectionner) {
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


<label for="lstVisiteur" >Mois : </label>
<select id="lstMois" name="lstMois" class="form-control">
    <?php
    foreach ($douzeMois as $unMois) {
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
<br>
</div>




<div class="row">    
    <h2 style='color: #fd9040'>Valider la fiche de frais</h2>

    <h3>Eléments forfaitisés</h3>
    <div class="col-md-4">
        <form method="post" 
              action="index.php?uc=validerFrais&action=corrigerFraisForfait" 
              role="form">
            <fieldset>       
                <?php
                foreach ($lesFraisForfait as $unFrais) {
                    $idFrais = $unFrais['idfrais'];
                    $libelle = htmlspecialchars($unFrais['libelle']);
                    $quantite = $unFrais['quantite']; ?>
                    <div class="form-group">
                        <label for="idFrais"><?php echo $libelle ?></label>
                        <input type="text" id="idFrais" 
                               name="lesFrais[<?php echo $idFrais ?>]"
                               size="10" maxlength="5" 
                               value="<?php echo $quantite ?>" 
                               class="form-control">
                    </div>
                    <?php
                }
                ?>
                <button class="btn btn-success" type="submit">Corriger</button>
                <button class="btn btn-danger" type="reset">Reinitialiser</button>
            </fieldset>
        
    </div>
</div>

</form>



<form action="index.php?uc=validerFrais&action=corrigerFraisHorsForfait" 
       method="post" role="form">
    <input type="hidden" name="lstVisiteur" value="<?php echo $visiteurASelectionner ?>"/>
    <input type="hidden" name="lstMois" value="<?php echo $moisASelectionner ?>"/> 
    <hr>
    <div class="row">
    <div class="panel panel-info" style = "border-color: orange">
        <div class="panel-heading" style = "background-color: orange; color: white" >Descriptif des éléments hors forfait</div>
        <table class="table table-bordered table-responsive" style = "border-color: orange">
            <thead>
                <tr>
                    <th style = "border-color: orange" class="date" >Date</th>
                    <th style = "border-color: orange" class="libelle"border-color: orange>Libellé</th>  
                    <th style = "border-color: orange" class="montant">Montant</th>  
                    <th style = "border-color: orange" class="action">&nbsp;</th> 
                </tr>
            </thead>  
            <tbody>
            <?php
            foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                $date = $unFraisHorsForfait['date'];
                $montant = $unFraisHorsForfait['montant'];
                $id = $unFraisHorsForfait['id']; ?>           
                
                <tr>
                    
                    <input type="hidden" name="idFrais" value="<?php echo $id ?>"/> 
                    <td style="border-color: orange"><input type="text" value ="<?php echo $date ?>" name="date" /></td>
                    <td style="border-color: orange"><input type="text" value ="<?php echo $libelle ?>" name="libelle" /></td>
                    <td style="border-color: orange"><input type="text" value ="<?php echo $montant ?>" name="montant" /></td>
                    <td>
                        <input id="corriger" name="corriger" value="corriger" class="btn btn-success" type="submit">
                        <input id="reporter" name="reporter" value="reporter" class="btn btn-success" type="submit">
                        <input id="supprimer" name="supprimer" value="supprimer" class="btn btn-danger" type="submit">
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>  
        </table>
    </div>
</div>



    <div>Nombres de justificatifs : 
        <input name="forfait_etape" type="text" size="3 px" value="<?php echo $justificatifs ?>"/> 
    </div>
    <br>
    </form>
        
        
    <form action="index.php?uc=validerFrais&action=valider" method="post" role="form">
               
    <input type="hidden" name="lstVisiteur" value="<?php echo $visiteurASelectionner ?>"/>
    <input type="hidden" name="lstMois" value="<?php echo $moisASelectionner ?>"/>
    <input id="valider" name="valider" value="valider" class="btn btn-success" type="submit">

    </form>