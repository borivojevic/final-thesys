<?php
$this->Html->css('jquery.mobile-1.0a4.1.min.css', NULL, array('inline' => false));
$this->Html->css('upload_form', NULL, array('inline' => false));
$javascript->link('jquery-1.5.2.min', false);
$javascript->link('jquery.mobile-1.0a4.1.min', false);
$javascript->link('geo', false);
$javascript->link('jquery.activity-indicator-1.0.0.min', false);
?>
<div data-role="page" data-theme="c" style="width: 100%; height: 100%">

	<div data-role="header" id="hdrMain">
		<h1>Diplomski Rad</h1>
	</div>
	
	<div data-role="content" id="contentMain">
	
		<form id="upload-form" action="add" method="post"
			enctype="multipart/form-data" data-ajax="false">
		
			<h2>Form elements</h2>
			
			<?php echo $form->hidden('latitude');?>
			<?php echo $form->hidden('longitude');?>
			
			<div data-role="fieldcontain">
				<label for="title"><?php echo __('Title', true)?>:</label>
				<input type="text" name="title_r" id="title" />
			</div>
			
			<div data-role="fieldcontain">
				<label for="description"><?php echo __('Description', true)?>:</label> <input
				type="text" name="description_r" id="description" />
			</div>
			
			<div data-role="fieldcontain">
				<label for="file"><?php echo __('File', true)?>:</label> <input
				type="file" name="file_r" id="file" />
			</div>
			
			<div class="ui-block-b">
				<button type="submit" data-theme="a">Posalji</button>
			</div>
			
		
		</form>
	
	</div>
	
	<!-- ====== dialog content starts here ===== -->
	<div align="center" data-role="content" id="contentDialog" name="contentDialog">
		<p><?php echo __('Please fill in all required fields', true); ?></p>
		<button data-theme="a" onclick="javascript:hideContentDialog();showMain();"><?php echo __('Ok', true); ?></button>
	</div>
	<!-- ====== dialog content ends here ===== -->  

	<!-- ====== transition content page starts here ===== -->
	<div align="center" data-role="content" id="contentTransition" name="contentTransition">
		<p><?php echo __('Data sent to server. Please wait...', true); ?></p>
		<div id="activity-indicator"></div>
	</div>
	<!-- ====== transition content ends here ===== --> 
</div>

<script>
//Global declarations - assignments made in $(document).ready() below
var hdrMainvar = null;
var contentMainVar = null;

var contentTransitionVar = null;

var uploadFormVar = null;

var contentDialogVar = null;

// Constants
var MISSING = "missing";
var EMPTY = "";
var NO_STATE = "ZZ";

function hideMain() {
	hdrMainVar.hide();
	contentMainVar.hide();
}

function showMain() {
	hdrMainVar.show();
	contentMainVar.show();
}

function hideContentTransition(){
	contentTransitionVar.hide();
}      

function showContentTransition(){
	contentTransitionVar.show();
}

function hideContentDialog(){
	contentDialogVar.hide();
}   

function showContentDialog(){
	contentDialogVar.show();
}


$(document).ready(function() {
	// Assign global variables
    hdrMainVar = $('#hdrMain');
    contentMainVar = $('#contentMain');

    contentTransitionVar = $('#contentTransition');

    uploadFormVar = $('#upload-form');
    
    contentDialogVar = $('#contentDialog');

//    hideMain();
    hideContentDialog();
    hideContentTransition();

    $('#activity-indicator').activity();
	
	if (geo_position_js.init()) {
		geo_position_js.getCurrentPosition(show_position, error_handler("Couldn't get location"));
	}
	
	uploadFormVar.submit(function() {
		var err = false;
		// Hide the Main content  
		hideMain();

		// Reset the previously highlighted form elements 
		$('input[name*="_r"]').each(function(index){
			$(this).prev().removeClass(MISSING);
		});
		
		// Perform form validation
		$('input[name*="_r"]').each(function(index){
			if($(this).val()==null || $(this).val()==EMPTY){
				$(this).prev().addClass(MISSING);
				err = true;
			}
		});

		// If validation fails, show Dialog content
		if(err == true) {
			showContentDialog();
			return false;
		}

		// If validation passes, show Transition content  
		showContentTransition(); 

		// Submit the form
		$.post("uploads/add", uploadForm.serialize(), function(data) {
			//confirmationVar.text(data);
			hideContentTransition();
			//showConfirmation();
		});
		return false;
	});
	
});

function show_position(p) {
	$('#latitude').val(p.coords.latitude);
	$('#longitude').val(p.coords.longitude);
}

function error_handler(msg) {
	console.log(msg);
}
</script>
