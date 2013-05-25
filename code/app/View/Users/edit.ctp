<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Editácia'); ?></legend>
	<?php
		echo $this->Form->input('id');
		//echo $this->Form->input('email');
		echo $this->Form->input('name', array('label' => 'Meno'));
		echo $this->Form->input('surname', array('label' => 'Priezvisko'));
		//echo $this->Form->input('password', array('label' => 'Heslo'));
		//echo $this->Form->input('active', array('label' => 'Aktívny'));
		//echo $this->Form->input('user_type_id', array('label' => 'Typ používateľa'));
	    echo $this->Html->link("Zmeniť heslo",array("controller"=>"users","action"=>"forgetpwd"));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Uložiť')); ?>
</div>
