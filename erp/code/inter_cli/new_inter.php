<?php 
require_once("../include/verif.php");
include_once("../include/config/common.php");
include_once("../include/language/".$lang.".php");
include_once("../include/utils.php");
include_once("../include/headers.php");?>
<?php
include_once("../include/finhead.php");			
include_once("../include/head.php");
?>





		<style type="text/css" media="screen">
			@import "../include/css/demo_table_jui.css";
			@import "../include/css/jquery-ui-1.7.2.custom.css";	
			@import "../include/css/form.css";
		</style> 
    <!-- Datatables Editable plugin -->
    	<script type="text/javascript" src="../include/js/autocomplete.js"></script>
    	<script type="text/javascript" src="../include/js/jquery-1.10.0.js"></script>
		<script type="text/javascript" src="../include/js/jquery-1.4.4.min.js"></script>
        <script type="text/javascript" src="../include/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="../include/js/jquery.dataTables.editable.js"></script>
		<script type="text/javascript" src="../include/js/jquery.jeditable.js"></script>
        <script type="text/javascript" src="../include/js/jquery-ui.js"></script>
        <script type="text/javascript" src="../include/js/jquery.validate.js"></script>
		<script type="text/javascript" src="../include/js/datepicker.js"></script>      

<div class="form">Nouvelle Intervention</div>

<form id="formAddNewRow" action="../include/ajax/AddInter.php" title="Ajouter une intervention" class="form">

<fieldset>
 <legend> Le client </legend>
    <label for="search_soc"><i>Recherche Client (3carac min.)</i></label>
    <input type="text" size="25" value="" id="search_soc" name="search_soc" onKeyUp="javascript:autosuggest('asoc')" autocomplete="off" class="form"/><!--  champ texte à analyser pour les suggestions -->   
    <label for="soc">Client</label>
    <select id="soc" name ="soc" class="form" >
    </select>
</fieldset>

<fieldset>
 <legend> L'intervention </legend>
    <label for="name">Nom de l'intervention</label>
    <input type="text" size="25" name="name" id="name" class="required shortfield form" autocomplete="off"/>
    <br /><br />
    <label for="date_debut">Date de d&eacute;but</label>
    <input type="text" size="25" name="date_debut" id="date_debut" class="required shortfield form" autocomplete="off" value="<?php echo date("d-m-Y"); ?>"/>
    <br /><br />
    <label for="date_fin">Date de fin</label>
    <input type="text" size="25" name="date_fin" id="date_fin" class="required shortfield form" autocomplete="off" value="<?php echo date("d-m-Y"); ?>"/>
    <br /><br />
    <label for="descr">Description</label>
    <textarea size="25" name="descr" id="descr" class="longfield form" autocomplete="off" />
    </textarea>
    <br /><br />
</fieldset>

<fieldset>
 <legend> Le responsable </legend>
    <label for="user" >Responsable Inter</label>
    <select name="user" id="user" class="form">
            <?php
            
            $sql1 = "SELECT login, num";
            $sql1 .= " FROM ".$tblpref."user";
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

<input type="submit" value="Cr&eacute;er l'intervention" name="b_new_inter" class="form">

</form>