<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts.Emails.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title><?php echo $title; ?></title></head>
	<body>
		<div style="max-width: 800px; margin: 0; padding: 30px 0;">
			<table width="80%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="5%"></td>
					<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
						<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;"><?php echo $title; ?></h2>
						<?php echo $content_for_layout;?>
						<br/> 
						The <?php echo Configure::read('App.name');?> Team
						<br /> 
						<?php echo $this->Html->image(Configure::read('App.url').'/images/locbit_small.png',array('url'=>'/'));?>
						<br />
						<?php echo $this->Html->link(Configure::read('App.url'),Configure::read('App.url'));?>
						<br /><br/>
						<?php echo Configure::read('Company.address_number').' '.Configure::read('Company.address_street').', '.Configure::read('Company.address_suit');?><br />
						<?php echo Configure::read('Company.city').', '.Configure::read('Company.state_zip');?><br />
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>