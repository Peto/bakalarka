<div class="transactions form">
<?php echo $this->Form->create('Transaction'); ?>
	<fieldset>
	
	<script>
		$(document).ready(function () {
			$("#datepicker").datepicker('setDate', new Date());   // nastavenie defaultneho datumu na aktualny
			
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
	
		<legend><?php echo __('Pridaj transakciu'); ?></legend>
	<?php
		echo $this->Form->input('transaction_type_id', array('options' => array('1' => 'príjem', '2' => 'výdavok'), 'selected' => '1', 'type' => 'radio', 'id'=> 'transaction_type_id' , 'legend' => 'Typ transakcie' ));
		echo $this->Form->input('name', array('label' => 'Názov transakcie'));
		echo $this->Form->input('amount', array('label' => 'Suma'));
		echo $this->Form->input('category_id', array('options' => $categories, 'label' => 'Kategória'));
		echo $this->Form->input('subcategory_id', array('options' => $subcategories, 'label' => 'Podkategória'));
		echo $this->Form->input('user_id', array('type' => 'hidden','value' => $user));
		//echo $this->Form->input('original_transaction_id');
		echo $this->Form->input('post_date', array('type' => 'text', 'id' => 'datepicker', 'label' => 'Dátum transakcie' ));?>
		<div id='opakovanie'>
		<?php echo $this->Form->input('repeat',
				array(
						'type' => 'radio',
						'options' => array('neopakovať', 'opakovať'),
						'id' => 'repeat',
						'legend' => 'Opakovanie transakcie')); ?> </div>
		<div id='opakovanie_nastavenia'>
		<?php echo $this->Form->input('repeat_every', 
				array(
						'type' => 'select', 
						'options' => array('tyzden' => 'tyždeň', 'mesiac' => 'mesiac', 'rok' => 'rok'), 
						'selected' => 'mesiac',
						'label' => 'Opakovať každý'
						
				)
		); 
		 echo $this->Form->input('number_of_cycles', array('label' => 'Počet opakovaní'));
		
		?></div>
		
	
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Transactions'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Categories'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Subcategories'), array('controller' => 'subcategories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subcategory'), array('controller' => 'subcategories', 'action' => 'add')); ?> </li>
	</ul>
</div>
