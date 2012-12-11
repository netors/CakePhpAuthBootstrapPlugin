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
 * @package       Cake.View.Layouts.Emails.text
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<?php echo $content_for_layout;?>

The <?php echo Configure::read('App.name');?> Team

<?php echo Configure::read('Company.address_number').' '.Configure::read('Company.address_street').', '.Configure::read('Company.address_suit');?>
<?php echo Configure::read('Company.city').', '.Configure::read('Company.state_zip');?>

This email was sent using the <?php echo Configure::read('App.name');?> App, <?php echo Configure::write('App.url');?>
