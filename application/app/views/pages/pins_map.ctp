<?php
$javascript->link('http://maps.google.com/maps/api/js?sensor=true', false);
$javascript->link('pinMap', false);
?>
<div id="gmap" class="page" data-role="page" data-theme="c" style="width:100%; height:100%">

	<?php echo $this->element('header', array('show_home' => true)); ?>

	<script type="text/javascript">
		$('#gmap').live("pageshow", function() {
			var pinMap = $('#map_canvas').pinMap();
		});
	</script>

	<div data-role="content" id="map_canvas" style="height:90%;"></div>
</div>
