<div class="categories view">
<h2><?php  echo __('Kategória'); ?></h2>

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

		
	<dl>
		
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($category['Category']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Názov'); ?></dt>
		<dd>
			<?php echo h($category['Category']['name']); ?>
			&nbsp;
		</dd>
	</dl>
	<?php 
  	echo 'Transakcie od: '.date("d.m.Y", strtotime($from_date));
	echo 'Transakcie do: '.date("d.m.Y", strtotime($to_date));
  ?>
	  <div class="chart">
	<div id="columnwrapper" style="display: block; float: left; width:90%; margin-bottom: 20px;"></div>
    <div class="clear"></div>	
	
	<?php echo $this->HighCharts->render('Column Chart'); ?>

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
			<td><?php echo $this->Html->link($subcategory['name'], array('action' => 'view', $subcategory['id'])); ?>&nbsp;</td>
			<td><?php echo $subcategory['name']; ?></td>
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
