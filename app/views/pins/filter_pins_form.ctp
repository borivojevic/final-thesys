<div class="page" data-role="page" data-theme="c" style="width: 100%; height: 100%">

	<div data-role="header" id="hdrMain">
		<h1>Diplomski Rad</h1>
	</div>
	
	<div data-role="content" id="contentMain">
	
		<form id="filter-pins-form" action="javascript:void(0);" method="post">
		
			<h2>Podesavanje pretrazivanja</h2>
			
			<p>Filtriranje mape prema imenu objekta i po kategoriji kojoj objekat pripada.</p>
			
			<div data-role="fieldcontain">
				<label for="name">Ime:</label>
				<input type="text" name="name" id="name" value=""  /> 
			</div>
			
			<div data-role="fieldcontain"> 
				<fieldset data-role="controlgroup"> 
					<legend>Odaberi kategoriju:</legend>
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
		var name = $('#name').val();
		var categories = new Array();
		$.each($("input[name='category[]']:checked"), function() {
		  categories.push($(this).val());
		});
		var location = '/pins_map?name=' + name + '&category=' + categories.join(",");
		window.location = location;
	});
	
});
</script>
</div>