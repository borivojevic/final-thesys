<div class="page" data-role="page" data-theme="c" style="width: 100%;">

	<?php echo $this->element('header'); ?>

	<div data-role="content" id="contentMain">
	
		<form id="profile-settings-form" action="javascript:void(0);" method="post">
		
			<h2>Podešavanje profila korisnika</h2>
			
			<p>Aplikacija "Vodič kroz restorane" može slati poruke tokom njenog korišćenja vezane za aktuelnu ponudu restorana.
			Tako na primer prolazeći pored restorana italijanske kuhinje možete dobiti obaveštenje da u njemu trenutno važi popust.
			Podešavanjima možete ograničiti tipove restorana koji vas zanimaju i maksimalnu udaljenost od objekta (uzimajući u obzir vašu trenutnu lokaciju u trenutku primanja obaveštenja) za koje ćete primati obaveštenja.
			Obaveštenja je moguće i isključiti ukoliko ne želite da ih primate. U svakom trenutku ih možete ponovo uključiti na ovoj strni. 
			Sva podešavanja se pamte lokalno u memoriji pretraživača.</p>
			
			<div data-role="fieldcontain"> 
				<label for="notification">Prijem obavestenja:</label> 
				<select name="notification" id="notification" data-role="slider"> 
					<option value="false">Isključeno</option> 
					<option value="true">Uključeno</option> 
				</select> 
			</div>
			
			<div data-role="fieldcontain"> 
				<label for="notification-area">Maksimalna udaljenost od objekta (km):</label> 
			 	<input type="range" name="notification-area" id="notification-area" value="1" min="1" max="50"  /> 
			</div>
			
			<div data-role="fieldcontain"> 
				<fieldset data-role="controlgroup"> 
					<legend>Kategorije restorana koje me interesuju:</legend>
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
				<button type="submit" data-theme="a">Snimi podešavanja</button> 
			</div>
		
		</form>
	
		<script>
		var loadFormData = function() {
			console.log('invoked');
			if(false != supportsLocalStorage()) {
				console.log(localStorage);
				$('#notification').val(localStorage.notificationEnabled);
				var categories = localStorage.notificationCategories.split(',');
				$("input[name='category[]']").val(categories);
				$("input[type=range]").val(localStorage.notificationArea).slider("refresh");
			}
		}
		$(document).ready(function() {
			loadFormData();
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
	</div>
</div>
