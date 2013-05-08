<div class="categories form">
<?php echo $this->Form->create('Category'); ?>
	<fieldset>
		<legend><?php echo __('Pridanie kategórie'); ?></legend>
	
		<div class="input_polia"><?php echo $this->Form->input('name', array('label' => 'Názov kategórie:'));?></div>
		<?php echo $this->Form->input('user_id', array('type' => 'hidden','value' => $user));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Uložiť')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Akcie'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Zoznam kategórií'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Zoznam podkategórií'), array('controller' => 'subcategories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nová podkategória'), array('controller' => 'subcategories', 'action' => 'add')); ?> </li>
	</ul>
</div>
