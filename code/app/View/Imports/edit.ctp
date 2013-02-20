<div class="imports form">
<?php echo $this->Form->create('Import'); ?>
	<fieldset>
		<legend><?php echo __('Edit Import'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('date_from');
		echo $this->Form->input('date_to');
		echo $this->Form->input('xml_file');
		echo $this->Form->input('processed');
		echo $this->Form->input('filename');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Import.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Import.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Imports'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
