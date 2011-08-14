<?php $javascript->link('profileSettings', false); ?>
<div class="page" data-role="page" data-theme="c" style="width: 100%; height: 100%">

	<div data-role="header" id="hdrMain">
		<h1>Diplomski Rad</h1>
	</div>
	
	<div data-role="content" id="contentMain">
	
		<form id="profile-settings-form" action="javascript:void(0);" method="post">
		
			<h2>Podesavanje lokalnog profila korisnika</h2>
			
			<p>Podesi tip obavestenja koji zelis da primas</p>
			
			<div data-role="fieldcontain"> 
				<label for="notification">Prijem obavestenja:</label> 
				<select name="notification" id="notification" data-role="slider"> 
					<option value="false">Iskljuceno</option> 
					<option value="true">Ukljuceno</option> 
				</select> 
			</div>
			
			<div data-role="fieldcontain"> 
				<label for="notification-area">Udaljenost objekta (km):</label> 
			 	<input type="range" name="notification-area" id="notification-area" value="1" min="1" max="50"  /> 
			</div>
			
			<div data-role="fieldcontain"> 
				<fieldset data-role="controlgroup"> 
					<legend>Odaberi kategoriju:</legend>
					<?php
						$categories = $this->requestAction('categories/get_all');
						foreach($categories as $category_id => $category_name) {
							echo "<input type='checkbox' name='category[]' id='category-$category_id' class='custom' value='$category_id' />";
							echo "<label for='category-$category_id'>$category_name</label>";
						}
					?>
			    </fieldset>
			</div>
			
			<div class="ui-body-b">   
					<button type="submit" data-theme="a">Snimi</button> 
			</div>
		
		</form>
	
	</div>
</div>
<script>
$(document).ready(function() {
	var profileSettingsForm = $('#profile-settings-form');
	profileSettingsForm.submit(function() {
		if(false == supportsLocalStorage()) {
			alert('Nije moguce snimiti podesavanja jer uredjaj ne podrzava lokalnu memoriju');
			return;
		}
		var notificationEnabled = $('#notification').val();
		var notificationArea = $('#notification-area').val();
		var notificationCategories = new Array();
		$.each($("input[name='category[]']:checked"), function() {
			notificationCategories.push($(this).val());
		});
		localStorage["notificationEnabled"] = notificationEnabled;
		localStorage["notificationArea"] = notificationArea;
		localStorage["notificationCategories"] = notificationCategories;
		alert('Podesavanja su snimljena');
	});
});
</script>
<?php echo $this->element('notifications'); ?>