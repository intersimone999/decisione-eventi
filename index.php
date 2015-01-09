<?php
	 include 'config.php';
	 
	 session_start();
	 
	 if (isset($_SESSION['user'])) {
	 	header("Location: interface/dispatch.php");
	 	die();
	 }
?>
<html>
	<head>
		<link rel='stylesheet' href='style.css'>
		<!-- <link rel=icon href=favicon.ico type=image/x-icon> -->
		<script>
			function evaluate_form() {
				if (! /[A-Za-z0-9]+/.test(document.login.username.value) || document.login.username.value.length < 3) {
					alert("Nome non valido: troppo corto!");
					return false;
				}

				if (! /[A-Za-z0-9]+/.test(document.login.password.value) || document.login.password.value.length < 3) {
					alert("Password non valida: troppo corta!");
					return false;
				}

				return true;
			}

			function show_popup() {
				document.getElementById('notes').style.display='block'
				document.getElementById('fade').style.display='block'
			}

			function hide_popup() {
				document.getElementById('notes').style.display='none'
				document.getElementById('fade').style.display='none'
			}

		</script>
		<title>Decisioni per <?=$CFG['EVT_NAME']?> - Login</title>
	</head>

	<body>
		<div class='titlebox'>Accedi</div>
		<form id="login" name="login" action="functions/login_do.php" method="POST" onsubmit="return evaluate_form();">
			<div class='loginform'>
				<label id="user" for="username">p</label>
				<input type="text" name="username" id="username" placeholder="Username" required />
				<label id="pass" for="password">k</label>
				<input type="password" name="password" id="password" placeholder="Password" required />
				<input type="submit" id="submit" name="submit" value="a"/>
			</div>
		</form>
		<div class="option"> 
			<p>Decisioni</p> 
			<a href = "javascript:void(0)" onclick = "show_popup()">Note</a>
		</div>

		<div id="notes" class="popup">
			Inserisci il tuo nome per accedere al sistema. <br/>
			<a href="javascript:void(0)" onclick = "hide_popup()">Nascondi</a>
		</div>
    		<div id="fade" class="popup_background"></div>

		<?php if (isset($_GET['error'])) { ?>
			<center><div class='errorBox'>
				<?php if (intval($_GET['error']) == 1) { ?>
					Password non valida per il nome utente scelto!
				<?php } else { ?>
					Errore sconosciuto.
				<?php } ?>
			</div>
			</center>
		<?php } ?>
	</body>
</html>