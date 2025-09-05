<?php
include("../config/common.php");
include("../fonctions.php");
$nbr=$_REQUEST['nbr'];
?>
<tr id="line<?php echo $nbr;?>">
    <td><input type="text" class="styled" name="task[<?php echo $nbr;?>][nom]" style="width:100%"></td>
    <td>
        <div class="styled-select-inline" style="width:100%">
        <select class="styled-inline" name="task[<?php echo $nbr;?>][type]">
            <?php
            $sql1 = "SELECT rowid, type";
            $sql1 .= " FROM ".$tblpref."type_task";
            $resql=mysql_query($sql1);
            while ($obj = mysql_fetch_object($resql))
            {					
                    echo '<option value="'.$obj->rowid.'">'.utf8_encode($obj->type).'</option>';
            
            }
            ?>
        </select>
        </div>
    </td>
    <td>
        <div class="styled-select-inline" style="width:100%">
        <select name="task[<?php echo $nbr;?>][deplacement]" class="styled-inline">
          <option value="0" selected>Aucun</option>
          <option value="1">- 20km</option>
          <option value="2">20 - 40km</option>
          <option value="3">40+ km</option>
          <option value="4">Foyer Namurois</option>
        </select>
        </div>
    </td>
    <td>
        <div class="styled-select-inline" style="width:100%">
        <select name="task[<?php echo $nbr;?>][tarif]" class="styled-inline">
          <option value="1" selected>Non</option>
          <option value="2">19h+</option>
          <option value="3">Dimanche / F&eacute;ri&eacute; / 22h+</option>
          <option value="4">Tarif r&eacute;duit</option>
          <option value="5">Foyer Namurois</option>
        </select>
        </div>
    </td>
    <td>
        <div class="styled-select-inline" style="width:100%">
        <select name="task[<?php echo $nbr;?>][user]" class="styled-inline">
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
        </div>
    </td>
    <td>
        <input type="text" size="9" id="" name="task[<?php echo $nbr;?>][date_due]" value="<?php echo date('d-m-Y', strtotime("+ 1 day"));?>" class="styled datepicker" style="width:50%"> 
        &agrave; <input type="text" id="" name="task[<?php echo $nbr;?>][heure_due]" size="1" value="<?php echo date('H');?>" class="styled" style="width:15%"/>
        &nbsp;:  <input type="text" id="" name="task[<?php echo $nbr;?>][min_due]" size="1" value="<?php echo date('i');?>" class="styled" style="width:15%"/>
    </td>
    <td><input type="checkbox" name="task[<?php echo $nbr;?>][fin]" value="end" id="task_terminate_<?php echo $nbr;?>" onchange="check_end(<?php echo $nbr;?>)"></td>
    <td id="time<?php echo $nbr;?>"></td>
    <td><i class="fa fa-minus-circle fa-fw fa-2x del" onclick="del_line_task(<?php echo $nbr;?>)"></td>
</tr>