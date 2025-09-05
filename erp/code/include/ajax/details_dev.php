<?php
include("../config/common.php");
//On récupère l'id du devellopement
$num 		= addslashes($_REQUEST['num']);

$sql="SELECT num, intitule, etat";
$sql.=" FROM ".$tblpref."det_dev";
$sql.=" WHERE parent_dev='".$num."'";
$req=mysql_query($sql);
?>

<td colspan="5">
	<table width="100%" align="center" class="details_table">
    	<tr>
        	<th colspan="3" class="details_table_header" onclick="hide_dev(<?php echo $num;?>)">Détails du d&eacute;vellopement</th>
        </tr>
		<?php
		while ($obj=mysql_fetch_object($req)) {
		?>
        	<tr>
            	<td class="details_dev" style="width:82%;"><?php echo stripslashes($obj->intitule);?></td>
                <td class="details_dev" style="width:14%;">
                    	<select id="state_det_dev[<?php echo $obj->num;?>]">
                        	<option value="Waiting" <?php if($obj->etat == 'Waiting') {echo 'selected';}?>>Waiting</option>
                            <option value="Started" <?php if($obj->etat == 'Started') {echo 'selected';}?>>Started</option>
                            <option value="Testing" <?php if($obj->etat == 'Testing') {echo 'selected';}?>>Testing</option>
                            <option value="Debugging" <?php if($obj->etat == 'Debugging') {echo 'selected';}?>>Debugging</option>
                            <option value="Ended" <?php if($obj->etat == 'Ended') {echo 'selected';}?>>Ended</option>
                        </select>
                        <input type="hidden" value="<?php echo $obj->num;?>">
                        <input type="submit" class="submit" value="Modifier" onclick="edit_state_det_dev(<?php echo $obj->num;?>, <?php echo $num;?>)">
                </td>
                <td class="details_dev" style="width:6%;">
                	<button class="submit" onclick="del_det_dev(<?php echo $obj->num;?>, <?php echo $num;?>)">Supprimer</button>
                </td>
            </tr>
        <?php
		}
		?>
        <tr>
            <td class="details_dev" colspan="3">
                    <input type="text" name="nom_det[<?php echo $num;?>]" id="nom_det[<?php echo $num;?>]" size="200">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="hidden" value="<?php echo $num;?>" name="parent_dev[<?php echo $num;?>]" id="parent_dev[<?php echo $num;?>]">
                    <input type="submit" class="submit" onclick="add_detail(<?php echo $num;?>)" value="Ajouter">
            </td>
        </tr>
    </table>
</td>