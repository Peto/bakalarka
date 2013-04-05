<?php
     echo $this->Form->create();
     echo $this->Form->input('email', array('label' => 'E-mail'));
     echo $this->Form->input('password', array('label' => 'Heslo'));?>
     
     <div id='login_submit'> <?php echo $this->Form->submit(__('Prihlásiť sa'), array('class' => 'login_submit')); ?> </div>
     <?php
     echo $this->Form->end();?>
     <div id='zaregistrujte_sa'>
     <?php echo $this->Html->link('Ešte nemáte vytvorený účet? Zaregistrujte sa.', array(
         'controller' => 'users',
         'action' => 'add',
     	 
     ));
     ?>
	 </div>
<?php
?>