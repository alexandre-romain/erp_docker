<?php	

include("../config/common.php");
		// si une variable queryString a été posté
if(isset($_GET['statetask'])) 	
{
	$statetask = $_GET['statetask'];
	if ($statetask == '0') { //Si la tâche est définie à ouverte
		?>
        <label for="user_task" id="user_task_label">Intervenant T&acirc;che</label><br/>
        <select name="user_task" id="user_task">
                <?php
                $sql1 = "SELECT login, num";
                $sql1 .= " FROM ".$tblpref."user";
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
        <br/><br/>
        <label for="date_due_task" id="date_due_task_label">Date d'&eacute;cheance T&acirc;che</label><br/>
        <input type="text" size="9" id="date_due_task" name="date_due_task" value="<?php echo date('d-m-Y', strtotime("+ 1 day"));?>"> &aacute; <input type="text" id="hour_due_task" name="hour_due_task" size="1" value="<?php echo date('H');?>"/>:<input type="text" id="min_due_task" name="min_due_task" size="1" value="<?php echo date('i');?>"/>
        </fieldset>
        <?php
	}
	else { //Sinon tâche cloturée
		?>
        <!-- Si la tâche est cloturée, on permet a l'encodeur de définir le temps de travail-->
        <label for="time_spent_hours" id="time_spent_label">Temps de travail (HH:mm)</label><br/>
        <input type="text" size="4" id="time_spent_hours" name="time_spent_hours" value="00"> : <input type="text" size="4" id="time_spent_min" name="time_spent_min" value="00">
        </fieldset>
        <fieldset class="tache2">
        <legend>La 2ème T&acirc;che (facultatif)</legend>
        <label for="name_task2" id="name_task_label2">Description/Nom T&acirc;che</label><br/>
        <input type="text" size="25" id="name_task2" name="name_task2">
        <br/><br/>
        <label for="type_task2" id="type_task_label2">Type de T&acirc;che</label><br/>
        <select name="type_task2" id="type_task2">
			<?php
                $sql1 = "SELECT rowid, type";
                $sql1 .= " FROM ".$tblpref."type_task";
                $resql=mysql_query($sql1);
				while ($obj = mysql_fetch_object($resql))
				{					
						echo '<option value="'.$obj->rowid.'">'.$obj->type.'</option>';

				}
               ?>
        </select>
        <br/><br/>
        <label for="deplacement2">D&eacute;placement</label><br/>
        <select name="deplacement2" id="deplacement2">
              <option value="0" selected>Aucun</option>
              <option value="1">- 20km</option>
              <option value="2">20 - 40km</option>
              <option value="3">40+ km</option>
        </select>
        <br /><br />
        <label for="tarif_special2">Tarif Sp&eacute;cial</label><br/>
        <select name="tarif_special2" id="tarif_special2">
              <option value="1" selected>Non</option>
              <option value="2">19h+</option>
              <option value="3">Dimanche / F&eacute;ri&eacute; / 22h+</option>
              <option value="4">Tarif r&eacute;duit</option>
        </select>
        <br/><br/>
        <label for="state_task2" id="state_task_label2">&Eacute;tat de la T&acirc;che</label><br/>
        <select name="state_task2" id="state_task2" onKeyup="javascript:showmoretask2()" onChange="javascript:showmoretask2()" onFocus="javascript:showmoretask2()">
        <option value="0">Ouverte</option>
        <option value="1">Clotur&eacute;e</option>
        </select>
        <br/><br/>
        <div id="infotask2" style="display:block;"></div>
        <?php
	}
} 
else 	
{
	echo 'Il ne devrait pas avoir un accès direct à ce script !!!'.$new_exist;
}
?>