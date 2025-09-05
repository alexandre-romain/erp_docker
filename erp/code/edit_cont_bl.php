<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
function confirmDelete()
{
	var agree=confirm("<?php echo $lang_sup_li; ?>");
	if (agree)
	 	return true ;
	else
	 	return false ;
}
<!-- DT LISTE COMMANDES -->
$(document).ready(function() {
    $('#already_add').DataTable( {
		"language": {
			"lengthMenu": 'Afficher <div class="styled-select-dt"><select class="styled-dt">'+
						'<option value="10">10</option>'+
						'<option value="20">20</option>'+
						'<option value="30">30</option>'+
						'<option value="40">40</option>'+
						'<option value="50">50</option>'+
						'<option value="100">100</option>'+
						'<option value="-1">All</option>'+
						'</select></div> lignes'
		},
		"pageLength" : 20,
		"order": [[0, 'desc']],
  	});
});
$(document).ready(function() {
	$( "#show_edit" ).hide();
	$( "#show_edit" ).click(function() {
		$( "#edit" ).show(500);
		$( "#show_edit" ).hide();
		$( "#hide_edit" ).show();
	});
	$( "#hide_edit" ).click(function() {
		$( "#edit" ).hide(500);
		$( "#show_edit" ).show();
		$( "#hide_edit" ).hide();
	});
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
$num_cont=isset($_GET['num_cont'])?$_GET['num_cont']:""; //doit être le n° de la ligne du bl ..
$sql = "SELECT * FROM " . $tblpref ."cont_bl  RIGHT JOIN " . $tblpref ."article on " . $tblpref ."cont_bl.article_num = " . $tblpref ."article.num WHERE  " . $tblpref ."cont_bl.num = $num_cont";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
{
  $quanti = $data['quanti'];
  $article = $data['article'];
  $tot = $data['tot_art_htva'];
  $num_art = $data['num'];
  $article_num = $data['article_num'];
  $bl_num = $data['bl_num'];
  $prix_ht = $data['p_u_jour'];
}
?>
<!--MODIFIER-->
<div class="portion">
    <!-- TITRE - MODIFIER -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pencil fa-stack-1x"></i>
        </span>
        Modifier le contenu d'un BL
        <span class="fa-stack fa-lg add" style="float:right" id="show_edit">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_edit">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - MODIFIER -->
    <div class="content_traitement" id="edit">
        <form name="formu2" method="post" action="suite_edit_cont_bl.php">
        <table class="base" width="100%">
            <tr> 
                <td class="right" width="30%"><?php echo $lang_article ;?> :</td>
                <td class="left" width="70%"> 
                    <?php
                    $rqSql = "SELECT num, article, uni, prix_htva, marque FROM " . $tblpref ."article WHERE num = ".$article_num."";
                    $result = mysql_query( $rqSql ) or die( "Exécution requête impossible.");
                    ?>
                    <div class="styled-select-inline" style="width:40%">
                    <SELECT NAME='article' class="styled-inline">
                        <?php
                        while ( $row = mysql_fetch_array( $result)) {
                            $num = $row["num"];
                            $uni = $row['uni'];
                            $article2 = $row["article"];
                            $marque = $row['marque'];
                            $prix = $row["prix_htva"];
                            ?>
                            <OPTION VALUE=<?php echo "$num" ?> <?php if ($num == $article_num) { ?>selected<?php }?> > <?php echo $marque." ".$article2." ".$prix." euros"; ?></OPTION>
                        <?
                        }
                        ?>
                    </SELECT> 
                    </div>
                </td>
            </tr>
            <tr> 
                <td class="right" ><?php echo $lang_quanti ?> :</td>
                <td class="left"><input name="quanti" type="text" size="5" id="quanti" value='<?php echo $quanti; ?>' class="styled"> / <? echo $uni; ?></td>
            </tr>
            <tr> 
                <td class="right" >PV (HTVA) :</td>
                <td class="left"><input name="PV" type="text" id="PV" value="<? echo $prix_ht; ?>" size="5" readonly="readonly" class="styled"> &euro; </td>
            </tr>
            <tr>
                <td class="right" >Serial(s) :</td>
                <td class="left">
                    <?
                    // onlibère les serial qui auraient deja été liés à cette ligne de bl ...
                    $sql0 = "UPDATE `" . $tblpref ."stock` SET `status` = '', `bl_cont_sortie` = '' WHERE `bl_cont_sortie` = '$num_cont'";
                    mysql_query($sql0) or die('Erreur SQL11 !<br>'.$sql0.'<br>'.mysql_error());
                    // on affiche les 30 select pour choix serials. 30 Etant la limite d'article / ligne de document.			
                    $rqSql2 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                    $result2 = mysql_query( $rqSql2 ) or die( "Exécution requête impossible.");
                    ?>
                    <div class="styled-select-inline" style="width:40%">			
                    <SELECT NAME='serial1' class="styled-inline">
                        <option value="aucun" selected>aucun</option>
                        <?php
                        while ( $row2 = mysql_fetch_array( $result2)) {
                            $serial = $row2["serial"];
                            ?>
                            <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                        <?
                        }
                        ?>
                    </SELECT>
                    </div>				
                    <? 
                    if ($quanti >= '2') { 						
                        $rqSql3 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result3 = mysql_query( $rqSql3 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial2' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row3 = mysql_fetch_array( $result3)) {
                                $serial = $row3["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>			
            
                    <? 
                    } 
                    if ($quanti >= '3') { 						
                        $rqSql4 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result4 = mysql_query( $rqSql4 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial3' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row4 = mysql_fetch_array( $result4)) {
                                $serial = $row4["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>			
            
                    <? 
                    } 
                    if ($quanti >= '4') { 						
                        $rqSql5 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result5 = mysql_query( $rqSql5 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial4' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row5 = mysql_fetch_array( $result5)) {
                                $serial = $row5["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>			
            
                    <? 
                    } 
                    if ($quanti >= '5') { 						
                        $rqSql6 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result6 = mysql_query( $rqSql6 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial5' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row6 = mysql_fetch_array( $result6)) {
                                $serial = $row6["serial"];
                            ?>
                            <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>			
            
                    <? 
                    } 
                    if ($quanti >= '6') { 					
                        $rqSql7 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result7 = mysql_query( $rqSql7 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial6' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                                while ( $row7 = mysql_fetch_array( $result7)) {
                                $serial = $row7["serial"];
                            ?>
                            <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>				
                    <? 
                    } 
                    if ($quanti >= '7') { 						
                        $rqSql8 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result8 = mysql_query( $rqSql8 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial7' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row8 = mysql_fetch_array( $result8)) {
                                $serial = $row8["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>				
                    <? 
                    } 
                    if ($quanti >= '8') { 						
                        $rqSql9 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result9 = mysql_query( $rqSql9 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial8' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row9 = mysql_fetch_array( $result9)) {
                            $serial = $row9["serial"];
                            ?>
                            <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>			
                    <? 
                    } 
                    if ($quanti >= '9') { 			
                        $rqSql10 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result10 = mysql_query( $rqSql10 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial9' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row10 = mysql_fetch_array( $result10)) {
                                $serial = $row10["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>			
                    <? 
                    } 
                    if ($quanti >= '10') { 					
                        $rqSql11 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result11 = mysql_query( $rqSql11 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial10' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row11 = mysql_fetch_array( $result11)) {
                                $serial = $row11["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>			
                    <? 
                    }  
                    if ($quanti >= '11') { 			
                        $rqSql12 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result12 = mysql_query( $rqSql12 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial11' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row12 = mysql_fetch_array( $result12)) {
                                $serial = $row12["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                                <?
                            }
                            ?>
                        </SELECT>
                        </div>				
                    <? 
                    }  
                    if ($quanti >= '12') { 					
                        $rqSql13 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result13 = mysql_query( $rqSql13 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial12' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row13 = mysql_fetch_array( $result13)) {
                                $serial = $row13["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                                <?
                            }
                            ?>
                        </SELECT>
                        </div>			
                    <? 
                    }  
                    if ($quanti >= '13') { 			
                        $rqSql14 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result14 = mysql_query( $rqSql14 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial13' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row14 = mysql_fetch_array( $result14)) {
                                $serial = $row14["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>			
                    <? 
                    }  
                    if ($quanti >= '14') { 			
                        $rqSql15 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result15 = mysql_query( $rqSql15 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial14' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row15 = mysql_fetch_array( $result15)) {
                                $serial = $row15["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>			
                    <? 
                    } 
                    if ($quanti >= '15') { 			
                        $rqSql16 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result16 = mysql_query( $rqSql16 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial15' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row16 = mysql_fetch_array( $result16)) {
                                $serial = $row16["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>			
                    <? 
                    } 
                    if ($quanti >= '16') { 			
                        $rqSql17 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result17 = mysql_query( $rqSql17 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial16' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row17 = mysql_fetch_array( $result17)) {
                                $serial = $row17["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>			
                    <? 
                    } 
                    if ($quanti >= '17') { 			
                        $rqSql18 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result18 = mysql_query( $rqSql18 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial17' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row18 = mysql_fetch_array( $result18)) {
                                $serial = $row18["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>			
                    <? 
                    }
                    if ($quanti >= '18') { 						
                        $rqSql19 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result19 = mysql_query( $rqSql19 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial18' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row19 = mysql_fetch_array( $result19)) {
                                $serial = $row19["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>				
                    <? 
                    }
                    if ($quanti >= '19') { 						
                        $rqSql20 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result20 = mysql_query( $rqSql20 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial19' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row20 = mysql_fetch_array( $result20)) {
                                $serial = $row20["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>				
                    <? 
                    } 
                    if ($quanti >= '20') { 					
                        $rqSql21 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result21 = mysql_query( $rqSql21 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial20' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row21 = mysql_fetch_array( $result21)) {
                                $serial = $row21["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>			
                    <? 
                    }
                    if ($quanti >= '21') { 						
                        $rqSql22 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result22 = mysql_query( $rqSql22 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial21' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row22 = mysql_fetch_array( $result22)) {
                                $serial = $row22["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>				
                    <? 
                    }
                    if ($quanti >= '22') { 					
                        $rqSql23 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result23 = mysql_query( $rqSql23 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial22' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row23 = mysql_fetch_array( $result23)) {
                                $serial = $row23["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>				
                    <? 
                    }
                    if ($quanti >= '23') { 						
                        $rqSql24 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result24 = mysql_query( $rqSql24 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial23' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row24 = mysql_fetch_array( $result24)) {
                                $serial = $row24["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>			
                    <? 
                    }
                    if ($quanti >= '24') { 						
                        $rqSql25 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result25 = mysql_query( $rqSql25 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial24' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row25 = mysql_fetch_array( $result25)) {
                                $serial = $row25["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>			
                    <? 
                    }
                    if ($quanti >= '25') { 						
                        $rqSql26 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result26 = mysql_query( $rqSql26 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial25' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row26 = mysql_fetch_array( $result26)) {
                                $serial = $row26["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>			
                    <? 
                    }
                    if ($quanti >= '26') { 					
                        $rqSql27 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result27 = mysql_query( $rqSql27 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial26' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row27 = mysql_fetch_array( $result27)) {
                                $serial = $row27["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>			
                    <? 
                    }
                    if ($quanti >= '27') { 			
                        $rqSql28 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result28 = mysql_query( $rqSql28 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial27' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row28 = mysql_fetch_array( $result28)) {
                                $serial = $row28["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>			
                    <? 
                    } 
                    if ($quanti >= '28') { 			
                        $rqSql29 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result29 = mysql_query( $rqSql29 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial28' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row29 = mysql_fetch_array( $result29)) {
                                $serial = $row29["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>				
                    <? 
                    }
                    if ($quanti >= '29') { 			
                        $rqSql30 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result30 = mysql_query( $rqSql30 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial29' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row30 = mysql_fetch_array( $result30)) {
                                $serial = $row30["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>
                        </div>			
                    <? 
                    } 
                    if ($quanti >= '30') { 						
                        $rqSql31 = "SELECT serial FROM " . $tblpref ."stock WHERE article = $article_num AND status != 'out'";
                        $result31 = mysql_query( $rqSql31 ) or die( "Exécution requête impossible.");			
                        ?>			
                        <br/><br/>
                        <div class="styled-select-inline" style="width:40%">
                        <SELECT NAME='serial30' class="styled-inline">
                            <option value="aucun" selected>aucun</option>
                            <?php
                            while ( $row31 = mysql_fetch_array( $result31)) {
                                $serial = $row31["serial"];
                                ?>
                                <OPTION VALUE=<?php echo $serial ?>><?php echo $serial; ?></OPTION>
                            <?
                            }
                            ?>
                        </SELECT>	
                        </div>		
                    <? 
                    } 
                    ?>
                </td>
            </tr> 
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-pencil"></i><span><?php echo $lang_modifier ?></span></button>
        </div>
        <input name="num_cont" type="hidden" id="nom" value=<?php echo $num_cont ?>>
        <input name="bl_num" type="hidden" id="nom" value=<?php echo $bl_num ?>>
        </form>
	</div> 
</div>
<?php
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
