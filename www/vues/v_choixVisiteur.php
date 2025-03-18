<div class="col-md-4">
    <form action="index.php?uc=validerFrais&action=ficheVisiteur" 
          method="post" role="form">
        <label for="lstVisiteur" >Choisir un visiteur : </label>
        <select id="lstVisiteur" name="lstVisiteur" class="form-control">
            <?php
            foreach ($lesVisiteurs as $unVisiteur) {
                $id = $unVisiteur['id'];
                $nom = $unVisiteur['nom'];
                $prenom = $unVisiteur['prenom'];
                if ($id == $idASelectionner) {
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
        <select id="lstMois" name="lstmois" class="form-control">
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

        <div>
            <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                   role="button">
        </div>
    </form>
</div>