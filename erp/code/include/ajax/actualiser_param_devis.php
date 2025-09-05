<?php
include("../config/common.php");
include("../fonctions.php");
?>
<div class="portion_subtitle">
    <i class="fa fa-arrows-h fa-fw"></i> Correspondance entre les cat&eacute;gories d'articles et les cat&eacute;gories de composants pour les devis pr&eacute;d&eacute;finis
</div>
<div class="part_param_devis">
    <div class="devis_cat">Processeur</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='processeur'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="processeur"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">Carte m&egrave;re</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='motherboard'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="motherboard"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">M&eacute;moire RAM</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='ram'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="ram"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">Refroidissement CPU</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='fan'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="fan"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">P&acirc;te thermique</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='pate'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="pate"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">Carte graphique</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='gpu'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="gpu"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">HDD/SSD</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='hdd'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="hdd"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">Lecteur/Graveur</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='cd'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="cd"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">Lecteur de carte</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='carte'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="carte"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">Carte WiFi</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='wifi'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="wifi"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">Carte son</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='son'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="son"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">Boitier</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='case'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="case"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">Alimentation</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='alimentation'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="alimentation"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">OS</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='os'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="os"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">Logiciel</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='software'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="software"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">Ecran</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='screen'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="screen"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">Clavier</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='keyboard'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="keyboard"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">Souris</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='mouse'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="mouse"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">Enceintes</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='hifi'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="hifi"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">Casque/Micro</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='headset'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="headset"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">Cl&eacute; Wifi</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='wifikey'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="wifikey"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">Imprimante</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='printer'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="printer"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">Webcam</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='webcam'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="webcam"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">Autre</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='other'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="other"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>

<div class="part_param_devis">
    <div class="devis_cat">C&acirc;ble</div>
    <div class="devis_content_cat">
        <div class="linked_cat_content">
            <?php
            //On va récupérer les catégories actuellements liées
            $sql="SELECT c.categorie, cc.id";
            $sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
            $sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
            $sql.=" WHERE cc.cat_devis='wire'";
            $req=mysql_query($sql);
            while($obj = mysql_fetch_object($req)) {
                ?>
                <div class="linked_cat">
                    <form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
                        <span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
            <div class="content_select_param_devis">
                <select name="cat" id="cat_proc" class="select_param_devis">
                    <?php
                    $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                    $req=mysql_query($sql);
                    while ($obj = mysql_fetch_object($req)) {
                        ?>
                        <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="type" value="wire"/>
            <button class="icons fa-plus-square-o fa-3x add"></button>
        </form>
    </div>
</div>