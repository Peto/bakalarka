<div class="users form">
<h2><?php echo __('Obnovenie zabudnutého hesla'); ?></h2>

<?php echo $this->Form->create('User', array('action' => 'forgetpwd')); ?>
<?php echo $this->Form->input('email',array('style'=>'float:left'));?><br /><br />
<input type="submit" class="button" style="float:left;margin-left:3px;" value="Obnoviť" />
<?php echo $this->Form->end();?>

</div>