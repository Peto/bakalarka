<div class="transactionTypes view">
<h2><?php  echo __('Transaction Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($transactionType['TransactionType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($transactionType['TransactionType']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Transaction Type'), array('action' => 'edit', $transactionType['TransactionType']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Transaction Type'), array('action' => 'delete', $transactionType['TransactionType']['id']), null, __('Are you sure you want to delete # %s?', $transactionType['TransactionType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Transaction Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Transaction Type'), array('action' => 'add')); ?> </li>
	</ul>
</div>
