<script>
$(document).ready(function() {
	$( "#close_info" ).click(function() {
		$( "#mess_info" ).hide();
	});
});
</script>
<?php
if (isset($_REQUEST['message'])) {
	$message = utf8_decode($_REQUEST['message']);
}
if (isset($message)) {
	?>
	<div class="message_info" id="mess_info">
    <div id="close_info" class="del"><i class="fa fa-times"></i></div>
    <span><i class="fa fa-info-circle fa-fw"></i></span>
	<?php
	echo $message;
	?>
	</div>
	<?php
}
if (isset($_SESSION['message'])) {
	?>
	<div class="message_info" id="mess_info">
    <div id="close_info" class="del"><i class="fa fa-times"></i></div>
    <span><i class="fa fa-info-circle fa-fw"></i></span>
	<?php
	echo $_SESSION['message'];
	?>
	</div>
	<?php
	unset($_SESSION['message']);
}
?>