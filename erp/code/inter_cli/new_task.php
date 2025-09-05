<?php
//Connexion BDD
include("../include/config/connexion.php");
//Récupération du header et du footer + variable déclarée dans ttes pages doli (à test)
include("../../main.inc.php");
require_once("./menu_task.php");
$res=0;
llxHeader('','Nouvelle Intervention','');
?>
<head>

<link href="../include/css/form.css" rel="stylesheet" media="all" type="text/css"> 
<!-- Datatables Editable plugin -->
<script type="text/javascript" src="../include/js/autocomplete.js"></script>
<script type="text/javascript" src="../include/js/datepicker.js"></script>        
</head>
<body>
<div class="form">Nouvelle T&acirc;che</div>

<form id="formAddNewRow" action="../include/ajax/FormAddTask.php" title="Ajouter une intervention" class="form">

<fieldset>
 <legend> L'intervention Parente </legend>
    <label for="search_inter"><i>Recherche Inter (3carac min.)</i></label>
    <input type="text" size="25" value="" id="search_inter" name="search_inter" onKeyUp="javascript:autosuggest('inter')" autocomplete="off" class="form"/><!--  champ texte à analyser pour les suggestions -->   
    <label for="fk_inter">Intervention</label>
    <select id="fk_inter" name ="fk_inter" rel="1" class="form" >
    </select>
</fieldset>

<fieldset>
 <legend> La t&acirc;che </legend>
    <label for="name">Nom de la t&acirc;che</label>
    <input type="text" size="25" name="name" id="name" class="required shortfield form" rel="0" autocomplete="off"/>
    <br /><br />
    <label for="date_debut">Date de début</label>
    <input type="text" size="25" name="date_debut" id="date_debut" class="required shortfield form" rel="2" autocomplete="off" value="<?php echo date("d-m-Y"); ?>"/>
    <br /><br />
    <label for="date_fin">Date de fin</label>
    <input type="text" size="25" name="date_fin" id="date_fin" class="required shortfield form" rel="3" autocomplete="off" value="<?php echo date("d-m-Y"); ?>"/>
    <br /><br />
    <label for="descr">Description</label>
    <textarea size="25" name="descr" id="descr" class="longfield form" autocomplete="off" rel="5"/>
    </textarea>
    <br /><br />
</fieldset>

<fieldset style="width:25px">
 <legend> Le(s) responsable(s) </legend>
    <label for="tech1" >Responsable(s) T&acirc;che</label>
    <select name="tech1" id="tech1" rel="4" class="form">
            <?php
            
            $sql1 = "SELECT login, rowid ";
            $sql1 .= " FROM ".MAIN_DB_PREFIX."user";
            $sql1 .= " WHERE rowid>1";
            //$sql1 .= " ORDER by p.rowid";
                
                $resql=$db->query($sql1);
                if ($resql)
                {
                    $num = $db->num_rows($resql);
                    $i = 0;
                    if ($num)
                    {
                        while ($i < $num)
                        {
                                    $obj = $db->fetch_object($resql);						
                                    if ($obj)
                                    {
                                        echo '<option value="'.$obj->rowid.'">'.$obj->login.'</option>';
                                        // You can use here results
                                        
                                    }	
                            $i++;
                        }
                    }
                }
            
            ?>
    </select>
    <select name="tech2" id="tech2" rel="4" class="form">
    		<option value=''></option>
            <?php
            
            $sql1 = "SELECT login, rowid ";
            $sql1 .= " FROM ".MAIN_DB_PREFIX."user";
            $sql1 .= " WHERE rowid>1";
            //$sql1 .= " ORDER by p.rowid";
                
                $resql=$db->query($sql1);
                if ($resql)
                {
                    $num = $db->num_rows($resql);
                    $i = 0;
                    if ($num)
                    {
                        while ($i < $num)
                        {
                                    $obj = $db->fetch_object($resql);						
                                    if ($obj)
                                    {
                                        echo '<option value="'.$obj->rowid.'">'.$obj->login.'</option>';
                                        // You can use here results
                                        
                                    }	
                            $i++;
                        }
                    }
                }
            
            ?>
    </select>
    <select name="tech3" id="tech3" rel="4" class="form">
    		<option value=''></option>
            <?php
            
            $sql1 = "SELECT login, rowid ";
            $sql1 .= " FROM ".MAIN_DB_PREFIX."user";
            $sql1 .= " WHERE rowid>1";
            //$sql1 .= " ORDER by p.rowid";
                
                $resql=$db->query($sql1);
                if ($resql)
                {
                    $num = $db->num_rows($resql);
                    $i = 0;
                    if ($num)
                    {
                        while ($i < $num)
                        {
                                    $obj = $db->fetch_object($resql);						
                                    if ($obj)
                                    {
                                        echo '<option value="'.$obj->rowid.'">'.$obj->login.'</option>';
                                        // You can use here results
                                        
                                    }	
                            $i++;
                        }
                    }
                }
            
            ?>
    </select>
</fieldset>

<input type="submit" value="Cr&eacute;er la t&acirc;che" name="b_new_inter" class="form">

</form>
</body>
<?php
//Footer
llxFooter();
$db->close();
?>