<div class="transactions index">
	<h2><?php echo __('Transakcie'); ?></h2>
	
	
	<script>
	
  $(function() {
    $( "#from" ).datepicker({
    
      changeMonth: true,
      numberOfMonths: 3,

      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $("#from").datepicker('setDate', new Date('<?php echo $from_date; ?>'));
    $( "#from" ).datepicker( "option", "dateFormat", 'yy-mm-dd' );
    $( "#to" ).datepicker({
     
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
    $("#to").datepicker('setDate', new Date('<?php echo $to_date; ?>'));
    $( "#to" ).datepicker( "option", "dateFormat", 'yy-mm-dd' );
  });
  </script>
  
  <?php 
  	echo 'Transakcie od: '.date("d.m.Y", strtotime($from_date));
	echo 'Transakcie do: '.date("d.m.Y", strtotime($to_date));
  ?>
	
<div class="chart">
	<div id="columnwrapper" style="display: block; float: left; width:90%; margin-bottom: 20px;"></div>
    <div class="clear"></div>	
	
	<?php echo $this->HighCharts->render('Column Chart'); ?>

</div>

	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('post_date','Dátum'); ?></th>
			<th><?php echo $this->Paginator->sort('name','Názov'); ?></th>
			<th><?php echo $this->Paginator->sort('amount','Suma'); ?></th>
			<th><?php echo $this->Paginator->sort('category_id','Kategória'); ?></th>
			<th><?php echo $this->Paginator->sort('subcategory_id','Subkategória'); ?></th>
			<th class="actions"><?php echo __('Akcie'); ?></th>
	</tr>
	<?php foreach ($transactions as $transaction): ?>
	<tr>
		<td><?php echo h($transaction['Transaction']['id']); ?>&nbsp;</td>
		<td><?php echo h(CakeTime::format('d.m.Y',$transaction['Transaction']['post_date'])); ?>&nbsp;</td>
		<td><?php echo $this->Html->link($transaction['Transaction']['name'], array('action' => 'view', $transaction['Transaction']['id'])); ?>&nbsp;</td>
		<td class="left">
				<?php if ($transaction['Transaction']['transaction_type_id'] == 2){
					echo '-';
				}; ?>
				<?php echo h($transaction['Transaction']['amount']); ?> € &nbsp;
		</td>
		<td><?php echo $this->Html->link($transaction['Category']['name'], array('controller' => 'categories', 'action' => 'view', $transaction['Category']['id'])); ?>&nbsp;</td>
		<td><?php echo $this->Html->link($transaction['Subcategory']['name'], array('controller' => 'subcategories', 'action' => 'view', $transaction['Subcategory']['id'])); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Html->image('/img/edit.png', array('alt' => 'Editovať')), array('action' => 'edit', $transaction['Transaction']['id']), array('escape' => false)); ?>
			<?php echo $this->Form->postLink($this->Html->image('/img/deletered.png', array('alt' => 'Zmazať')), array('action' => 'delete', $transaction['Transaction']['id']), array('escape' => false), __('Ste si istý, že chcete zmazať túto transakciu: id # %s?', $transaction['Transaction']['id'])); ?>
			<?php echo $this->Form->postLink($this->Html->image('/img/deleteall.png', array('alt' => 'Zmazať aktuálnu a všetky ďalšie')), array('action' => 'delete_next_repeats', $transaction['Transaction']['id']), array('escape' => false), __('Ste si istý, že chcete zmazať túto transakciu a všetky jej ďalšie opakovania?: id # %s?', $transaction['Transaction']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Stránka {:page} z {:pages}, zobrazuje {:current} záznamov zo {:count} celkovo, začína na zázname {:start}, končí na zázname {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('naspäť'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('ďalej') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Prehľad'); ?></h3>
	<?php echo $this->Form->create('Filter'); 
	  echo $this->Form->input('from_date', array('type' => 'text', 'id' => 'from', 'label' => 'Od:', 'default' => $from_date ));
	  echo $this->Form->input('to_date', array('type' => 'text', 'id' => 'to', 'label' => 'Do:', 'default' => $to_date  ));
	  echo $this->Form->input('year_month_day', array('options' => array('1' => 'ročný', '2' => 'mesačný', '3' => 'denný'), 'value' => '2', 'type' => 'radio', 'id'=> 'year_month_day' , 'legend' => 'Rozdeliť na:' ));
	  echo $this->Form->end(__('Filtruj'));
	 ?>
	<ul>
		<li><?php echo $this->Html->link(__('Nová transakcia'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Zobraz kategórie'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Zobraz subkategórie'), array('controller' => 'subcategories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nová kategória'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Nová subkategória'), array('controller' => 'subcategories', 'action' => 'add')); ?> </li>
	</ul>
</div>
