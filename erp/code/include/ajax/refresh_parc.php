<?php
include("../config/common.php");
include("../fonctions.php");
//On récupère l'id du parc
$id_parc=$_REQUEST['id'];
//On récupère les informations du parc
$sql="SELECT * FROM ".$tblpref."parcs as p LEFT JOIN ".$tblpref."client as c ON p.cli=c.num_client WHERE id=".$id_parc."";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
?>
<!-- DETAILS COMPOSANTES PARC -->
<!-- SERVER -->
<div class="container_composante" style="margin-left:15%">
    <div class="part_parc">
        <i class="fa fa-server fa-fw"></i> <?php echo $obj->nbr_server;?>
    </div>
    <div class="btn_plus" onclick="add_compos('server', <?php echo $id_parc;?>)"><i class="fa fa-plus fa-2x"></i></div>
    <div class="btn_moins" onclick="sub_compos('server', <?php echo $id_parc;?>)"><i class="fa fa-minus fa-2x"></i></div>
    <div class="set_comp_manual">
        <form action="./include/form/update_compos_parc.php" method="post" class="autosubmit">
            <input type="text" class="styled" style="vertical-align:bottom;" name="nbr"/>
            <button class="icons fa-check fa-2x add" style=""></button>
            <input type="hidden" name="type" value="server"/>
            <input type="hidden" name="id_parc" value="<?php echo $id_parc;?>"/>
        </form>
    </div>
</div>
<!-- FIXES -->
<div class="container_composante">
    <div class="part_parc">
        <i class="fa fa-desktop fa-fw"></i> <?php echo $obj->nbr_pc;?>
    </div>
    <div class="btn_plus" onclick="add_compos('pc', <?php echo $id_parc;?>)"><i class="fa fa-plus fa-2x"></i></div>
    <div class="btn_moins" onclick="sub_compos('pc', <?php echo $id_parc;?>)"><i class="fa fa-minus fa-2x"></i></div>
    <div class="set_comp_manual">
        <form action="./include/form/update_compos_parc.php" method="post" class="autosubmit">
            <input type="text" class="styled" style="vertical-align:bottom;" name="nbr"/>
            <button class="icons fa-check fa-2x add" style=""></button>
            <input type="hidden" name="type" value="pc"/>
            <input type="hidden" name="id_parc" value="<?php echo $id_parc;?>"/>
        </form>
    </div>
</div>
<!-- LAPTOP -->
<div class="container_composante">
    <div class="part_parc">
        <i class="fa fa-laptop fa-fw"></i> <?php echo $obj->nbr_laptop;?>
    </div>
    <div class="btn_plus" onclick="add_compos('laptop', <?php echo $id_parc;?>)"><i class="fa fa-plus fa-2x"></i></div>
    <div class="btn_moins" onclick="sub_compos('laptop', <?php echo $id_parc;?>)"><i class="fa fa-minus fa-2x"></i></div>
    <div class="set_comp_manual">
        <form action="./include/form/update_compos_parc.php" method="post" class="autosubmit">
            <input type="text" class="styled" style="vertical-align:bottom;" name="nbr"/>
            <button class="icons fa-check fa-2x add" style=""></button>
            <input type="hidden" name="type" value="laptop"/>
            <input type="hidden" name="id_parc" value="<?php echo $id_parc;?>"/>
        </form>
    </div>
</div>
<!-- MOBILE -->
<div class="container_composante">
    <div class="part_parc">
        <i class="fa fa-mobile fa-fw"></i> <?php echo $obj->nbr_mobile;?>
    </div>
    <div class="btn_plus" onclick="add_compos('mobile', <?php echo $id_parc;?>)"><i class="fa fa-plus fa-2x"></i></div>
    <div class="btn_moins" onclick="sub_compos('mobile', <?php echo $id_parc;?>)"><i class="fa fa-minus fa-2x"></i></div>
    <div class="set_comp_manual">
        <form action="./include/form/update_compos_parc.php" method="post" class="autosubmit">
            <input type="text" class="styled" style="vertical-align:bottom;" name="nbr"/>
            <button class="icons fa-check fa-2x add" style=""></button>
            <input type="hidden" name="type" value="mobile"/>
            <input type="hidden" name="id_parc" value="<?php echo $id_parc;?>"/>
        </form>
    </div>
</div>
<!-- PRINTER -->
<div class="container_composante">
    <div class="part_parc">
        <i class="fa fa-print fa-fw"></i>  <?php echo $obj->nbr_printer;?>
    </div>
    <div class="btn_plus" onclick="add_compos('printer', <?php echo $id_parc;?>)"><i class="fa fa-plus fa-2x"></i></div>
    <div class="btn_moins" onclick="sub_compos('printer', <?php echo $id_parc;?>)"><i class="fa fa-minus fa-2x"></i></div>
    <div class="set_comp_manual">
        <form action="./include/form/update_compos_parc.php" method="post" class="autosubmit">
            <input type="text" class="styled" style="vertical-align:bottom;" name="nbr"/>
            <button class="icons fa-check fa-2x add" style=""></button>
            <input type="hidden" name="type" value="printer"/>
            <input type="hidden" name="id_parc" value="<?php echo $id_parc;?>"/>
        </form>
    </div>
</div>
<!-- FIN DETAILS COMPOSANTES PARC -->
<div class="center">
    <a href="./fpdf/rapport_parc.php?id=<?php echo $id_parc;?>" class="no_effect" target="_blank">
        <button class="button_act button--shikoba button--border-thin" type="submit"><i class="button__icon fa fa-print"></i><span>Imprimer le r&eacute;capitul&eacute;</span></button>
    </a>
</div>