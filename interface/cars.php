<?php
	 include '../config.php';
	 require_once ROOT_DIR . '/core/CarControl.php';
	 require_once ROOT_DIR . '/core/AgreementControl.php';
	 require_once ROOT_DIR . '/core/UserControl.php';

	 session_start();
	 
	 if (!isset($_SESSION['user'])) {
	 	redirect("../index.php");
	 	die();
	 }
	 
	 $control = new CarControl();
	 $usControl = new UserControl();
	 $user = $_SESSION['user'];
	 
	 $list = $control->getAllCars();
	 $allusers = $usControl->getAllUsers();
?>
<html>
	<head>
		<?php
			include "include/header.php"; 
		?>
		
		<script>
			function showAddCar() {
				document.getElementById("addCarBox").innerHTML = 
					"<form method='POST' action=\"../functions/addcar.php\"><input id='addCarText' onkeyup='checkAddTextOk()' onclick='checkAddTextOk()' type='number' name='sits' min='1' max='12' placeholder='Quanti posti?' /><input id='addCarSubmit' disabled type=submit value='+'></form>"
			}

			function checkAddTextOk() {
				if (document.getElementById("addCarText").value.length == 0)
					document.getElementById("addCarSubmit").disabled = true;
				else
					document.getElementById("addCarSubmit").disabled = false;
			}
		</script>
		
		<title>Decisioni per <?=$CFG['EVT_NAME']?> - Auto</title>
	</head>

	<body>
		<div class="titlebox">Gestione automobili</div>
		<?php
			include 'include/menu.php'; 
		?>
		<div class="sharedBox">
			<center>
			<table width=50% border='0'>
				<tr>
					<th width='50%'>Automobile</th>
					<th width='50%'>Posti</th>
				</tr>
				<?php
					$total_sits = 0;
					foreach ($list as $element) {						
						echo "<tr>\n";
						echo "<td width='50%'>" . $element['user'] . "</td>\n";
						echo "<td width='50%'>" . $element['sits'] . "</td>\n";
						echo "</tr>\n";
						$total_sits += intval($element['sits']);
					}
				?>
				<tr>
					<td><?=$user->getName()?></td>
					<td>
						<div id="addCarBox" class="itemBox">
							<input type=button value="+" onclick="showAddCar()"/>
						</div>
					</td>
				</tr>
				<tr>
					<td><b>Totale</b></td>
					<td><b><?=$total_sits?></b></td>
				</tr>
			</table>
			</center>
		</div>
		<center>
			<?php 
				$users_number = count($allusers)-1;
				if ($total_sits < $users_number) {
					$missing_cars = ceil(($users_number - $total_sits) / 5.0);
					$kind = "warningBox";
					$message = "Non ci sono abbastanza auto! Sono disponibili $total_sits posti, ma ne servono almeno $users_number. &Egrave; necessario trovare $missing_cars auto (da 5 posti) in pi&ugrave;.";
				} else {
					$kind = "infoBox";
					$message = "Le auto sono sufficienti.";
					
					if ($total_sits - $users_number > 0) {
						$more = $total_sits - $users_number;
						$message .= " Sono disponibili altri $more posti!";
					}
				}
				
				echo "<div class=\"$kind\">";
				echo $message; 
				echo "</div>";
			?>
			
			<div class="sharedDescr">
				Queste sono le automobili da usare per <?= $CFG['EVT_NAME']?>. Se ne pu&ograve; aggiungere una cliccando sul bottone <b>+</b>. 
			</div>
		</center>
	</body>
</html>