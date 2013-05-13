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

$siteDescription = __d('cake_dev', 'Login: Domáce účtovníctvo');
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
		echo $this->Html->css('mobile');
		echo $this->Html->css('jquery.mobile-1.3.1.min');
		
		echo $this->Html->script(array('jquery.min.js'));
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
    <?= $this->element('default_footer') ?>
        
    </div>
</div>
</body>
</html>