<div id="gmap" class="page" data-role="page" data-theme="c" style="width:100%; height:100%">

	<?php echo $this->element('header'); ?>

</script>
	<div data-role="content" id="map_canvas" style="height:90%;"></div>
</div>
<script type="text/javascript">
	$('#gmap').live("pageshow", function() {
		var pinMap = $('#map_canvas').pinMap();
	});
</script>
