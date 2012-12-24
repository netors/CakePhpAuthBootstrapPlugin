<?php echo __('Forgot your password? No big deal.');?>
<?php echo __('To create a new password, just follow this link:');?>

<?php echo 'http://'.$_SERVER['SERVER_NAME'].Router::url('/').'users/reset_password/'.$user['User']['hash'].'/'.$user['User']['new_password_key'];?>
