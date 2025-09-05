<?php	

include("../config/common.php");
		// si une variable queryString a été posté
if(isset($_GET['newexist'])) 	
{
	$new_exist 	= $_GET['newexist'];
	$cli 		= $_GET['cli'];
	if ($new_exist == '0') {
		?>
        <label for="num_ticket" id="num_ticket_label">Ticket Parent</label><br/>
		<select name="num_ticket" id="num_ticket">
				<?php
				$sql1  = "SELECT rowid, name";
				$sql1 .= " FROM ".$tblpref."ticket";
				$sql1 .= " WHERE soc=".$cli." AND state=0";
					$resql=mysql_query($sql1);
					if ($resql)
					{
						$num = mysql_num_rows($resql);
						$i = 0;
						if ($num)
						{
							while ($i < $num)
							{
										$obj = mysql_fetch_object($resql);						
										if ($obj)
										{
											echo '<option value="'.$obj->rowid.'">'.$obj->name.'</option>';
											// You can use here results
											
										}	
								$i++;
							}
						}
					}
				?>
		</select>
        <?php
	}
	else {
		?>
		<label for="name_ticket" id="name_ticket_label">Demande du client</label><br/>
		<input type="text" size="25" id="name_ticket" name="name_ticket">
		<br/><br/>
		<label for="user_ticket" id="user_ticket_label">Responsable Ticket</label><br/>
		<select name="user_ticket" id="user_ticket">
				<?php
				$sql1 = "SELECT login, num";
				$sql1 .= " FROM ".$tblpref."user";
					$resql=mysql_query($sql1);
					if ($resql)
					{
						$num = mysql_num_rows($resql);
						$i = 0;
						if ($num)
						{
							while ($i < $num)
							{
										$obj = mysql_fetch_object($resql);						
										if ($obj)
										{
											echo '<option value="'.$obj->num.'">'.$obj->login.'</option>';
											// You can use here results
											
										}	
								$i++;
							}
						}
					}
				?>
		</select>
		<br/><br/>
		<label for="date_due_ticket" id="date_due_ticket_label">Date d'&eacute;cheance Ticket</label><br/>
		Le <input type="text" size="9" id="date_due_ticket" name="date_due_ticket" value="<?php echo date('d-m-Y', strtotime("+ 1 day"));?>"> &aacute; <input type="text" id="hour_due_ticket" name="hour_due_ticket" size="1" value="<?php echo date('H');?>"/>:<input type="text" id="min_due_ticket" name="min_due_ticket" size="1" value="<?php echo date('i');?>"/>
		<br/><br/>
		<label for="note_internal" id="note_internal_label">Note Interne Ticket</label><br/>
		<textarea id="note_internal" name="note_internal"></textarea>
		<br/><br/>
        <fieldset class="inticket">
        <legend>2a. Le Contact (optionel)</legend>
        <label for="name_contact"><i>Nom du contact</i></label><br/>
        <input type="text" size="25" value="" id="name_contact" name="name_contact" autocomplete="off"/>
        <br/><br/>
        <label for="firstname_contact"><i>Prenom du contact</i></label><br/>
        <input type="text" size="25" value="" id="firstname_contact" name="firstname_contact" autocomplete="off"/>
        <br/><br/>
        <label for="tel_contact"><i>Tel. Contact</i></label><br/>
        <input type="text" size="25" value="" id="tel_contact" name="tel_contact" autocomplete="off"/>
        <br/><br/>
        <label for="mail_contact"><i>Mail Contact</i></label><br/>
        <input type="text" size="25" value="" id="mail_contact" name="mail_contact" autocomplete="off"/>
        </fieldset>
        <?php
	}
} 
else 	
{
	echo 'Il ne devrait pas avoir un accès direct à ce script !!!'.$new_exist;
}
?>