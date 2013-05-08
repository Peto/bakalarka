<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Registrácia'); ?></legend>
		<div class="input_polia"><?php echo $this->Form->input('email', array('label' => 'Email:'));?></div>
		<div class="input_polia"><?php echo $this->Form->input('name', array('label' => 'Meno:'));?></div>
		<div class="input_polia"><?php echo $this->Form->input('surname', array('label' => 'Priezvisko:'));?></div>
		<div class="input_polia"><?php echo $this->Form->input('password', array('label' => 'Heslo:'));?></div>
		<div class="input_polia"><?php echo $this->Form->input('password_confirm', array('type' => 'password', 'label' => 'Potvrdenie hesla:'));?></div>
	</fieldset>
<?php echo $this->Form->end(__('Zaregistrovať sa')); ?>
</div>
<div class="actions">
	
</div>
