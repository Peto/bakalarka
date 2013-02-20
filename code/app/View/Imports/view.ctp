<div class="imports view">
<h2><?php  echo __('Import'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($import['Import']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date From'); ?></dt>
		<dd>
			<?php echo h($import['Import']['date_from']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date To'); ?></dt>
		<dd>
			<?php echo h($import['Import']['date_to']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Xml File'); ?></dt>
		<dd>
			<?php echo h($import['Import']['xml_file']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Processed'); ?></dt>
		<dd>
			<?php echo h($import['Import']['processed']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Filename'); ?></dt>
		<dd>
			<?php echo h($import['Import']['filename']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($import['User']['name'], array('controller' => 'users', 'action' => 'view', $import['User']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Import'), array('action' => 'edit', $import['Import']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Import'), array('action' => 'delete', $import['Import']['id']), null, __('Are you sure you want to delete # %s?', $import['Import']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Imports'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Import'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
