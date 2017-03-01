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

TODO : avoid access to forbidden files via /.. (url rewrite???)\


<b>Perso : planning : </b><br>
Lundi : finir ajout de fichiers en db.DONE<br>
Mardi : finir affichage des fichiers et gestion des fichiers.<br>
Mercredi : Système de dossier.<br>
Jeudi : visualisation + modification de dossier<br>
Vendredi : Fichiers de log.<br>
et jours suivants : Si retard à rattrapper + refactoriser, vérifier, 
ajouter bonus etc.