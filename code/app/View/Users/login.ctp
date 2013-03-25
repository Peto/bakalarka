<?php
     echo $this->Form->create();
     echo $this->Form->inputs(
         array(
             'email',
             'password'
         )
     );
     echo $this->Form->end('Submit');
     echo $this->Html->link('Ešte nemáte vytvorený účet? Zaregistrujte sa.', array(
         'controller' => 'users',
         'action' => 'add'
     ));
?>
