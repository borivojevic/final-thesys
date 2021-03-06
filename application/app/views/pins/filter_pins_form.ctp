<div class="page" data-role="page" data-theme="c" style="width: 100%;">

	<?php echo $this->element('header'); ?>

	<div data-role="content" id="contentMain">
	
		<form id="filter-pins-form" action="javascript:void(0);" method="post">
		
			<h2>Pretraživanje liste restorana</h2>
			
			<p>Pretraživanje je moguće prema imenu restoran, vrsti kuhinje i maksimalnoj udaljenosti restorana od trenutne lokacije. Pronadjeni rezultatiće biti prikazane na mapi.</p>
			
			<div data-role="fieldcontain">
				<label for="name">Ime restorana:</label>
				<input type="text" name="name" id="name" value=""  /> 
			</div>
			
			<div data-role="fieldcontain"> 
				<label for="filter-area">Maksimalna udaljenost od objekta (km):</label> 
			 	<input type="range" name="filter-area" id="filter-area" value="1" min="1" max="50"  /> 
			</div>
			
			<div data-role="fieldcontain"> 
				<fieldset data-role="controlgroup"> 
					<legend>Kategorija restorana:</legend>
					<?php
						foreach($categories as $category_id => $category_name) {
							echo "<input type='checkbox' name='category[]' id='category-$category_id' class='custom' value='$category_id' />";
							echo "<label for='category-$category_id'>$category_name</label>";
						}
					?>
			    </fieldset>
			</div>
			
			<div class="ui-body-b">   
					<button type="submit" data-theme="a">Pronadji</button> 
			</div>
		
		</form>
	
	</div>
<script>
$(document).ready(function() {
	var filterPinsForm = $('#filter-pins-form');
	filterPinsForm.submit(function() {
		if(false == latitude || false == longitude) {
			apprise('Lokacija nije dostupna. Pokusajte ponovo kroz nekoliko sekundi');
			return false;
		}
		var name = $('#name').val();
		var categories = new Array();
		var filterArea = $('#filter-area').val();
		$.each($("input[name='category[]']:checked"), function() {
		  categories.push($(this).val());
		});
		var location = '/pins_map?name=' + name + '&category=' + categories.join(",")
				+ '&area=' + filterArea
				+ '&latitude=' + latitude
				+ '&longitude=' + longitude;
		window.location = location;
	});
	
});
</script>
</div>
