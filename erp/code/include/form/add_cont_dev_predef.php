<?php
include("../config/common.php");
include("../fonctions.php");
//On récupère les var
$type_inter=$_REQUEST['type_add_cont'];
$art=$_REQUEST['article'];
$id_devis=$_REQUEST['id_devis'];
$nbr=$_REQUEST['nbr'];
//On enlève le "rech_" du $type_inter (utilisé pour la fct de recherche).
$type=str_replace("rech_", "", $type_inter);
//On récupère les totaux du devis actuel
$sql="SELECT tot_htva, tot_tva, tot_recupel, tot_reprobel, tot_auvibel, tot_bebat FROM ".$tblpref."dev_predef WHERE id='".$id_devis."'";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
$tot_htva=$obj->tot_htva;
$tot_tva=$obj->tot_tva;
$tot_recupel=$obj->tot_recupel;
$tot_reprobel=$obj->tot_reprobel;
$tot_auvibel=$obj->tot_auvibel;
$tot_bebat=$obj->tot_bebat;
//On récupère le prix de l'article
$sql="SELECT * FROM ".$tblpref."article WHERE num='".$art."'";
echo $sql;
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
$price_ht=$obj->prix_htva;
$marge=$obj->marge;
	//On calcule le PV
$pv_ht=(($price_ht/100)*$marge)+$price_ht;
	//On calcul la TVA
$taux_tva=$obj->taux_tva;
$tva=($pv_ht/100)*$taux_tva;
	//On récupère les taxes
$auvibel=$obj->auvibel;
$recupel=$obj->recupel;
$reprobel=$obj->reprobel;
$bebat=$obj->bebat;
//On tiens compte du nombre
$pu=$pv_ht;
$pv_ht=$pv_ht*$nbr;
$tva=$tva*$nbr;
$auvibel=$auvibel*$nbr;
$recupel=$recupel*$nbr;
$reprobel=$reprobel*$nbr;
$bebat=$reprobel*$nbr;
//On calcule les nouveaux totaux
$ntot_htva=$tot_htva+$pv_ht;
$ntot_tva=$tot_tva+$tva;
$ntot_recupel=$tot_recupel+$recupel;
$ntot_reprobel=$tot_reprobel+$reprobel;
$ntot_auvibel=$tot_auvibel+$auvibel;
$ntot_bebat=$tot_bebat+$bebat;
//On update les totaux
$sql="UPDATE ".$tblpref."dev_predef SET tot_htva='".$ntot_htva."', tot_tva='".$ntot_tva."', tot_recupel='".$ntot_recupel."', tot_reprobel='".$ntot_reprobel."', tot_auvibel='".$ntot_auvibel."', tot_bebat='".$ntot_bebat."' WHERE id='".$id_devis."'";
$req=mysql_query($sql);
//On insère l'article dans cont_bon
$sql="INSERT INTO ".$tblpref."cont_dev_predef(id_dev_predef, article_num, quanti, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel, p_u, type) VALUES('".$id_devis."', '".$art."', '".$nbr."', '".$pv_ht."', '".$tva."', '".$recupel."', '".$reprobel."', '".$bebat."', '".$auvibel."', '".$pu."', '".$type."')";
$req=mysql_query($sql);
?>