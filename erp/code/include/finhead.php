</head>
<body>
<?php 
//Récupération des accès utilisateurs.
$sql = "SELECT * FROM " . $tblpref ."user WHERE num = '".$num_user."'";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
{
	$dev = $data['dev'];
	$com = $data['com'];
	$bl = $data['bl'];
	$fact = $data['fact'];
	$dep = $data['dep'];
	$art = $data['art'];
	$cli = $data['cli'];
	$stat = $data['stat'];
	$admin = $data['admin'];
}
?>
<div class="container">
    <!-- Push Wrapper -->
    <div class="mp-pusher" id="mp-pusher">
        <!-- mp-menu -->
        <nav id="mp-menu" class="mp-menu" style="color:#ecf0f1">
            <div class="mp-level">
                <h2 class="icons fa-home">Menu</h2>
                <ul style="color:#ecf0f1">
                    <li><a class="icons fa-tachometer entree_menu" href="./accueil.php" >Tableau de bord</a></li>
                    <li class="icon icon-arrow-left">
                        <a class="icons fa-ticket entree_menu" href="#">Tickets</a>
                        <div class="mp-level">
                            <h2 class="icons fa-ticket">Tickets</h2>
                            <a class="mp-back entree_menu" href="#">retour</a>
                            <ul>
                                <li><a href="./new_task.php" class="icons fa-pencil entree_menu">Cr&eacute;er</a></li>
                                <li><a href="./list_task.php" class="icons fa-list entree_menu">Lister les t&acirc;ches</a></li>
                                <li><a href="./list_ticket.php" class="icons fa-list-alt entree_menu">Lister les tickets</a></li>
                                <li><a href="./param_ticket.php" class="icons fa-cog entree_menu">Paramètres</a></li>
                            </ul>
                        </div>
                    </li>
                    <?php
					if ($dev == 'y') {
					?>
                    <li class="icon icon-arrow-left">
                        <a class="icons fa-hand-o-right entree_menu" href="#">Devis</a>
                        <div class="mp-level">
                            <h2 class="icons fa-hand-o-right">Devis</h2>
                            <a class="mp-back entree_menu" href="#">retour</a>
                            <ul>
                                <li><a href="./form_devis.php" class="icons fa-pencil entree_menu">Cr&eacute;er</a></li>
                                <li><a href="./lister_devis.php" class="icons fa-list entree_menu">Lister</a></li>
                                <li><a href="./devis_predef.php" class="icons fa-floppy-o entree_menu">Pr&eacute;d&eacute;finis</a></li>
                                <li><a href="./chercher_devis.php" class="icons fa-search entree_menu">Chercher</a></li>
                                <li><a href="./devis_non_commandes.php" class="icons fa-frown-o entree_menu">Non-command&eacute;s</a></li>
                            </ul>
                        </div>
                    </li>
                    <?php
					}
					if ($com == 'y') {
					?>
                    <li class="icon icon-arrow-left">
                    	<a class="icons fa-phone entree_menu" href="#">Commandes</a>
                        <div class="mp-level">
                            <h2 class="icons fa-phone">Commandes</h2>
                            <a class="mp-back entree_menu" href="#">retour</a>
                            <ul>
                                <li><a href="./form_commande.php" class="icons fa-pencil entree_menu">Cr&eacute;er</a></li>
                                <li><a href="./lister_commandes.php" class="icons fa-list entree_menu">Lister</a></li>
                                <li><a href="./chercher_commande.php" class="icons fa-search entree_menu">Chercher</a></li>
                                <li><a href="./lister_commandes_non_facturees.php" class="icons fa-map-signs entree_menu">Non-livr&eacute;es</a></li>
                                <li><a href="./bos.php" class="icons fa-clock-o entree_menu">Back-Orders</a></li>
                                <li><a href="./fichier_commande.php" class="icons fa-truck entree_menu">Fichier des commandes</a></li>
                            </ul>
                        </div>
                    </li>
                    <?php
					}
					if ($bl == 'y') {
					?>
                    <li class="icon icon-arrow-left">
                    	<a class="icons fa-truck entree_menu" href="#">Bons de livraison</a>
                        <div class="mp-level">
                            <h2 class="icons fa-phone">Bons de livraison</h2>
                            <a class="mp-back entree_menu" href="#">retour</a>
                            <ul>
                                <li><a href="./form_bl.php" class="icons fa-pencil entree_menu">Cr&eacute;er</a></li>
                                <li><a href="./lister_bl.php" class="icons fa-list entree_menu">Lister</a></li>
                                <li><a href="./chercher_bl.php" class="icons fa-search entree_menu">Chercher</a></li>
                                <li><a href="./lister_bl_non_factures.php" class="icons fa-clock-o entree_menu">En cours</a></li>
                            </ul>
                        </div>
                    </li>
                    <?php
					}
					if ($fact == 'y') {
					?>
                    <li class="icon icon-arrow-left">
                    	<a class="icons fa-money entree_menu" href="#">Factures</a>
                        <div class="mp-level">
                            <h2 class="icons fa-phone">Factures</h2>
                            <a class="mp-back entree_menu" href="#">retour</a>
                            <ul>
                                <li><a href="./form_facture.php" class="icons fa-pencil entree_menu">Cr&eacute;er</a></li>
                                <li><a href="./lister_factures.php" class="icons fa-list entree_menu">Lister</a></li>
                                <li><a href="./chercher_factures.php" class="icons fa-search entree_menu">Chercher</a></li>
                                <li><a href="./lister_factures_non_reglees.php" class="icons fa-gavel entree_menu">Facture impay&eacute;es</a></li>
                                <li><a href="./listing_tva.php" class="icons fa-download entree_menu">Listing TVA</a></li>
                                <li><a href="./impression_groupee.php" class="icons fa-print entree_menu">Impression group&eacute;e</a></li>
                                <li><a href="./lister_nc.php" class="icons fa-list-alt entree_menu">Rechercher N.C.</a></li>
                                <li><a href="./nc.php" class="icons fa-paint-brush entree_menu">Créer N.C.</a></li>
                            </ul>
                        </div>
                    </li>
                    <?php
					}
					if ($dep == 'y') {
					?>
                    <li class="icon icon-arrow-left">
                    	<a class="icons fa-credit-card entree_menu" href="#">Achats</a>
                        <div class="mp-level">
                            <h2 class="icons fa-phone">Achats</h2>
                            <a class="mp-back entree_menu" href="#">retour</a>
                            <ul>
                                <li><a href="./form_depenses.php" class="icons fa-pencil entree_menu">Cr&eacute;er</a></li>
                                <li><a href="./lister_depenses.php" class="icons fa-list entree_menu">Lister</a></li>
                                <li><a href="./chercher_dep.php" class="icons fa-search entree_menu">Chercher</a></li>
                                <li><a href="./stats_dep.php" class="icons fa-pie-chart entree_menu">Stats par fournisseur</a></li>
                            </ul>
                        </div>
                    </li>
                    <?php
					}
					if ($art == 'y') {
					?>
                    <li class="icon icon-arrow-left">
                    	<a class="icons fa-binoculars entree_menu" href="#">Articles</a>
                        <div class="mp-level">
                            <h2 class="icons fa-phone">Articles</h2>
                            <a class="mp-back entree_menu" href="#">retour</a>
                            <ul>
                                <li><a href="./form_article.php" class="icons fa-pencil entree_menu">Cr&eacute;er</a></li>
                                <li><a href="./lister_articles_form.php" class="icons fa-list entree_menu">Lister</a></li>
                            </ul>
                        </div>
                    </li>
                    <?php
					}
					if ($cli == 'y') {
					?>
                    <li class="">
                    	<a class="icons fa-users entree_menu" href="./form_client.php">Clients</a>
                    </li>
                    <li class="">
                    	<a href="./packages.php" class="icons fa-shopping-cart entree_menu">Packages</a>
                    </li>
                    <li class="">
                    	<a href="./contrats.php" class="icons fa-gavel entree_menu">Contrats</a>
                    </li>					
                    <?php
					}
					if ($stat == 'y') {
					?>
                    <li class="icon icon-arrow-left">
                    	<a class="icons fa-bar-chart entree_menu" href="#">Stats</a>
                        <div class="mp-level">
                            <h2 class="icons fa-phone">Stats</h2>
                            <a class="mp-back entree_menu" href="#">retour</a>
                            <ul>
                                <li><a href="./stats_tickets.php" class="icons fa-bar-chart entree_menu">Stats tickets</a></li>
                                <li><a href="./ca_articles.php" class="icons fa-bar-chart entree_menu">Stats tous les articles</a></li>
                                <li><a href="./stat_article.php" class="icons fa-area-chart entree_menu">Stats un article</a></li>
                                <li><a href="./form_stat_client.php" class="icons fa-line-chart entree_menu">Stats un client</a></li>
                                <li><a href="./ca_annee.php" class="icons fa-line-chart entree_menu">C.A. annuel global</a></li>
                                <li><a href="./ca_parclient.php" class="icons fa-area-chart entree_menu">C.A. annuel tous les clients</a></li>
                                <li><a href="./ca_parclient_1mois.php" class="icons fa-area-chart entree_menu">C.A. mensuel tous les clients</a></li>
                            </ul>
                        </div>
                    </li>
                    <?php
					}
					if ($admin == 'y') {
					?>
                    <li class="icon icon-arrow-left">
                    	<a class="icons fa-wrench entree_menu" href="#">Outils</a>
                        <div class="mp-level">
                            <h2 class="icons fa-phone">Outils</h2>
                            <a class="mp-back entree_menu" href="#">retour</a>
                            <ul>
                                <li><a href="./form_utilisateurs.php" class="icons fa-user-plus entree_menu">Ajouter utilisateur</a></li>
                                <li><a href="./lister_utilisateurs.php" class="icons fa-users entree_menu">Lister utilisateurs</a></li>
                                <li><a href="./form_mailing.php" class="icons fa-envelope-o entree_menu">Mailing-list</a></li>
                                <li><a href="./form_backup.php" class="icons fa-hdd-o entree_menu">Backup</a></li>
                                <li><a href="./admin.php" class="icons fa-cogs entree_menu">Paramètres</a></li>
                                <li><a href="./form_tarifs.php" class="icons fa-money entree_menu">Tarifs</a></li>
                                <li><a href="./form_abos.php" class="icons fa-clock-o entree_menu">Abonnement</a></li>
                            </ul>
                        </div>
                    </li>
                    <?php
					}
					?>
                    <li><a class="icons fa-user entree_menu" href="./profil_user.php">Profil</a></li>
                </ul>
                    
            </div>
        </nav>
        <!-- /mp-menu -->
        <div class="scroller"><!-- this is for emulating position fixed of the nav -->
        	<a href="#" id="trigger" class="button-menu action" title="Afficher le menu"><i class="fa fa-chevron-circle-right fa-4x"></i></a>