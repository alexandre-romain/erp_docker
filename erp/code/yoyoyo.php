<head>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.0/themes/ui-lightness/jquery-ui.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js" type="text/javascript"></script>
    <script type="text/javascript">
$(document).ready(function() {
$('div#thedialog').dialog({ autoOpen: false })
$('#thelink').click(function(){ $('div#thedialog').dialog('open'); });
})
    </script>
</head>
<body>
<div id="thedialog" title="Download complete">
    <p>
        <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
        Your files have downloaded successfully into the My Downloads folder.
    </p>
    <p>
        Currently using <b>36% of your storage space</b>.
    </p>
</div>
<a href="#" id="thelink">Clickme</a>
</body>