<link rel='stylesheet' href='<?=abspath("style.css")?>'>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />
<!-- <link rel=icon href=favicon.ico type=image/x-icon> -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
<script src="../scripts/chat.js"></script>
<script src="../scripts/menu.js"></script>
<script>
	<?php
		echo "window.myUsername = '" . $_SESSION['user']->getName() . "';" 
	 ?>
</script>