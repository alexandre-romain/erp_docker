<?php
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/".$lang.".php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");			
include_once("include/head.php");
//Récupération de l'user
$user = $_SERVER[PHP_AUTH_USER];
//Récupération de l'ID de l'inter
$rowid = addslashes($_REQUEST['rowid']);

//Requète de récupération des infos nécessaire pour populer le tableau d'inter
$sql = "SELECT i.nom as inom, i.descr as idescr, i.date_debut as idate_debut, i.date_fin as idate_fin, c.nom as snom, u.login as ulogin, c.num_client as srowid, u.num as urowid, i.rowid as irowid, i.fk_technician as ifk_technician, i.fk_technician2 as ifk_technician2, i.tarif_special as ts, i.type_deplacement as td";
$sql .= " FROM ".$tblpref."inter as i";
$sql .= " LEFT JOIN ".$tblpref."inter_tache as it ON it.fk_inter = i.rowid ";
$sql .= " LEFT JOIN ".$tblpref."user as u ON u.num = i.fk_createur ";
$sql .= " LEFT JOIN ".$tblpref."client as c ON c.num_client = i.fk_soc ";
$sql .= " WHERE i.rowid='$rowid'";
$reqsql= mysql_query($sql);
$result= mysql_fetch_object($reqsql);

//Isolation dans une variable du rowid USER afin de pouvoir exclure l'user en question de la boucle permettant de lister les users (afin d'éviter les doublons)
$urowid=$result->urowid;
$id_user2=$result->ifk_technician;
$id_user3=$result->ifk_technician2;

//Requête de récupération des deux logins user
$sql_user2="SELECT login";
$sql_user2.=" FROM ".$tblpref."user";
$sql_user2.=" WHERE num=".$id_user2."";
$req_user2=mysql_query($sql_user2);
$result_user2=mysql_fetch_object($req_user2);
$login_user2=$result_user2->login;

$sql_user3="SELECT login";
$sql_user3.=" FROM ".$tblpref."user";
$sql_user3.=" WHERE num=".$id_user3."";
$req_user3=mysql_query($sql_user3);
$result_user3=mysql_fetch_object($req_user3);
$login_user3=$result_user3->login;

//Convertion des dates en forme EU
$dateinter = explode ('-', $result->idate_debut);
$annee = $dateinter[0];
$mois = $dateinter[1];
$jour = $dateinter[2];
$datedebutcorrect = $jour.'-'.$mois.'-'.$annee;

$dateinter = explode ('-', $result->idate_fin);
$annee = $dateinter[0];
$mois = $dateinter[1];
$jour = $dateinter[2];
$datefincorrect = $jour.'-'.$mois.'-'.$annee;
?>
<head>
<style type="text/css" media="screen">
	@import "include/css/demo_table_jui.css";
	@import "include/css/jquery-ui-1.7.2.custom.css";	
	@import "include/css/form.css";
</style> 
<!-- Datatables Editable plugin -->
<script type="text/javascript" src="include/js/autocomplete.js"></script>
<script type="text/javascript" src="include/js/jquery-1.10.0.js"></script>
<script type="text/javascript" src="include/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="include/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="include/js/jquery.dataTables.editable.js"></script>
<script type="text/javascript" src="include/js/jquery.jeditable.js"></script>
<script type="text/javascript" src="include/js/jquery-ui.js"></script>
<script type="text/javascript" src="include/js/jquery.validate.js"></script>
<script type="text/javascript" src="include/js/datepicker.js"></script>       
</head>
<body>
<div class="form">Modifier Intervention</div>

<form id="formAddNewRow" action="include/ajax/FormEditInter.php" title="Ajouter une intervention" class="form" method="POST">

<fieldset>
 <legend> Le client </legend>
    <label for="search_soc"><i>Recherche Client (3carac min.)</i></label>
    <input type="text" size="25" value="<?php echo $result->snom; ?>" id="search_soc" name="search_soc" onKeyUp="javascript:autosuggest('asoc')" autocomplete="off" class="form"/><!--  champ texte à analyser pour les suggestions -->   
    <label for="soc">Client</label>
    <select id="soc" name ="soc" rel="1" class="form">
    <option value="<?php echo $result->srowid ?>"><?php echo $result->snom ?></option>
    </select>
</fieldset>

