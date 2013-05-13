<div class="transactions form">
<?php echo $this->Form->create('Transaction'); ?>
	<fieldset>
	
	<script>
		$(document).ready(function () {
			$("#TransactionSubcategoryId").chained("#TransactionCategoryId");
			$("#datepicker").datepicker('setDate', new Date('<?php echo $data['Transaction']['post_date']; ?>'));   // nastavenie defaultneho datumu na aktualny
			
			$('#opakovanie_nastavenia').hide();
		    if ($('#Repeat0').attr('checked', true)) {
		        $('.opakovanie_nastavenia').hide();
		    }

		    $('#opakovanie').hide();
		    if ($('#UpdateNext0').attr('checked', true)) {
		        $('.opakovanie').hide();
		    }

		    $('#UpdateNext0').click(function () {
		        $('#opakovanie_nastavenia').slideUp("slow");
		    });

		    $('#UpdateNext1').click(function () {
		        $('#opakovanie_nastavenia').slideDown("slow");
		    })

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
// 		echo $this->Form->input('category_id', array('options' => $categories, 'label' => 'Kategória', 'selected' => $data['Transaction']['category_id']));
// 		echo $this->Form->input('subcategory_id', array('options' => $subcategories, 'label' => 'Podkategória', 'selected' => $data['Transaction']['subcategory_id']));
		?><select id="TransactionCategoryId" name="data[Transaction][category_id]">
		<option value="">Vyberte kategóriu</option>
		<?php foreach ($categories as $key => $row) {
			if ($data['Transaction']['category_id'] == $key){ 
			echo '<option selected value="'.$key.'" >'.$row.'</option>';
			}
			else { echo '<option value="'.$key.'" >'.$row.'</option>';}	}?>
				</select>
		<select id="TransactionSubcategoryId" name="data[Transaction][subcategory_id]">
		<option value="">Vyberte podkategóriu</option>
		<?php foreach ($subcategories as $row) {
			if ($data['Transaction']['subcategory_id'] == $row['Subcategory']['id']){
				echo '<option value="'.$row['Subcategory']['id'].'" selected class="'.$row['Subcategory']['category_id'].'">'.$row['Subcategory']['name'].'</option>';
			}
			else { echo '<option value="'.$row['Subcategory']['id'].'" class="'.$row['Subcategory']['category_id'].'">'.$row['Subcategory']['name'].'</option>';
			}
		}?>
		</select>
		<?php echo $this->Form->input('user_id', array('type' => 'hidden','value' => $user));
		echo $this->Form->input('original_transaction_id', array('type' => 'hidden'));
		echo $this->Form->input('post_date', array('type' => 'text', 'id' => 'datepicker', 'label' => 'Dátum transakcie', 'default' => $data['Transaction']['post_date']));?>
		
		<div id='upravit_dalsie'>
		<?php echo $this->Form->input('update_next',
				array(
						'type' => 'radio',
						'options' => array('upraviť iba toto opakovanie transakcie', 'upraviť aj ďalšie opakovania tejto transakcie(staršie opakovania nebudú upravené)'),
						'id' => 'update_next',
						'legend' => 'Úprava ďalších opakovaní'
					)
				); ?> </div>
		<div id='opakovanie'>
		<?php echo $this->Form->input('repeat',
				array(
						'type' => 'radio',
						'options' => array('neopakovať', 'opakovať'),
						'id' => 'repeat',
						'legend' => 'Opakovanie transakcie'
					)
				); ?> </div>
		<div id='opakovanie_nastavenia'>
		<?php echo $this->Form->input('repeat_every', 
				array(
						'type' => 'select', 
						'options' => array('tyzden' => 'tyždeň', 'mesiac' => 'mesiac', 'rok' => 'rok'), 
						'selected' => 'mesiac',
						'label' => 'Opakovať každý'
				)
			); 
			echo $this->Form->input('number_of_cycles', array('label' => 'Počet opakovaní','value' => '0'));
				
				?></div>
	</fieldset>
<?php echo $this->Form->end(__('Upraviť')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Akcie'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Zmazať transakciu'), array('action' => 'delete', $this->Form->value('Transaction.id')), null, __('Ste si istý, že chcete zmazať túto transakciu: id # %s?', $this->Form->value('Transaction.id'))); ?></li>
		<li><?php echo $this->Form->postLink(__('Zmazať všetky ďalšie opakovania'), array('action' => 'delete_next_repeats', $this->Form->value('Transaction.id')), null, __('Ste si istý, že chcete zmazať túto transakciu a všetky jej ďalšie opakovania?: id # %s?', $this->Form->value('Transaction.id'))); ?></li>
	</ul>
</div>
