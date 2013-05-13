<div class="transactions view">
<h2><?php  echo __('Transakcia'); ?></h2>
	<dl>
		<dt><?php echo __('Id transakcie'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Typ transakcie'); ?></dt>
		<dd>
			<?php if ($transaction['Transaction']['transaction_type_id'] == 2){
					echo 'výdavok';}
					else {echo 'príjem';}
				 ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Názov transakcie'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Suma'); ?></dt>
		<dd>
			<?php if ($transaction['Transaction']['transaction_type_id'] == 2){
					echo '-';
				}; ?>
				<?php echo h($transaction['Transaction']['amount']); ?> € &nbsp
		</dd>
		<dt><?php echo __('Kategória'); ?></dt>
		<dd>
			<?php echo $this->Html->link($transaction['Category']['name'], array('controller' => 'categories', 'action' => 'view', $transaction['Category']['id'])); ?>&nbsp;
		</dd>
		<dt><?php echo __('Podkategória'); ?></dt>
		<dd>
			<?php echo $this->Html->link($transaction['Subcategory']['name'], array('controller' => 'subcategories', 'action' => 'view', $transaction['Subcategory']['id'])); ?>&nbsp;
		</dd>
		<dt><?php echo __('Dátum transakcie'); ?></dt>
		<dd>
			<?php echo h(CakeTime::format('d.m.Y',$transaction['Transaction']['post_date'])); ?>&nbsp;
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
			<?php echo 'Plánovaný stav o 3 mesiace: '?>
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
		<li><?php echo $this->Form->postLink(__('Zmazať transakciu'), array('action' => 'delete', $transaction['Transaction']['id']), null, __('Ste si istý, že chcete zmazať túto transakciu: %s?', $transaction['Transaction']['name'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Zmazať všetky ďalšie opakovania'), array('action' => 'delete_next_repeats', $transaction['Transaction']['id']), null, __('Ste si istý, že chcete zmazať túto transakciu a všetky jej ďalšie opakovania?: %s?', $transaction['Transaction']['name'])); ?> </li>
	</ul>
</div>
