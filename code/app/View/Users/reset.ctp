<div class="users form">
<h2><?php echo __('Zmena hesla'); ?></h2>

<?php //echo $this->Form->create('User', array('action' => 'reset')); ?>
 
<?php
if(isset($errors)){
echo '<div class="error">';
echo "<ul>";
foreach($errors as $error){
 echo"<li><div class='error-message'>$error</div></li>";
}
echo"</ul>";
echo'</div>';
}
?>
 
<form method="post">
<?php
echo $this->Form->input('password',array("type"=>"password","name"=>"data[User][password]", 'label' => 'Nové heslo:'));
echo $this->Form->input('password_confirm',array("type"=>"password","name"=>"data[User][password_confirm]", 'label' => 'Potvrdenie nového hesla:'));
?>

<input type="submit" class="button" style="float:left;margin-left:3px;" value="Zmeniť" />
 
<?php //echo $this->Form->end();?>
</form>
</div>
