launch index.php each time.
You'll need to create your own private.php file, and within it,
 put the following line : <br>$db_config = [<br>
                            'name' => 'YOUR_DB_NAME',<br>
                            'host' => 'YOUR_HOST',<br>
                            'user' => 'YOUR_ADMIN_USERNAME',<br>
                            'pass' => 'YOUR_ADMIN_PASSWORD'<br>
                        ];

PS : (Don't forget the <?php at the beginning of this private.php file, obviously...)
<br>This file should be put in the config folder. 

TODO : change my trash picture.
check why page longer than screen width.
avoid access to forbidden files via /.. (url rewrite???)\
add a go to root button (easier navigation...)


<b>Perso : planning : </b><br>
Lundi : finir ajout de fichiers en db.DONE<br>
Mardi : finir affichage des fichiers et gestion des fichiers.DONE<br>
Mercredi : Système de dossier.DONE<br>
Jeudi : visualisation + modification de dossier almost done<br>
Vendredi : Fichiers de log.<br>
et jours suivants : Si retard à rattrapper + refactoriser, vérifier, 
ajouter bonus etc.