<?php
	include '../config.php';
	
	if ($CFG['EVT_TYPE'] == $EVT_SHARED)
		redirect("shared.php");
	else if ($CFG['EVT_TYPE'] == $EVT_SHOP)
		redirect("shop.php");
	else
		redirect("error.php?id=1")
?>