<div class="imports index">
	<h2><?php echo __('Imports'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('date_from'); ?></th>
			<th><?php echo $this->Paginator->sort('date_to'); ?></th>
			<th><?php echo $this->Paginator->sort('xml_file'); ?></th>
			<th><?php echo $this->Paginator->sort('processed'); ?></th>
			<th><?php echo $this->Paginator->sort('filename'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($imports as $import): ?>
	<tr>
		<td><?php echo h($import['Import']['id']); ?>&nbsp;</td>
		<td><?php echo h($import['Import']['date_from']); ?>&nbsp;</td>
		<td><?php echo h($import['Import']['date_to']); ?>&nbsp;</td>
		<td><?php echo h($import['Import']['xml_file']); ?>&nbsp;</td>
		<td><?php echo h($import['Import']['processed']); ?>&nbsp;</td>
		<td><?php echo h($import['Import']['filename']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($import['User']['name'], array('controller' => 'users', 'action' => 'view', $import['User']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $import['Import']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $import['Import']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $import['Import']['id']), null, __('Are you sure you want to delete # %s?', $import['Import']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Import'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
