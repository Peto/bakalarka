<script>
$(document).ready(function () {
<?php for ($i = 0; $i < count($parsed['content']); $i++ ) { ?>
	$("#TransactionSubcategoryId<?php echo $i; ?>").chained("#TransactionCategoryId<?php echo $i; ?>");
<?php } ?>
}); 
</script>
<div class="imports form">
<?php echo $this->Form->create('Transaction'); ?>
<fieldset>
<legend><?php echo __('Pridaj transakciu'); ?></legend>
		<?php $transaction_count = 0; 
			foreach ($parsed['content'] as $transakcia) {   // form pre kazdu transakciu
				 ?>
				<div class="input_polia"><?php echo $this->Form->input('Transaction.'.$transaction_count.'.name', array('default'=>$transakcia['detail'], 'label' => 'Názov transakcie:'));?></div>
				<?php echo $transakcia['post_date'] ?>
				<?php echo $transakcia['amount'] ?>
				<?php echo $transakcia['payment_type'] ?>
				<?php echo $this->Form->input('Transaction.'.$transaction_count.'.post_date', array('type' => 'hidden','value' => $transakcia['post_date']));?>
				<?php echo $this->Form->input('Transaction.'.$transaction_count.'.amount', array('type' => 'hidden','value' => $transakcia['amount']));?>
				<?php echo $this->Form->input('Transaction.'.$transaction_count.'.transaction_type_id', array('type' => 'hidden','value' => $transakcia['p_type_id']));?>
				<?php echo $this->Form->input('Transaction.'.$transaction_count.'.user_id', array('type' => 'hidden','value' => $user));?>
				
				<div><select id="TransactionCategoryId<?php echo $transaction_count; ?>" name="data[Transaction][<?php echo $transaction_count; ?>][category_id]">
				<option value="">Vyberte kategóriu</option>
				<?php foreach ($categories as $key => $row) {
					echo '<option value="'.$key.'" >'.$row.'</option>';
				}?>
				</select><?php echo $this->Html->link(__(' Nová kategória'), array('controller' => 'categories', 'action' => 'add')); ?></div>
				<div><select id="TransactionSubcategoryId<?php echo $transaction_count; ?>" name="data[Transaction][<?php echo $transaction_count; ?>][subcategory_id]">
				<option value="">Vyberte podkategóriu</option>
				<?php foreach ($subcategories as $row) {
					echo '<option value="'.$row['Subcategory']['id'].'" class="'.$row['Subcategory']['category_id'].'">'.$row['Subcategory']['name'].'</option>';
				}?>
				</select><?php echo $this->Html->link(__(' Nová podkategória'), array('controller' => 'subcategories', 'action' => 'add')); ?></div>
					
		<?php $transaction_count++; 
			}  ?>
		</fieldset>
		
<?php echo $this->Form->end(__('Pridať')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Akcie'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Zoznam importov'), array('action' => 'index')); ?></li>
	</ul>
</div>