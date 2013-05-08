<div class="transactions index">
	<h2><?php echo __('Transakcie - dátum'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('post_date','Dátum'); ?></th>
			<th><?php echo $this->Paginator->sort('transaction_type_id', 'Typ transakcie'); ?></th>
			<th><?php echo $this->Paginator->sort('name','Názov'); ?></th>
			<th><?php echo $this->Paginator->sort('amount','Suma'); ?></th>
			<th><?php echo $this->Paginator->sort('category_id','Kategória'); ?></th>
			<th><?php echo $this->Paginator->sort('subcategory_id','Subkategória'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id','ID používateľa'); ?></th>
			<th><?php echo $this->Paginator->sort('original_transaction_id','ID hlavnej transakcie'); ?></th>
			<th class="actions"><?php echo __('Akcie'); ?></th>
	</tr>
	<?php foreach ($transactions as $transaction): ?>
	<tr>
		<td><?php echo h($transaction['Transaction']['id']); ?>&nbsp;</td>
		<td><?php echo h(CakeTime::format('d.m.Y',$transaction['Transaction']['post_date'])); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['transaction_type_id']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['name']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['amount']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['category_id']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['subcategory_id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($transaction['User']['name'], array('controller' => 'users', 'action' => 'view', $transaction['User']['id'])); ?>
		</td>
		<td><?php echo h($transaction['Transaction']['original_transaction_id']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Zobraziť'), array('action' => 'view', $transaction['Transaction']['id'])); ?>
			<?php echo $this->Html->link(__('Upraviť'), array('action' => 'edit', $transaction['Transaction']['id'])); ?>
			<?php echo $this->Form->postLink(__('Zmazať'), array('action' => 'delete', $transaction['Transaction']['id']), null, __('Ste si istý, že chcete zmazať túto transakciu: id # %s?', $transaction['Transaction']['id'])); ?>
			<?php echo $this->Form->postLink(__('Zmazať všetky ďalšie'), array('action' => 'delete_next_repeats', $transaction['Transaction']['id']), null, __('Ste si istý, že chcete zmazať túto transakciu a všetky jej ďalšie opakovania?: id # %s?', $transaction['Transaction']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Stránka {:page} z {:pages}, zobrazuje {:current} záznamov zo {:count} celkovo, začína na zázname {:start}, končí na zázname {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('naspäť'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('ďalej') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Transaction'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Subcategories'), array('controller' => 'subcategories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subcategory'), array('controller' => 'subcategories', 'action' => 'add')); ?> </li>
	</ul>
</div>
