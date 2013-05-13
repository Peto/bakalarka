<div class="categories view">
<h2><?php  echo __('Kategória'); ?> - <?php echo h($category['Category']['name']); ?></h2>

<script>
	
  $(function() {
    $( "#from" ).datepicker({
    
      changeMonth: true,
      numberOfMonths: 3,

      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });

    // getter
	var firstDay = $( "#from" ).datepicker( "option", "firstDay" );  
	 
	 
	// setter
	$( "#from" ).datepicker( "option", "firstDay", 1 );   // nastavenie zaciatocneho dna v tyzdni
    
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

    // getter
	var firstDay = $( "#to" ).datepicker( "option", "firstDay" );  
	 
	 
	// setter
	$( "#to" ).datepicker( "option", "firstDay", 1 );   // nastavenie zaciatocneho dna v tyzdni
  });
  </script>

	<div class="rozsah"> 
  <?php 
  	echo 'Rozsah zobrazených transakcií: '.date("d.m.Y", strtotime($from_date)).' - '.date("d.m.Y", strtotime($to_date));
  ?>
</div>
	  <div class="chart">
	<div id="columnwrapper" style="display: block; float: left; width:90%; margin-bottom: 20px;"></div>
    <div class="clear"></div>	
	
	<?php echo $this->HighCharts->render('Column Chart'); ?>

</div>
<div class="table_siroka">
<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('post_date','Dátum'); ?></th>
			<th><?php echo $this->Paginator->sort('name','Názov'); ?></th>
			<th><?php echo $this->Paginator->sort('amount','Suma'); ?></th>
			<th><?php echo $this->Paginator->sort('subcategory_id','Podkategória'); ?></th>
			<th class="actions"><?php echo __('Akcie'); ?></th>
	</tr>
	<?php foreach ($transactions as $transaction): ?>
	<tr>
		<td><?php echo h(CakeTime::format('d.m.Y',$transaction['Transaction']['post_date'])); ?>&nbsp;</td>
		<td><?php echo $this->Html->link($transaction['Transaction']['name'], array('controller' => 'transactions', 'action' => 'view', $transaction['Transaction']['id'])); ?>&nbsp;</td>
		<td class="left">
				<?php if ($transaction['Transaction']['transaction_type_id'] == 2){
					echo '-';
				}; ?>
				<?php echo h($transaction['Transaction']['amount']); ?> € &nbsp;
		</td>
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
</div>
<div class="actions">
	<h3><?php echo __('Prehľad'); ?></h3>
	<div class="left_box">
		<div class="small_box">
		<?php echo $this->Form->create('Filter'); 
		  echo $this->Form->input('from_date', array('type' => 'text', 'id' => 'from', 'label' => 'Od:', 'default' => $from_date ));
		  echo $this->Form->input('to_date', array('type' => 'text', 'id' => 'to', 'label' => 'Do:', 'default' => $to_date  ));
		  echo $this->Form->input('year_month_day', array('options' => array('1' => 'ročný', '2' => 'mesačný', '3' => 'denný'), 'value' => '2', 'type' => 'radio', 'id'=> 'year_month_day' , 'legend' => 'Rozdeliť na:' ));
		  echo $this->Form->end(__('Filtruj'));
		 ?>
		 </div>
	 </div>

	<ul>
		<li><?php echo $this->Html->link(__('Editovať kategóriu'), array('action' => 'edit', $category['Category']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Vymazať kategóriu'), array('action' => 'delete', $category['Category']['id']), null, __('Are you sure you want to delete # %s?', $category['Category']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Nová kategória'), array('action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Podkategórie patriace tejto kategórii:'); ?></h3>
	<?php if (!empty($category['Subcategory'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Názov'); ?></th>
		<th class="actions"><?php echo __('Akcie'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($category['Subcategory'] as $subcategory): ?>
		<tr>
			<td><?php echo $subcategory['id']; ?></td>
			<td><?php echo $this->Html->link($subcategory['name'], array('controller' => 'subcategories', 'action' => 'view', $subcategory['id'])); ?>&nbsp;</td>
			<td class="actions">
				<?php echo $this->Html->link($this->Html->image('/img/edit.png', array('alt' => 'Editovať')), array('action' => 'edit', $subcategory['id']), array('escape' => false)); ?>
				<?php echo $this->Form->postLink($this->Html->image('/img/deletered.png', array('alt' => 'Zmazať')), array('action' => 'delete', $subcategory['id']), array('escape' => false), __('Ste si istý, že chcete zmazať túto podkategóriu: id # %s?', $subcategory['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('Nová podkategória'), array('controller' => 'subcategories', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
