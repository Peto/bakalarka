<div class="subcategories index">
	<h2><?php echo __('Podkategórie'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name', 'Názov'); ?></th>
			<th><?php echo $this->Paginator->sort('category_id', 'Kategória'); ?></th>
			<th class="actions"><?php echo __('Akcie'); ?></th>
	</tr>
	<?php foreach ($subcategories as $subcategory): ?>
	<tr>
		<td><?php echo h($subcategory['Subcategory']['id']); ?>&nbsp;</td>
		<td><?php echo $this->Html->link($subcategory['Subcategory']['name'], array('action' => 'view', $subcategory['Subcategory']['id'])); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($subcategory['Category']['name'], array('controller' => 'categories', 'action' => 'view', $subcategory['Category']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Html->image('/img/edit.png', array('alt' => 'Editovať')), array('action' => 'edit', $subcategory['Subcategory']['id']), array('escape' => false)); ?>
			<?php echo $this->Form->postLink($this->Html->image('/img/deletered.png', array('alt' => 'Zmazať')), array('action' => 'delete', $subcategory['Subcategory']['id']), array('escape' => false), __('Ste si istý, že chcete zmazať túto kategóriu: id # %s?', $subcategory['Subcategory']['id'])); ?>
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
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Akcie'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Nová kategória'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Zoznam podkategórii'), array('controller' => 'subcategories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nová podkategória'), array('controller' => 'subcategories', 'action' => 'add')); ?> </li>
	</ul>
</div>
