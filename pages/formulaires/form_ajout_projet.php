
	 <form action="" method="post">
		<p> Saisir un projet </p>

		</BR></BR>

		Client : <input type = "texte" name = "customer"/></BR>
		Titre  : <input type = "texte" name = "title"/></BR>

        Nombre d'étudiant :
        <?php
            echo '<select nbStudent="liste">';
            for($i=2; $i<=10; $i++){
                echo '<option value="'.$i.'">'.$i.'</option>';
            }
            echo '</select>';
        ?>
        </BR>

        Description : <input type = "texte" name = "description"/></BR>
        Fichier Joint </BR>


		<input type="button" value="Annuler" onclick="location.href='form_ajout_projet.php'" />
		<input type = "submit" value = "Soumettre"/>

		</BR></BR>



	</form>
