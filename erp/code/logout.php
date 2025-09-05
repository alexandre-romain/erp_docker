<?php 
ini_set('session.save_path', 'include/session'); 

session_start();
session_register('trucmuch');

session_unset();
session_destroy();
    //Efface les fichiers temporaires
    $dir = "fpdf/output" ;
    $t=time();
    $h=opendir($dir);
    while($file=readdir($h))
    {
        if(substr($file,-4)=='.pdf')
        {
            $path=$dir.'/'.$file;
            if($t-filemtime($path)>3)
                @unlink($path);
        }
    }
    closedir($h);

include("login.php");

 ?> 