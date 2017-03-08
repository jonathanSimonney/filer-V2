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


!<b>important<b>!!!

check for move action to parent. Bug telling user tries to access a forbidden file.