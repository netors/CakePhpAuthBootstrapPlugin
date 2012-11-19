<?php
	Router::connect('/admin/users', array('plugin'=>'auth_bootstrap', 'controller'=>'users', 'action'=>'index', 'admin'=>true));
	Router::connect('/admin/users/:action/*', array('plugin'=>'auth_bootstrap', 'controller'=>'users','admin'=>true));
	Router::connect('/users/forgot_password', array('plugin'=>'auth_bootstrap', 'controller'=>'users', 'action'=>'forgot_password', 'admin'=>false));
	Router::connect('/users/reset_password/*', array('plugin'=>'auth_bootstrap', 'controller'=>'users', 'action'=>'reset_password', 'admin'=>false));
	Router::connect('/users/logout', array('plugin'=>'auth_bootstrap', 'controller'=>'users', 'action'=>'logout', 'admin'=>false));
?>