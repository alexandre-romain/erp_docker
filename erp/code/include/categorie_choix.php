<input type="text" id="rech" onChange="showarticle()" onKeyUp="showarticle()" autocomplete="off" class="styled"/>
<br/><br/>
<select id="article" name="article" size="10" class="styled-multi" onchange="copy_pn()">
	<option></option>
</select>
<br/><br/>
<div id="create_article_link" style="display:none;vertical-align:bottom;margin-bottom:-3px"><a href="./form_article.php" class="no_effect" target="_blank"><i class="fa fa-pencil-square fa-fw fa-2x action" title="Cr&eacute;er un nouvel article"></i></a></div><input type="text" id="pn_copy" class="styled" style="width:25%;"/>