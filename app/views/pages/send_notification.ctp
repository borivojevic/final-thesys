<?php $javascript->link('janky.post.min', false); ?>
<div data-role="page" data-theme="c" style="width: 100%; height: 100%">

	<div data-role="header" id="hdrMain">
		<h1>Diplomski Rad</h1>
	</div>
	
	<div data-role="content" id="contentMain">
	
		<form id="profile-settings-form" action="javascript:void(0);" method="post">
		
			<h2>Posalji obavestenje</h2>
			
			<p>Posalji obavestenje klijentima</p>
			
			<div data-role="fieldcontain"> 
				<label for="notification-text">Textarea:</label> 
				<textarea cols="40" rows="8" name="notification-text" id="notification-text"></textarea> 
			</div> 
			
			<div class="ui-body-b">   
					<button type="submit" data-theme="a">Posalji</button> 
			</div>
		
		</form>
	
	</div>
</div>
<script>
$(document).ready(function() {
	var profileSettingsForm = $('#profile-settings-form');
	profileSettingsForm.submit(function() {
		var notificationText = $('#notification-text').val();
		janky({ url: "http://localhost:7777",
			method: 'post', 
            data: {message: notificationText}, 
            success: function(resp) {
              console.log('server responded with: ' + resp);
            }, 
            error: function() {
              console.log('error =(');
            }
    });
	});
});
</script>