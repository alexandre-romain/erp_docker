<?php
include("../config/common.php");

if(isset($_GET['rech'])) 	{
	$rech=$_GET['rech'];
}

if(strlen($rech) >3) {
	$sql ="SELECT a.num as num, a.article_name as article_name, c1.categorie as c1cat, c2.categorie as c2cat, c3.categorie as c3cat, a.marque as marque, a.article as article, a.reference as partnumber, a.stock as stock, a.prix_htva as pa, a.taux_tva as taux_tva, a.marge as marge, a.stomin as stomin"; 
	$sql.=" FROM ".$tblpref."article as a"; 
	$sql.=" LEFT JOIN ".$tblpref."categorie as c1 ON c1.id_cat=a.cat1";
	$sql.=" LEFT JOIN ".$tblpref."categorie as c2 ON c2.id_cat=a.cat2";
	$sql.=" LEFT JOIN ".$tblpref."categorie as c3 ON c3.id_cat=a.cat3";
	$sql.=" WHERE (a.article LIKE '%".$rech."%' OR a.reference LIKE '%".$rech."%' OR a.marque LIKE '%".$rech."%' OR a.article_name LIKE '%".$rech."%') AND a.actif != 'non' ORDER BY a.marque ASC, a.article ASC";
	$req=mysql_query($sql);
	?>

	<table class="base" align="center" width="100%" id="list">
    	<thead>
            <tr>
                <th></th>
                <th>Num.</th>
                <th>Top Cat.</th>
                <th>Middle Cat.</th>
                <th>Bottom Cat.</th>
                <th>Marque</th>
                <th>Article</th>
                <th>Nom affich&eacute;</th>
                <th>PartNumber</th>
                <th>Stock</th>
                <th>P.A.</th>
                <th>P.V. HT</th>
                <th>P.V. TTC</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
		<?php
        while ($obj=mysql_fetch_object($req)) {
            echo '<tr>';
                //Calcul du PV
                $one_percent=$obj->pa/100;
                $marge=$one_percent*$obj->marge;
                $pv_inter=$obj->pa+$marge;
                $tva_inter=$pv_inter/100;
                $tva=$tva_inter*$obj->taux_tva;
                $pv=$pv_inter+$tva;
                $pv=number_format($pv, 2, ',', ' ');
                /*echo '<td><div id="details" name="details" style="width:20px;height:20px;background:url(include/img/plus.png)" onclick="show_det_article('.$obj->num.')"></div></td>';*/
                echo '<td></td>';
				echo '<td>'.$obj->num.'</td>';
                echo '<td>'.$obj->c1cat.'</td>';
                echo '<td>'.$obj->c2cat.'</td>';
                echo '<td>'.$obj->c3cat.'</td>';
                echo '<td>'.$obj->marque.'</td>';
                echo '<td>'.$obj->article.'</td>';
                echo '<td class="edit_name" id="'.$obj->num.'">'.$obj->article_name.'</td>';
                echo '<td>'.$obj->partnumber.'</td>';
                if ($obj->stock < $obj->stomin) {
                    echo '<td><span style="color:#f44d40">'.$obj->stock.'</span></td>';
                }
                else if ($obj->stock > 0.00) {
                            echo '<td><span style="color:#419e21">'.$obj->stock.'</span></td>';
                }
                else {
                    echo '<td>'.$obj->stock.'</td>';
                }
                echo '<td>'.$obj->pa.'&euro;</td>';
                echo '<td>'.$pv_inter.'&euro;</td>';
                echo '<td>'.$pv.'&euro;</td>';
                echo '<td><a href="./include/ajax/delete_article.php?num='.$obj->num.'"> <button class="icons fa-trash fa-3x fa-fw del" title="Supprimer l\'article"></button></a></td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
<?php
}
?>