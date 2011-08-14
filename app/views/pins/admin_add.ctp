<?php
$javascript->link('http://maps.google.com/maps/api/js?sensor=true', false);
$javascript->link('addPin', false);
?>
<div id="addPinMap" style="width: 600px; height: 300px;"></div>
<?php
echo $this->Form->create('Pin');

echo $this->Form->hidden('latitude');
echo $this->Form->hidden('longitude');
echo $this->Form->hidden('zoom');
echo $this->Form->hidden('close');

echo $this->Form->error('latitude');
echo $this->Form->error('longitude');

echo $this->Form->input('name');
echo $this->Form->input('address');
echo $this->Form->input('telephone');
echo $this->Form->input('cellphone');
echo $this->Form->input('email');
echo $this->Form->input('website');
echo $this->Form->input('work_hours');
echo $this->Form->input('Category');

echo $this->Form->end('Submit');
?>

<script type="text/javascript">
$(document).ready(function() {
	setupMap();
});
</script>