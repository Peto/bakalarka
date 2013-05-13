<div class="categories form">
<?php echo $this->Form->create('Category'); ?>
	<fieldset>
		<legend><?php echo __('Edituj kategóriu'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name', array('label' => 'Názov kategórie'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Upraviť')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Akcie'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Vymazať kategóriu'), array('action' => 'delete', $this->Form->value('Category.id')), null, __('Ste si istý, že chcete zmazať túto kategóriu: id # %s?', $this->Form->value('Category.id'))); ?></li>
		<li><?php echo $this->Html->link(__('Zoznam podkategórií'), array('controller' => 'subcategories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nová podkategória'), array('controller' => 'subcategories', 'action' => 'add')); ?> </li>
	</ul>
</div>
