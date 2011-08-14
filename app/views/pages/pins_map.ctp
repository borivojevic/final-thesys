<?php
$javascript->link('geo', false);
$javascript->link('http://maps.google.com/maps/api/js?sensor=true', false);
$javascript->link('pinMap', false);
?>
<div class="page" data-role="page" id="map_canvas" style="width:100%; height:100%;"></div>
<script type="text/javascript">
$(document).ready(function() {
	var pinMap = $('#map_canvas').pinMap();
//	$(".search-input").pinSearch(pinMap);
//	pinPinMap.setCategories([1, 2, 3, 5]);
});
</script>
