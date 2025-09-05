<?php
include_once("../config/common.php");
//On récupères les valeurs
$qty = $_REQUEST['qty'] ;
$num = $_REQUEST['num'] ;
$art_id = $_REQUEST['art_id'] ;

$i=1

?>
<form action="./include/ajax/add_serials.php" method="post">
<table>
<?php
while ($qty >= $i) {
	?>
    <tr>
    	<td>Entrez le serial n° <?php echo $i;?></td>
		<td><input type="text" name="serial[]" style="border:1px solid black"></td>
    </tr>
	<?php
	$i++;
}
?>
<input type="hidden" value="<?php echo $qty;?>" name="qty">
<input type="hidden" value="<?php echo $art_id;?>" name="art_id">
	<tr>
    	<td><input type="submit" class="submit" value="Ajouter les Serials"></td>
    </tr>
</table>
</form>