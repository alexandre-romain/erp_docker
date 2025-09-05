<?php	

include("../config/common.php");
		// si une variable queryString a été posté
if(isset($_GET['statetask'])) 	
{
	$statetask = $_GET['statetask'];
	if ($statetask == '0') { //Si la tâche est définie à ouverte
		?>
        <label for="user_task2" id="user_task_label2">Intervenant T&acirc;che</label><br/>
        <select name="user_task2" id="user_task2">
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
        <label for="date_due_task2" id="date_due_task_label2">Date d'&eacute;cheance T&acirc;che</label><br/>
        <input type="text" size="9" id="date_due_task2" name="date_due_task2" value="<?php echo date('d-m-Y', strtotime("+ 1 day"));?>"> &aacute; <input type="text" id="hour_due_task2" name="hour_due_task2" size="1" value="<?php echo date('H');?>"/>:<input type="text" id="min_due_task2" name="min_due_task2" size="1" value="<?php echo date('i');?>"/>
        </fieldset>
        <?php
	}
	else { //Sinon tâche cloturée
		?>
		        <!-- Si la tâche est cloturée, on permet a l'encodeur de définir le temps de travail-->
        <label for="time_spent2" id="time_spent_label2">Temps de travail (HH:mm)</label><br/>
        <input type="text" size="4" id="time_spent_hours2" name="time_spent_hours2" value="00"> : <input type="text" size="4" id="time_spent_min2" name="time_spent_min2" value="00">
        </fieldset>
        <?php
	}
} 
else 	
{
	echo 'Il ne devrait pas avoir un accès direct à ce script !!!'.$new_exist;
}
?>