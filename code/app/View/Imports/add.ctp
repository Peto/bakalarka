<div class="imports form">
<?php echo $this->Form->create('Import'); ?>
	<fieldset>
		<legend><?php echo __('Add Import'); ?></legend>
	<?php
		echo $this->Form->input('date_from');
		echo $this->Form->input('date_to');
		echo $this->Form->input('xml_file');
		echo $this->Form->input('processed');
		echo $this->Form->input('filename');
		echo $this->Form->input('user_id', array('type' => 'hidden','value' => $user));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Imports'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