<fieldset>
 <legend> L'intervention </legend>
    <label for="name">Nom de l'intervention</label>
    <input type="text" size="25" name="name" id="name" class="form" rel="0" autocomplete="off" value="<?php echo $result->inom; ?>"/>
    <br />
    <label for="date_debut">Date de d&eacute;but</label>
    <input type="text" size="25" name="date_debut" id="date_debut" class="form" rel="2" autocomplete="off" value="<?php echo $datedebutcorrect; ?>"/>
    <br />
    <label for="date_fin">Date de fin</label>
    <input type="text" size="25" name="date_fin" id="date_fin" class="form" rel="3" autocomplete="off" value="<?php echo $datefincorrect; ?>"/>
    <br />
    <label for="descr">Description</label>
    <textarea size="25" name="descr" id="descr" class="form" autocomplete="off" rel="5" />
    <?php echo $result->idescr; ?>
    </textarea>
    <br />
    <label for="deplacement">D&eacute;placement</label>
    <select name="deplacement" id="deplacement">
      <option value="0" <?php if ($result->td == '0') {echo 'selected';}?>>Aucun</option>
      <option value="1" <?php if ($result->td == '1') {echo 'selected';}?>>- 20km</option>
      <option value="2" <?php if ($result->td == '2') {echo 'selected';}?>>20 - 40km</option>
      <option value="3" <?php if ($result->td == '3') {echo 'selected';}?>>40+ km</option>
    </select>
    <br />
    <label for="tarif_special">Tarif Sp&eacute;cial</label>
    <select name="tarif_special" id="tarif_special">
      <option value="1" <?php if ($result->ts == '1') {echo 'selected';}?>>Non</option>
      <option value="2" <?php if ($result->ts == '2') {echo 'selected';}?>>19h+</option>
      <option value="3" <?php if ($result->ts == '3') {echo 'selected';}?>>Dimanche / F&eacute;ri&eacute; / 22h+</option>
      <option value="4" <?php if ($result->ts == '4') {echo 'selected';}?>>Tarif r&eacute;duit</option>
      <option value="5" <?php if ($result->ts == '5') {echo 'selected';}?>>Contrat Maintenance</option>
    </select>
    </fieldset>
<?php
if ($user == 'alex' || $user == 'christophe') {
?>
<fieldset>
 <legend> Les responsables </legend>
    <label for="user" >Responsable Inter</label>
    <select name="user" id="user" rel="4" class="form">
    <option value="<?php echo $result->urowid ?>"><?php echo $result->ulogin ?></option>		
            <?php
            
            $sql1 = "SELECT login, num ";
            $sql1 .= " FROM ".$tblpref."user";
            $sql1 .= " WHERE num!=$urowid";
            //$sql1 .= " ORDER by p.rowid";
                
                $resql=mysql_query($sql1);
                if ($resql)
                {
                    $num = mysql_num_rows($resql);
                    $i = 0;
                    if ($num)
                    {
                        while ($i < $num)
                        {
                                    $obj = mysql_fetch_object($resql);						
                                    if ($obj)
                                    {
                                        echo '<option value="'.$obj->num.'">'.$obj->login.'</option>';
                                        // You can use here results
                                        
                                    }	
                            $i++;
                        }
                    }
                }
            
            ?>
    </select>
    <select name="user2" id="user2" class="form">
    <option value="<?php echo $result->ifk_technician ?>"><?php echo $login_user2; ?></option>		
            <?php
            
            $sql1 = "SELECT login, num ";
            $sql1 .= " FROM ".$tblpref."user";
            $sql1 .= " WHERE num!=$id_user2";
            //$sql1 .= " ORDER by p.rowid";
                
                $resql=mysql_query($sql1);
                if ($resql)
                {
                    $num = mysql_num_rows($resql);
                    $i = 0;
                    if ($num)
                    {
                        while ($i < $num)
                        {
                                    $obj = mysql_fetch_object($resql);						
                                    if ($obj)
                                    {
                                        echo '<option value="'.$obj->num.'">'.$obj->login.'</option>';
                                        // You can use here results
                                        
                                    }	
                            $i++;
                        }
                    }
                }
            
            ?>
    </select>
    <select name="user3" id="user3" class="form">
    <option value="<?php echo $result->ifk_technician2 ?>"><?php echo $login_user3; ?></option>		
            <?php
            
            $sql1 = "SELECT login, num ";
            $sql1 .= " FROM ".$tblpref."user";
            $sql1 .= " WHERE num!=$id_user3";
            //$sql1 .= " ORDER by p.rowid";
                
                $resql=mysql_query($sql1);
                if ($resql)
                {
                    $num = mysql_num_rows($resql);
                    $i = 0;
                    if ($num)
                    {
                        while ($i < $num)
                        {
                                    $obj = mysql_fetch_object($resql);						
                                    if ($obj)
                                    {
                                        echo '<option value="'.$obj->num.'">'.$obj->login.'</option>';
                                        // You can use here results
                                        
                                    }	
                            $i++;
                        }
                    }
                }
            
            ?>
    </select>
</fieldset>
<?php
}
?>
<input type="hidden" name="rowid" id="rowid" value="<?php echo $result->irowid; ?>"/>
<input type="hidden" name="old_df" id="old_df" value="<?php echo $datefincorrect; ?>"/>
<input type="submit" value="Enregistrer" name="b_new_inter" class="form">
</form>
</body>