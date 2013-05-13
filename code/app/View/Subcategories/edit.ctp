<div class="subcategories form">
<?php echo $this->Form->create('Subcategory'); ?>
	<fieldset>
		<legend><?php echo __('Edituj podkategóriu'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name', array('label' => 'Názov podkategórie'));
		echo $this->Form->input('category_id', array('options' => $categories, 'label' => 'Kategória'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Upraviť')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Vymazať podkategóriu'), array('action' => 'delete', $this->Form->value('Subcategory.id')), null, __('Ste si istý, že chcete zmazať túto podkategóriu: id # %s?', $this->Form->value('Subcategory.id'))); ?></li>
		<li><?php echo $this->Html->link(__('Zoznam podkategórií'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Zoznam kategórií'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nová kategória'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
