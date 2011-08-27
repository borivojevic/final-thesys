<div id="notifications-page" class="page" data-role="page" data-theme="c" style="width: 100%;">

	<?php echo $this->element('header'); ?>

	<div data-role="content" id="contentMain">
		
		<h2>Predhodne ponude</h2>
			
		<p>Lista sadrži nedavno primljene ponude o popustima u restoranima. Sav sadržaj je zapamćen u lokalnoj memoriji pretraživača.</p>

		<ul id="notifications-list" data-role="listview" data-theme="c"></ul>
	
		<script>
		$("#notifications-page").bind("pageshow", function() {
			if(false == supportsLocalStorage() || undefined == localStorage.notifications) {
				apprise('Podaci nisu dostupni');
				return;
			}
			var localNotifications = localStorage.notifications.split(',');
			$.each(localNotifications, function(index, value) {
				var itemText = value;
				if(itemText.length > 25) {
				    itemText = itemText.substring(0,24)+"...";
				}
				var listItem = $('<li><a href="#">' + itemText + '</a></li>').bind('tap', function() {
					apprise(value);
				});
				$('#notifications-list').append(listItem);
			});
			$('#notifications-list').listview('refresh');
		});
		</script>
	</div>
</div>
