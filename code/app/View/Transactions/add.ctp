<div class="transactions form">
<?php echo $this->Form->create('Transaction'); ?>
	<fieldset>
	
	<script>
		$(document).ready(function () {
			$('#opakovanie_nastavenia').hide();
		    if ($('#Repeat0').attr('checked', true)) {
		        $('.opakovanie_nastavenia').hide();
		    }

		    $('#Repeat0').click(function () {
		        $('#opakovanie_nastavenia').slideUp("slow");
		    });

		    $('#Repeat1').click(function () {
		        $('#opakovanie_nastavenia').slideDown("slow");
		    });
		});
		</script>
	
		<legend><?php echo __('Add Transaction'); ?></legend>
	<?php
		echo $this->Form->input('transaction_type_id', array('options' => $transaction_types));
		echo $this->Form->input('name');
		echo $this->Form->input('amount');
		echo $this->Form->input('category_id', array('options' => $categories));
		echo $this->Form->input('subcategory_id', array('options' => $subcategories));
		echo $this->Form->input('user_id', array('type' => 'hidden','value' => $user));
		//echo $this->Form->input('original_transaction_id');
		echo $this->Form->input('post_date', array('type' => 'text', 'id' => 'datepicker' ));?>
		<div id='opakovanie'>
		<?php echo $this->Form->input('repeat',
				array(
						'type' => 'radio',
						'options' => array('neopakovať', 'opakovať'),
						'id' => 'repeat')); ?> </div>
		<div id='opakovanie_nastavenia'>
		<?php echo $this->Form->input('repeat_every', 
				array(
						'type' => 'select', 
						'options' => array('tyzden' => 'tyždeň', 'mesiac' => 'mesiac', 'rok' => 'rok'), 
						'selected' => 'mesiac'
						
				)
		); 
		 echo $this->Form->input('number_of_cycles',
				array(
						//'empty' => 'Select...',
						'type' => 'select',
						'options' => array_combine(range(1,100,1),range(1,100,1))
				)
		);
		
		?></div>
		
	
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Transactions'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
