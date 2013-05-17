<div class="imports index">
	<h2><?php echo __('Importy'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('date_from','Dátum od'); ?></th>
			<th><?php echo $this->Paginator->sort('date_to','Dátum do'); ?></th>
			<th><?php echo $this->Paginator->sort('processed','Spracovaný'); ?></th>
			<th><?php echo $this->Paginator->sort('Názov súboru'); ?></th>
			<th class="actions"><?php echo __('Akcie'); ?></th>
	</tr>
	<?php foreach ($imports as $import): ?>
	<tr>
		<td><?php echo h($import['Import']['id']); ?>&nbsp;</td>
		<td><?php echo h($import['Import']['date_from']); ?>&nbsp;</td>
		<td><?php echo h($import['Import']['date_to']); ?>&nbsp;</td>
		<td><?php echo h($import['Import']['processed']); ?>&nbsp;</td>
		<td><?php echo $this->Html->link($import['Import']['filename'], array('action' => 'view', $import['Import']['id'])); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Spracuj'), array('action' => 'process_import', $import['Import']['id'])); ?>
			<?php echo $this->Html->link($this->Html->image('/img/edit.png', array('alt' => 'Editovať')), array('action' => 'edit', $import['Import']['id']), array('escape' => false)); ?>
			<?php echo $this->Form->postLink($this->Html->image('/img/deletered.png', array('alt' => 'Zmazať')), array('action' => 'delete', $import['Import']['id']), array('escape' => false), __('Ste si istý, že chcete zmazať tento výpis: %s?', $import['Import']['filename'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
		echo $this->Paginator->counter(array(
		'format' => __('Stránka {:page} z {:pages}, zobrazuje {:current} výpisov zo {:count} celkovo, začína na výpise {:start}, končí na výpise {:end}')
		));
		?>	
		</p>
		<div class="paging">
		<?php
			echo $this->Paginator->prev('< ' . __('naspäť'), array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next(__('ďalej') . ' >', array(), null, array('class' => 'next disabled'));
		?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Akcie'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Nový import'), array('action' => 'add')); ?></li>
	</ul>
</div>
