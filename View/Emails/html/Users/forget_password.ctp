<?php echo __('Forgot your password? No big deal.');?><br />
<?php echo __('To create a new password, just follow this link:');?><br />
<br />
<p style="font: 16px/18px Arial, Helvetica, sans-serif;">
	<b>
		<?php echo $this->Html->link('http://'.$_SERVER['SERVER_NAME'].Router::url('/').'users/reset_password/'.$user['User']['hash'].'/'.$user['User']['new_password_key'],'http://'.$_SERVER['SERVER_NAME'].Router::url('/').'users/reset_password/'.$user['User']['hash'].'/'.$user['User']['new_password_key']);?>
	</b>
</p>
<br />
<?php echo __('Link doesn\'t work? Copy the following link to your browser address bar:');?><br />
<nobr><?php echo 'http://'.$_SERVER['SERVER_NAME'].Router::url('/').'users/reset_password/'.$user['User']['hash'].'/'.$user['User']['new_password_key'];?></nobr>
<br />
<p><?php echo __('You are receiving this email, because it was requested by a ');?><?php echo $this->Html->link(Configure::read('App.name'),Configure::read('App.url'));?><?php echo __(' user. If you do not click on the link above, your password will remain the same.');?></p>
<br />
<?php echo __('Thank you,');?>
