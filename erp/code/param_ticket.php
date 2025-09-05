<?php 
require_once("include/verif.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");			
include_once("include/head.php");
$user = $_SERVER[PHP_AUTH_USER]; //login dans cette variable
//On inclus le footer apres la récupération de la variable $user; pour pouvoir la récupérer
include_once("include/elements/footer.php");
//Récupération de l'utilisiteur accédant à la page
$sql_user=" SELECT num";
$sql_user.=" FROM ".$tblpref."user";
$sql_user.=" WHERE login='".$user."'";
$req_user=mysql_query($sql_user);
$results_user=mysql_fetch_object($req_user);
$num_user=$results_user->num;
?>
<head>

<style type="text/css" media="screen">
	@import "include/css/param_ticket.css";

</style>

<script type="text/javascript" src="include/js/datepicker.js"></script>

<body>
<br/>
<table class="type_task">
<tr>
<th colspan=2 class="title">Types de t&acirc;ches existants</th>
</tr>
<tr>
<th class="num subth">Num.</th><th class="subth">Intitul&eacute;</th>
</tr>
<?php
$sql="SELECT rowid, type";
$sql.=" FROM ".$tblpref."type_task";
$req = mysql_query($sql);

while ($results=mysql_fetch_object($req)) {
	echo '<tr>';
	echo '<td class="num">'.$results->rowid.'</td>';
	echo '<td>'.$results->type.'<a href="./include/ajax/Delete_Type_Task.php?rowid='.$results->rowid.'"><span class="delete"></span></a></td>';
	echo '</tr>';
}
?>
<tr>
<td class="num">#</td><td>
<form class="add_type" action="./include/ajax/Add_Type_Task.php" method="post">
<input type="text" id="nom" name="nom">
<span class="add"><input type="submit" value="Ajouter"></span>
</form>
</td>
</tr>
</table>
</body>

