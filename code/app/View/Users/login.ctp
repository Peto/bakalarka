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

<?php
echo $this->Session->check('Auth.User') 
 ? 
$this->Html->link(
              'Odhlásiť sa',
               array(
                  'controller' => 'users',
                  'action' => 'logout',
                  'admin' => false
               ))
: 
$this->Html->link(
               'Prihlásiť sa',
                array(
                   'controller' => 'users',
                   'action' => 'login'
                ));
?>