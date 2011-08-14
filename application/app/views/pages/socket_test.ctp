<div align="center" data-role="content" id="notification-div" name="notification-div">
	<p id="notification-message"></p>
	<button data-theme="a" onclick="javascript:hideNotificationDiv();"><?php echo __('Ok', true); ?></button>
</div>
<script>
var hideNotificationDiv = function() {
	$('#notification-div').hide();
}

$(document).ready(function() {
	$('#notification-div').hide();
	if ("WebSocket" in window) {
	    host = "localhost:7777";
	    conn = new WebSocket("ws://"+host+"/");
	    conn.onmessage = function(evt) {
	        postMessage(evt.data);
	    };
	
	    conn.onerror = function() {
	    };
	
	    conn.onclose = function() {
	        conn = false;
	    };
	
	    conn.onopen = function() { 
	        //alert("You are connected");
	        //postMessage("You are connected");
	    };
	}
});

function postMessage(msg){
	$('#notification-div').show();
    $("#notification-message").text(msg);
}
</script>