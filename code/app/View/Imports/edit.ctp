<div class="imports form">
<?php echo $this->Form->create('Import'); ?>
	<fieldset>
		<legend><?php echo __('Editacia importu'); ?></legend>
	<?php
		echo $this->Form->input('date_from', array('label' => 'Dátum od'));
		echo $this->Form->input('date_to', array('label' => 'Dátum do'));
		echo $this->Form->input('xml_file');
		echo $this->Form->input('filename', array('label' => 'Názov súboru'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Upraviť')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Akcie'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Editovať import'), array('action' => 'edit', $import['Import']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Vymazať import'), array('action' => 'delete', $import['Import']['id']), null, __('Ste si istý, že chcete vymazať import # %s?', $import['Import']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Nový import'), array('action' => 'add')); ?> </li>
	</ul>
</div>
