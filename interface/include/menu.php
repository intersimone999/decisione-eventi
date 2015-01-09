<div class="menu">
	<div class="iconChat" title="Apri la chat" id="chatEnabler"></div>
	<div class="iconHome" title="Torna alla pagina principale"></div>
	<div class="iconCar" title="Apri la gestione delle auto"></div>
	<div class="iconLogout" title="Esci"></div>
</div>
<center>
	<div class="chatBox" id="chatBox">
		<div class="messagebox" id="messageBoard">
		</div>
		<div class="messagesend">
			<input type="text" id="chatMessage" maxlength="1500" name="text" placeholder="Scrivi..." />
			<input type="button" id="buttonSend" value=">" onclick="sendMessage()" /> 
		</div>
	</div>
</center>