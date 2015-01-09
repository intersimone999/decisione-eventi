<?php
	 include '../config.php';
	 require_once ROOT_DIR . '/core/ListControl.php';
	 require_once ROOT_DIR . '/core/AgreementControl.php';
	 require_once ROOT_DIR . '/core/UserControl.php';

	 session_start();
	 
	 if (!isset($_SESSION['user'])) {
	 	redirect("../index.php");
	 	die();
	 }
	 
	 if ($CFG['EVT_TYPE'] != $EVT_SHOP) {
	 	redirect("../index.php");
	 	die();
	 }
	 
	 $control = new ListControl();
	 $agControl = new AgreementControl();
	 $usControl = new UserControl();
	 $list = $control->getList();
	 $user = $_SESSION['user'];
?>
<html>
	<head>
		<?php
			include "include/header.php";
		?>
		<script>
			function showAddItem() {
				document.getElementById("addItemBox").innerHTML = 
					"<form method='POST' action=\"../functions/additem.php\">" +
					"<input id='addItemText' onkeyup='checkAddTextOk()' type='text' name='object' placeholder='Cosa compriamo?' />" +
					"<input id='addItemQuantity' type='text' name='quantity' placeholder='Quanti?' style='width: 15%' />" +
					"<input id='addItemSubmit' disabled type=submit value='+'>" + 
					"</form>";
			}

			function checkAddTextOk() {
				if (document.getElementById("addItemText").value.length == 0)
					document.getElementById("addItemSubmit").disabled = true;
				else
					document.getElementById("addItemSubmit").disabled = false;
			}

			function checkEditTextOk(id, objectName) {
				if (document.getElementById("editItemText" + id).value.length == 0 || document.getElementById("editItemText" + id).value == objectName)
					document.getElementById("editItemSubmit" + id).disabled = true;
				else
					document.getElementById("editItemSubmit" + id).disabled = false;
			}

			function showEditItem(item) {
				objectId = item.id.substring(8);
				objectQuantity = item.innerHTML;


				item.innerHTML = 
					"<form method='POST' action=\"../functions/edititem.php\"><input id='editItemText" + objectId + "' type='text' name='quantity' value='" + objectQuantity + "' placeholder='Quanti?' style='width: 15%' /><input type='hidden' name='id' value='" + objectId + "' / ><input id='editItemSubmit" + objectId + "' type=submit value='Edit'></form>";
				item.onclick = "";
			}

			function agree(id) {
				window.location.href = "../functions/agree.php?agree=1&id="+id;
			}

			function disagree(id) {
				window.location.href = "../functions/agree.php?agree=0&id="+id;
			}
		</script>
		
		<title>Decisioni per <?=$CFG['EVT_NAME']?> - Lista della spesa</title>
	</head>

	<body>
		<div class="titlebox">Lista della spesa</div>
		<?php
			include 'include/menu.php'; 
		?>
		<div class="sharedBox">
			<center>
			<table width=50% border='0'>
				<tr>
					<th width='50%'>Nome</th>
					<th width='50%'>Quantit&agrave;</th>
				</tr>
				<?php
					foreach ($list as $element) {
						$object = new Item();
						$object->setId($element['id']);
						$positiveAgreements = $agControl->getPositiveAgreements($object);
						$negativeAgreements = $agControl->getNegativeAgreements($object);
						
						$agrees = join(", ", $positiveAgreements);
						$disagrees = join(", ", $negativeAgreements);
						
						$risk = count($positiveAgreements) < count($negativeAgreements);
						$approved = count($positiveAgreements) > (count($usControl->getAllUsers()) / 2);
						if ($element['quantity'] == null)
							$element['quantity'] = "0";
							
						echo "<tr>\n";
						echo "<td " . ($risk ? "class='riskCell' " : "") . ($approved ? "class='approvedCell' " : "") . "width='50%'><div align='center'>" . $element['object'] . "</div><div align='center'><span class='agree' onclick='agree(" . $element['id'] .")' title='Approvato da $agrees'>". count($positiveAgreements) . "</span><span class='disagree' onclick='disagree(" . $element['id'] .")' title='Disapprovato da $disagrees'>". count($negativeAgreements) . "</span></div></td>\n";
						echo "<td " . ($risk ? "class='riskCell' " : "") . ($approved ? "class='approvedCell' " : "") . "width='50%'><span class='editBox'><div id='editItem" . $element['id'] . "' class='itemBox' onclick='showEditItem(this)'>" . $element['quantity'] .  "</div></td>";
						echo "</tr>\n";
					}
				?>
				<tr>
					<td><?=$user->getName()?></td>
					<td>
						<div id="addItemBox" class="itemBox">
							<input type=button value="+" onclick="showAddItem()"/>
						</div>
					</td>
				</tr>
			</table>
			</center>
		</div>
		<center>
			<div class="sharedDescr">
				Questa &egrave; la lista della spesa per <?= $CFG['EVT_NAME']?>. &Egrave; possibile aggiungere nuove proposte cliccando sul <b>+</b>
				oppure modificare le quantit&agrave; di un elemento gi&agrave; proposto cliccando sul numero e compilando il campo.<br/>
				Si pu&ograve; esprimere approvazione o dissenso per gli elementi.<br/>
				<b>Nota:</b> le quantit&agrave; sono da intendersi come "pezzi" o "grammi" (in base all'elemento).
			</div>
		</center>
	</body>
</html>