<div class="users index">
	<h2><?php echo __('Používateľ'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			<th><?php echo $this->Paginator->sort('name','Meno'); ?></th>
			<th><?php echo $this->Paginator->sort('surname','Priezvisko'); ?></th>
			<th><?php echo $this->Paginator->sort('active','Aktívny'); ?></th>
			<th><?php echo $this->Paginator->sort('user_type_id', 'Typ používateľa'); ?></th>
			<th class="actions"><?php echo __('Akcie');  ?></th>
	</tr>
	<?php foreach ($users as $user): ?>
	<tr>
		<td><?php echo h($user['User']['id']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['name']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['surname']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['active']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['user_type_id']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Html->image('/img/edit.png', array('alt' => 'Editovať')), array('action' => 'edit', $user['User']['id']), array('escape' => false)); ?>
			<?php echo $this->Form->postLink($this->Html->image('/img/deletered.png', array('alt' => 'Zmazať')), array('action' => 'delete', $user['User']['id']), array('escape' => false), __('Ste si istý, že chcete zmazať tohoto používateľa: %s?', $user['User']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
		echo $this->Paginator->counter(array(
		'format' => __('Stránka {:page} z {:pages}, zobrazuje {:current} používateľov zo {:count} celkovo, začína na používateľovi {:start}, končí na používateľovi {:end}')
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



