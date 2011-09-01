<h2>Pošalji obavestenje</h2>
<?php
	echo $this->Form->create('Pin', array('url' => '/pins/send_notification', 'type' => 'POST'));
	echo $this->Form->input('id', array('type' => 'select', 'options' => $pins, 'label' => 'Ime restorana'));
	echo $this->Form->input('text', array('type' => 'textarea', 'label' => 'Tekst obaveštenja', 'id' => 'notification-text'));
	echo $this->Form->end('Pošalji');
?>
