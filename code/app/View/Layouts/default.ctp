<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$siteDescription = __d('cake_dev', 'Domáce účtovníctvo');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $siteDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('jquery-ui');
		echo $this->Html->css('cake.generic');
		
		echo $this->Html->script(array('jquery.min.js'));
		echo $this->Html->script(array('jquery.chained.js'));
		echo $this->Html->script(array('jquery-ui.js'));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
<!-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> -->


<script>
$(function() {
$( "#datepicker" ).datepicker();
$( "#datepicker" ).datepicker( "option", "dateFormat", 'yy-mm-dd' );
});
</script>

</head>
<body>
	<div id="container">
		<div id="header">
		<ul>
			<li><h1><?php echo $this->Html->link('Domov', '/'); ?></h1></li>
			<li><h1><?php echo $this->Html->link('Transakcie', '/transactions'); ?></h1></li>
			<li><h1><?php echo $this->Html->link('Pridanie transakcie', '/transactions/add'); ?></h1></li>
			<li><h1><?php echo $this->Html->link('Kategórie', '/transactions/category/'); ?></h1></li>
			<li><h1><?php echo $this->Html->link('Import', '/imports'); ?></h1></li>
			<li><h1><?php
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
				?></h1></li>
		</ul>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
		<?= $this->element('default_footer') ?>
			
		</div>
	</div>
</body>
</html>
