<?php
function my_autoloader($class) {
    $file = str_replace('\\', '/', $class) . '.php';
    //var_dump($file, 'class', $class);
    // echo '=> Including '.$file . '<br>';
    require_once $file;
}
spl_autoload_register('my_autoloader');