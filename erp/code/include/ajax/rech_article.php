<?php
include("../config/common.php");

$rech=$_REQUEST['rech'];

if (strlen($rech) > 3) {

	$sql="SELECT * FROM ".$tblpref."article WHERE article LIKE '%".$rech."%' OR reference LIKE '%".$rech."%' OR marque LIKE '%".$rech."%' OR article_name LIKE '%".$rech."%' ORDER by marque ASC, article ASC";
	$req=mysql_query($sql);
	while ($obj = mysql_fetch_object($req)) {
		if($obj->article_name != '' && $obj->article_name != NULL) {
			$article=$obj->article_name;
		}
		else {
			$article=$obj->article;
		}
		?>
		<option value="<?php echo $obj->num;?>"><?php echo $obj->marque.' - '.$article.' | PN: '.$obj->reference;?></option>
		<?php
	}
}
?>