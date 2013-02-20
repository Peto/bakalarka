<div class="userTypes view">
<h2><?php  echo __('User Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($userType['UserType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($userType['UserType']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User Type'), array('action' => 'edit', $userType['UserType']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User Type'), array('action' => 'delete', $userType['UserType']['id']), null, __('Are you sure you want to delete # %s?', $userType['UserType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List User Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Type'), array('action' => 'add')); ?> </li>
	</ul>
</div>
