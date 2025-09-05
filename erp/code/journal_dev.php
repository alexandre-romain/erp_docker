<html>
<head>
<?php 
require_once("include/verif.php");
include_once("include/language/$lang.php");
include_once("include/headers.php");
include_once("include/finhead.php");			
include_once("include/head.php");
$user = $_SERVER[PHP_AUTH_USER]; //login dans cette variable
//On inclus le footer apres la récupération de la variable $user; pour pouvoir la récupérer
include_once("include/elements/footer.php");
?>
<script type="text/javascript" src="./include/js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="./include/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="./include/js/jquery-ui.js"></script>
<script type="text/javascript" src="./include/js/jquery.validate.js"></script>
<script type="text/javascript" src="./include/js/journal_dev.js"></script>
</head>
<body>
<br/>
<form action="./include/ajax/add_dev.php" method="post">
<table class="main_table" align="center" width="20%">
	<tr>
	    <td class="main_table_header" colspan="2">Ajouter un Dev'</td>
    </tr>
    <tr>
    	<td class="main_table">Nom</td>
    	<td class="main_table"><input type="text" size="45em" name="nom" id="nom"></td>	
	</tr>
    <tr>
    	<td class="main_table">Client</td>
    	<td class="main_table"><?php include_once("include/choix_cli.php"); ?></td>	
	</tr>
    <tr>
    	<td class="main_table" colspan="2"><input type="submit" class="submit"></td>	
	</tr>
</table>
</form>
<br/>
<table class="main_table" align="center" width="80%">
	<tr>
    	<td class="main_table_header" colspan="10">Running Devs'</td>
    </tr>
    <tr>
        <th class="subtitle" style="width:5%">Det.</th>
        <th class="subtitle" style="width:35%">Nom</th>
        <th class="subtitle" style="width:15%">Date de cr&eacute;ation</th>
        <th class="subtitle" style="width:30%">Client</th>
        <th class="subtitle" style="width:15%">Etat</th>
    </tr>
    <?php
	$sql="Select d.nom as dnom, d.date_c as date_c, c.nom as cli, d.etat as state, d.num as dnum";
	$sql.=" FROM ".$tblpref."dev as d";
	$sql.=" LEFT JOIN ".$tblpref."client as c ON c.num_client = d.client";
	$sql.=" WHERE d.etat=1";
	$req=mysql_query($sql);
	while ($obj=mysql_fetch_object($req)) {
		$state=$obj->state;
		?>
		<tr>
			<td class="main_table"><center><div id="plus" name="plus" style="width:20px;height:20px;background:url(include/img/plus.png);" onclick="showdet_dev(<?php echo $obj->dnum;?>)"></div></center></td>
			<td class="main_table"><?php echo $obj->dnom; ?></td>
			<td class="main_table"><?php echo $obj->date_c; ?></td>
			<td class="main_table"><?php echo $obj->cli; ?></td>
			<td class="main_table">
            	<form action="./include/ajax/Update_dev.php" method="post">
                	<select id="state" name="state">
                    	<option value="1" <?php if ($state = 1) {echo 'selected';} ?>>Runnin'</option>
                        <option value="0" <?php if ($state = 0) {echo 'selected';} ?>>End</option>
                   	</select>
                    &nbsp;
                    <input type="hidden" value="<?php echo $obj->dnum;?>" name="num" id="num">
                    <input type="submit" class="submit" value="Valider">
              	</form>
            </td>
		</tr>
        <tr id="det_dev[<?php echo $obj->dnum;?>]">        	
        </tr>
    <?php
	}
	?>
</table>
<br/>
<table class="main_table" align="center" width="80%">
	<tr>
    	<td class="main_table_header" colspan="6">Ended Devs'</td>
    </tr>
    <tr>
        <th class="subtitle" style="width:5%">Det.</th>
        <th class="subtitle" style="width:35%">Nom</th>
        <th class="subtitle" style="width:15%">Date de cr&eacute;ation</th>
        <th class="subtitle" style="width:30%">Client</th>
        <th class="subtitle" style="width:15%">Etat</th>
    </tr>
    <?php
	$sql="Select d.nom as dnom, d.date_c as date_c, c.nom as cli, d.etat as state, d.num as dnum";
	$sql.=" FROM ".$tblpref."dev as d";
	$sql.=" LEFT JOIN ".$tblpref."client as c ON c.num_client = d.client";
	$sql.=" WHERE d.etat=0";
	$req=mysql_query($sql);
	$number=mysql_num_rows($req);
	if ($number > 0) {
		while ($obj=mysql_fetch_object($req)) {
			$state=$obj->state;
			?>
			<tr>
				<td class="main_table"><center><div id="plus" name="plus" style="width:20px;height:20px;background:url(include/img/plus.png);" onclick="showdet_dev(<?php echo $obj->dnum;?>)"></div></center></td>
				<td class="main_table"><?php echo $obj->dnom; ?></td>
				<td class="main_table"><?php echo $obj->date_c; ?></td>
				<td class="main_table"><?php echo $obj->cli; ?></td>
				<td class="main_table">
					<form action="./include/ajax/Update_dev.php" method="post">
                	<select id="state" name="state">
                    	<option value="1" <?php if ($state = 1) {echo 'selected';} ?>>Runnin'</option>
                        <option value="0" <?php if ($state = 0) {echo 'selected';} ?>>End</option>
                   	</select>
                    &nbsp;
                    <input type="hidden" value="<?php echo $obj->dnum;?>" name="num" id="num">
                    <input type="submit" class="submit" value="Valider">
              	</form>
				</td>
			</tr>
            </tr>
            <tr id="det_dev[<?php echo $obj->dnum;?>]">        	
            </tr>
		<?php
		}
	}
	else {
	?>
    	<tr>
        	<td class="main_table" colspan="6">No entry to show</td>
        </tr>
    <?php
	}
	?>
</table>
</body>
</html>