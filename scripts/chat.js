timer = null;
var chatStatus = false;
var lastRead;
var lastTime;
function sendMessage() {
	value = $("#chatMessage").val();
	value = value.replace(/\</gi, "&lt;");
	value = value.replace(/\>/gi, "&gt;");
	if (value.length == 0)
		return;
	
	$.ajax({
		url: '../functions/sendmessage.php',
		data: {
			message: value
		}
	}).done(function(data) {
		$("#chatMessage").val("");
	});
}

function update() {
	clearTimeout(timer);
	
	$.ajax({
		url: '../functions/getmessages.php',
		data: {
			since: lasttime
		}
	}).done(function(data) {
		addMessage(data);
		timer = setTimeout(update, 500);
	});
}

function addMessage(data) {
	var obj = JSON.parse(data);
	lastTime = lasttime-1;
	for (var i = 0; i < obj.messages.length; i++) {
		author = obj.messages[i].author;
		message = obj.messages[i].message;
		time = parseInt(obj.messages[i].time);
		
		klass = (author == window.myUsername ? "myChatMessage" : "chatMessage");
		$("#messageBoard").append(
			"<div class='" + klass + "'><span class='author'>" + author + "</span><div class='message'>" + message + "</div></div>"
		);
		$('#messageBoard').scrollTop($('#messageBoard')[0].scrollHeight);
		

		lastTime = time;
	}
	
	if (obj.messages.length != 0) {
		if (!chatStatus) {
			if (lastRead < lastTime)
				notifyChat();
		} else {
			saveLastRead(time);
		}
	}
	
	lasttime = lastTime+1;
}

function notifyChat() {
	$("#chatEnabler").css("background-image", "url('../imgs/chatNotify.png')");
	$('#chatEnabler').effect("bounce", {times:40}, 300);
}

function denotifyChat() {
	$("#chatEnabler").css("background-image", "url('../imgs/chat.png')");
	saveLastRead(lastTime);
}

function showChatWindow() {
	chatStatus = true;
	$("#chatBox").show("fast", function() {$('#messageBoard').scrollTop($('#messageBoard')[0].scrollHeight);});
	denotifyChat();
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return parseInt(c.substring(name.length,c.length));
    }
    return 0;
}


function getLastRead() {
	return getCookie("lastread");
}

function saveLastRead(lr) {
	lastRead = lr;
	document.cookie = "lastread=" + lr + "; expires=Thu, 28 Mar 2030 12:45:00 GMT";
}

function hideChatWindow() {
	chatStatus = false;
	$("#chatBox").hide("fast", function() {});
}

$(document).ready(function() {
	$("#chatMessage").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#buttonSend").click();
	    }
	});
	
	hideChatWindow();
	
	$("#chatEnabler").click(function() {
		if (chatStatus)
			hideChatWindow();
		else
			showChatWindow();
	});
	
	lastRead = getLastRead();

	
	lasttime = 0;
	update();
})