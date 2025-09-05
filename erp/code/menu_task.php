<?php
    function affiche_menu($rowid)
    {
        // tableaux contenant les liens d'accès et le texte à afficher
        $tab_menu_lien = array( "fichetask_task.php?rowid=".$rowid."", "fichetask_materiel.php?rowid=".$rowid."", "fichetask_prix.php?rowid=".$rowid."" );
        $tab_menu_texte = array( "T&acirc;che", "Mat&eacute;riel", "Temps de Travail" );
         
        // informations sur la page
        $info = pathinfo($_SERVER['PHP_SELF']);
 
        $menu = "\n<div id=\"menu\">\n    <ul id=\"onglets\">\n";
 
         
 
        // boucle qui parcours les deux tableaux
        foreach($tab_menu_lien as $cle=>$lien)
        {
            $menu .= "    <li";
            //$lieninter = explode ('?',$cle=>lien)
			//$lienok = $lieninter[0];
            // si le nom du fichier correspond à celui pointé par l'indice, alors on l'active
			$lien2 = '?rowid='.$rowid.'';
            if( $info['basename'].$lien2 == $lien )
                $menu .= " class=\"active\"";
                 
            $menu .= "><a href=\"" . $lien . "\">" . $tab_menu_texte[$cle] . "</a></li>\n";
        }
         
        $menu .= "</ul>\n</div>";
         
        // on renvoie le code xHTML
        return $menu;        
    }
?>