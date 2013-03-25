<div class="transactions form">
<?php echo $this->Form->create('Transaction'); ?>
	<fieldset>
	
	<script>
		$(document).ready(function () {
			$("#datepicker").datepicker('setDate', new Date('<?php echo $data['Transaction']['post_date']; ?>'));   // nastavenie defaultneho datumu na aktualny
			
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
	
		<legend><?php echo __('Úprava transakcie'); ?></legend>
	<?php //print_r($data);
		echo $this->Form->input('id');
		echo $this->Form->input('transaction_type_id', array('options' => array('1' => 'príjem', '2' => 'výdavok'), 'selected' => $data['Transaction']['transaction_type_id'], 'type' => 'radio', 'id'=> 'transaction_type_id' , 'legend' => 'Typ transakcie' ));
		echo $this->Form->input('name', array('label' => 'Názov transakcie'));
		echo $this->Form->input('amount', array('label' => 'Suma'));
		echo $this->Form->input('category_id', array('options' => $categories, 'label' => 'Kategória', 'selected' => $data['Transaction']['category_id']));
		echo $this->Form->input('subcategory_id', array('options' => $subcategories, 'label' => 'Podkategória', 'selected' => $data['Transaction']['subcategory_id']));
		echo $this->Form->input('user_id', array('type' => 'hidden','value' => $user));
		//echo $this->Form->input('original_transaction_id');
		echo $this->Form->input('post_date', array('type' => 'text', 'id' => 'datepicker', 'label' => 'Dátum transakcie', 'default' => $data['Transaction']['post_date']));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Zmazať transakciu'), array('action' => 'delete', $this->Form->value('Transaction.id')), null, __('Ste si istý, že chcete zmazať túto transakciu: id # %s?', $this->Form->value('Transaction.id'))); ?></li>
		<li><?php echo $this->Form->postLink(__('Zmazať všetky ďalšie opakovania'), array('action' => 'delete_next_repeats', $this->Form->value('Transaction.id')), null, __('Ste si istý, že chcete zmazať túto transakciu a všetky jej ďalšie opakovania?: id # %s?', $this->Form->value('Transaction.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Transactions'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
