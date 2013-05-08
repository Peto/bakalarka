<div class="imports form">
<?php echo $this->Form->create('Import', array('enctype' => 'multipart/form-data')); ?>
	<fieldset>
		<legend><?php echo __('Pridať import'); ?></legend>
	<?php
		echo $this->Form->input('file', array(
				'between' => '<br />',
				'type' => 'file',
				'label' => 'Súbor na import'
		));
		echo $this->Form->input('user_id', array('type' => 'hidden','value' => $user));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Importovať')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Akcie'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Zoznam importov'), array('action' => 'index')); ?></li>
	</ul>
</div>
