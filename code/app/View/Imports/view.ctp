<div class="imports view">
<h2><?php  echo __('Import'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($import['Import']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dátum od'); ?></dt>
		<dd>
			<?php echo h($import['Import']['date_from']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dátum do'); ?></dt>
		<dd>
			<?php echo h($import['Import']['date_to']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Názov súboru'); ?></dt>
		<dd>
			<?php echo h($import['Import']['filename']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Akcie'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Editovať import'), array('action' => 'edit', $import['Import']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Vymazať import'), array('action' => 'delete', $import['Import']['id']), null, __('Vymazať import # %s?', $import['Import']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Nový import'), array('action' => 'add')); ?> </li>
	</ul>
</div>
