<?php 

include_once("include/config/var.php"); 
if (!isset($lang)) {
   $lang ="$default_lang";
}

include_once("include/headers.php");?>

<script type="text/javascript">
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=250,height=450,left = 412,top = 234');");
}
</script>

<?php
include_once("include/finhead.php");

?>
<BODY onLoad="document.forms['form'].elements['login'].focus()">
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<form name="form" action="login.php" method='post'>
  <table width="276" border="1" align="center">
    <tr class="submit"> 
      <td colspan="2" class="submit"><strong>Fast IT Service ERP</strong></td>
    </tr> 
    <tr> 
      <td class="highlight.login"width="64" >Login</td>
      <td class="highlight.login"width="196" ><input type="text" name="login" maxlength="250"></td>
    </tr>
    <tr> 
      <td class="highlight.login">Password</td>
      <td class="highlight.login"><input type="password"name="pass" maxlength="30"><input type="hidden"name="lang" value="fr"></td>
    </tr>
    <tr class="submit"> 
      <td colspan="2" class="submit"><div align="center">
          <input name="submit" type="submit" value="login">
        </div></td>
    </tr>
  </table>
</form>
<center>
  <p>&nbsp;</p>
</center>
</body>
