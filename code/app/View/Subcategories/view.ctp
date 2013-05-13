<div class="subcategories view">
<h2><?php  echo __('Podkategória'); ?> - <?php echo h($subcategory['Subcategory']['name']); ?></h2>
	<dl>
		<dt><?php echo __('Názov'); ?></dt>
		<dd>
			<?php echo h($subcategory['Subcategory']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Kategória'); ?></dt>
		<dd>
			<?php echo $this->Html->link($subcategory['Category']['name'], array('controller' => 'categories', 'action' => 'view', $subcategory['Category']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Akcie'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Editovať podkategóriu'), array('action' => 'edit', $subcategory['Subcategory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Vymazať kategóriu'), array('action' => 'delete', $subcategory['Subcategory']['id']), null, __('Are you sure you want to delete # %s?', $subcategory['Subcategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Zoznam podkategórií'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nová podkategória'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Zoznam kategórií'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nová kategória'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Transakcie ktoré patria do tejto podkategórie'); ?></h3>
	<?php if (!empty($subcategory['Transaction'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Názov'); ?></th>
		<th><?php echo __('Suma'); ?></th>
		<th><?php echo __('Kategória'); ?></th>
		<th><?php echo __('Dátum'); ?></th>
		<th class="actions"><?php echo __('Akcie'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($subcategory['Transaction'] as $transaction): ?>
		<tr>
			<td><?php echo $this->Html->link($transaction['name'], array('controller' => 'transactions', 'action' => 'view', $transaction['id'])); ?>&nbsp;</td>
			<td><?php if ($transaction['transaction_type_id'] == 2){
					echo '-';
				}; ?><?php echo $transaction['amount']; ?></td>
			<td><?php echo $transaction['category_id']; ?></td>
			<td><?php echo CakeTime::format('d.m.Y', $transaction['post_date']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link($this->Html->image('/img/edit.png', array('alt' => 'Editovať')), array('controller' => 'transactions', 'action' => 'edit', $transaction['id']), array('escape' => false)); ?>
				<?php echo $this->Form->postLink($this->Html->image('/img/deletered.png', array('alt' => 'Zmazať')), array('controller' => 'transactions', 'action' => 'delete', $transaction['id']), array('escape' => false), __('Ste si istý, že chcete zmazať túto transakciu:  %s?', $transaction['name'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('Nová transakcia'), array('controller' => 'transactions', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
