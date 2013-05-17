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

$siteDescription = __d('cake_dev', 'MOBILE');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <title>
  	<?php echo $siteDescription ?>:
		<?php echo $title_for_layout; ?>
  </title>
  
  <?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('jquery-ui');
		echo $this->Html->css('mobile');
		echo $this->Html->css('jquery.mobile-1.3.1.min');
		
		echo $this->Html->script(array('jquery.min.js'));
		echo $this->Html->script(array('jquery.chained.js'));
		echo $this->Html->script(array('jquery-ui.js'));
		echo $this->Html->script(array('jquery.mobile-1.3.1.min.js'));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
   
</head>
<body>
<!-- Home -->
<div data-role="page" id="page1">
    <div data-theme="a" data-role="header">
        <h3>
            Domáce účtovníctvo
        </h3>
    </div>
    <div data-role="content">
    	<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
    </div>
    <div data-theme="a" data-role="footer" data-position="fixed">
	    <div data-role="navbar" data-iconpos="top">
	            <ul>
	                <li><?php echo $this->Html->link('Domov', '/', array('data-transition' => 'fade', 'data-icon' => 'home')); ?>
	                
	                </li>
	                <li>
	                    <?php echo $this->Html->link('Transakcie', '/transactions', array('data-transition' => 'fade', 'data-icon' => 'bars')); ?>
	                </li>
	                <li>
	                    <?php echo $this->Html->link('Pridanie transakcie', '/transactions/add', array('data-transition' => 'fade', 'data-icon' => 'plus')); ?>
	                </li>
	                <li>
	                    <?php echo $this->Html->link('Kategórie', '/transactions/category/', array('data-transition' => 'fade', 'data-icon' => 'grid')); ?>
	                </li>
	            </ul>
	        </div>
    <?= $this->element('default_footer') ?>
        <h4>
            <?php echo $this->Html->link(
				              'Odhlásiť sa',
				               array(
				                  'controller' => 'users',
				                  'action' => 'logout',
				                  'admin' => false
				               )); ?>
        </h4>
    </div>
</div>
</body>
</html>
