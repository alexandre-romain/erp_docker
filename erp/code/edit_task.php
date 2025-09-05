<?php
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/".$lang.".php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");			
include_once("include/head.php");
//Récupération de l'ID inter
$rowid = addslashes($_REQUEST['rowid']);


//Requète de récupération des infos nécessaire pour populer le tableau d'inter
$sql = "SELECT it.rowid as itrowid, it.name as itname, it.time_spent as ittime_spent, it.date_debut as itdate_debut, it.date_fin as itdate_fin, it.completition as itcompletition, it.etat as itetat, it.fk_user1, it.fk_user2, it.fk_user3, it.fk_user4, it.fk_user5, i.nom as inom, i.nom as inom, i.rowid as irowid, it.descr as itdescr";
$sql .= " FROM ".$tblpref."inter_tache as it";
$sql .= " LEFT JOIN ".$tblpref."inter as i ON i.rowid=it.fk_inter";
$sql .= " WHERE it.rowid='$rowid'";
$reqsql= mysql_query($sql);
$result= mysql_fetch_object($reqsql);

//Récupération des 5rowid user
$id1=$result->fk_user1;
$id2=$result->fk_user2;
$id3=$result->fk_user3;
$id4=$result->fk_user4;
$id5=$result->fk_user5;
//Requêtes des logins
$sqllogin = "SELECT u.login as ulogin";
$sqllogin .=" FROM ".$tblpref."user as u";
$sqllogin .=" WHERE u.num='$id1'";
$querylogin= mysql_query($sqllogin);
$objlogin= mysql_fetch_object($querylogin);

$sqllogin2 = "SELECT u.login as ulogin";
$sqllogin2 .=" FROM ".$tblpref."user as u";
$sqllogin2 .=" WHERE u.num='$id2'";
$querylogin2= mysql_query($sqllogin2);
$objlogin2= mysql_fetch_object($querylogin2);

$sqllogin3 = "SELECT u.login as ulogin";
$sqllogin3 .=" FROM ".$tblpref."user as u";
$sqllogin3 .=" WHERE u.num='$id3'";
$querylogin3= mysql_query($sqllogin3);
$objlogin3= mysql_fetch_object($querylogin3);

$sqllogin4 = "SELECT u.login as ulogin";
$sqllogin4 .=" FROM ".$tblpref."user as u";
$sqllogin4 .=" WHERE u.num='$id4'";
$querylogin4= mysql_query($sqllogin4);
$objlogin4= mysql_fetch_object($querylogin4);

$sqllogin5 = "SELECT u.login as ulogin";
$sqllogin5 .=" FROM ".$tblpref."user as u";
$sqllogin5 .=" WHERE u.num='$id5'";
$querylogin5= mysql_query($sqllogin5);
$objlogin5= mysql_fetch_object($querylogin5);

//Convertion des dates en forme EU
$dateinter = explode ('-', $result->itdate_debut);
$annee = $dateinter[0];
$mois = $dateinter[1];
$jour = $dateinter[2];
$datedebutcorrect = $jour.'-'.$mois.'-'.$annee;

$dateinter = explode ('-', $result->itdate_fin);
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
<h4><span></span>Modifier Intervention</h4>

<form id="formAddNewRow" action="include/ajax/FormEditTask.php" title="Ajouter une intervention" class="form">

<fieldset>
 <legend> L'intervention Parente </legend>
    <label for="search_inter"><i>Recherche Inter (3carac min.)</i></label>
    <input type="text" size="25" value="<?php echo $result->inom; ?>" id="search_inter" name="search_inter" onKeyUp="javascript:autosuggest('inter')" autocomplete="off" class="form"/><!--  champ texte à analyser pour les suggestions -->   
    <label for="fk_inter">Intervention</label>
    <select id="fk_inter" name ="fk_inter" rel="1" class="form" >
    <option value="<?php echo $result->irowid ?>"><?php echo $result->inom ?></option>
    </select>
</fieldset>

<fieldset>
 <legend> La t&acirc;che </legend>
    <label for="name">Nom de la t&acirc;che</label>
    <input type="text" size="25" name="name" id="name" value="<?php echo $result->itname; ?>" class="required shortfield form" rel="0" autocomplete="off"/>
    <br /><br />
    <label for="date_debut">Date de début</label>
    <input type="text" size="25" name="date_debut" id="date_debut" value="<?php echo $datedebutcorrect; ?>" class="required shortfield form" rel="2" autocomplete="off" />
    <br /><br />
    <label for="date_fin">Date de fin</label>
    <input type="text" size="25" name="date_fin" id="date_fin" value="<?php echo $datefincorrect; ?>" class="required shortfield form" rel="3" autocomplete="off"/>
    <br /><br />
    <label for="descr">Description</label>
    <textarea size="25" name="descr" id="descr" class="longfield form" autocomplete="off" rel="5"/>
    <?php echo $result->itdescr; ?>
    </textarea>
    <br /><br />
</fieldset>

<fieldset>
 <legend> Le(s) responsable(s) </legend>
    <label for="tech1" >Responsable(s) T&acirc;che</label>
    <select name="tech1" id="tech1" rel="4" class="form">
    <option value="<?php echo $id1 ?>"><?php echo $objlogin->ulogin ?></option>
            <?php
            
            $sql1 = "SELECT login, num ";
            $sql1 .= " FROM ".tblpref."user";
            $sql1 .= " WHERE rowid!=$id1";
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
    <select name="tech2" id="tech2" rel="4" class="form">
    		<option value="<?php echo $id2 ?>"><?php echo $objlogin2->ulogin ?></option>
            <?php
            
            $sql1 = "SELECT login, num ";
            $sql1 .= " FROM ".tblpref."user";
            $sql1 .= " WHERE rowid!=$id2";
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
    <option value=""></option>
    </select>
    <select name="tech3" id="tech3" rel="4" class="form">
    		<option value="<?php echo $id3 ?>"><?php echo $objlogin3->ulogin ?></option>
            <?php
            
            $sql1 = "SELECT login, num ";
            $sql1 .= " FROM ".tblpref."user";
            $sql1 .= " WHERE rowid!=$id3";
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
    <option value=""></option>
    </select>
</fieldset>
<input type="hidden" value="<?php echo $rowid; ?>" id="rowid" name="rowid">
<input type="submit" value="Valider les modifications" name="b_new_inter" class="actionButton">

</form>
</body>
<?php
?>