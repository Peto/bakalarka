<div class="transactions view">
<h2><?php  echo __('Transakcia'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Transaction Type Id'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['transaction_type_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Amount'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category Id'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['category_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Subcategory Id'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['subcategory_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($transaction['User']['name'], array('controller' => 'users', 'action' => 'view', $transaction['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Original Transaction Id'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['original_transaction_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Post Date'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['post_date']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Prehľad'); ?></h3>
	<div class="left_box">
		<div class="small_box">
			<?php echo 'Aktuálny stav: '?>
			<div class="suma_box"> 
				<?php echo $aktualnystav .' €' ;?><br />
			</div>
		</div>
		<div class="small_box">
			<?php echo 'Plánované výdavky na najbližšie 3 mesiace: '?>
			<div class="suma_box"> 
				<?php echo $dalsistav .' €' ;?><br />
			</div>
		</div>
		<div class="small_box">
			<?php echo 'Príjmy za posledný mesiac: '?>
			<div class="suma_box"> 
				<?php echo $minulystav .' €' ;?><br />
			</div>
		</div>
		<div class="small_box">
			<?php echo 'Výdavky za posledný mesiac: '?>
			<div class="suma_box"> 
				<?php echo $minulystavexp .' €' ;?><br />
			</div>
		</div>
	</div>
	<ul>
		<li><?php echo $this->Html->link(__('Edituj transakciu'), array('action' => 'edit', $transaction['Transaction']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Zmazať transakciu'), array('action' => 'delete', $transaction['Transaction']['id']), null, __('Ste si istý, že chcete zmazať túto transakciu: id # %s?', $transaction['Transaction']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Zmazať všetky ďalšie opakovania'), array('action' => 'delete_next_repeats', $transaction['Transaction']['id']), null, __('Ste si istý, že chcete zmazať túto transakciu a všetky jej ďalšie opakovania?: id # %s?', $transaction['Transaction']['id'])); ?> </li>
	</ul>
</div>
