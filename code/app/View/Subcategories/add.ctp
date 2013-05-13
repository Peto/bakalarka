<div class="subcategories form">
<?php echo $this->Form->create('Podkategória'); ?> 
	<fieldset>
		<legend><?php echo __('Pridanie podkategórie'); ?></legend>
	<?php
		echo $this->Form->input('name', array('label' => 'Názov podkategórie:'));
		echo $this->Form->input('category_id', array('options' => $categories, 'label' => 'Kategória'));
		echo $this->Form->input('user_id', array('type' => 'hidden','value' => $user));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Pridať')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Akcie'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Zoznam podkategórií'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Zoznam kategórií'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nová kategória'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
