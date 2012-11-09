<?php
	Router::connect('/admin/users', array('plugin'=>'auth_bootstrap', 'controller'=>'users', 'action'=>'index', 'admin'=>true));
	Router::connect('/admin/users/:action/*', array('plugin'=>'auth_bootstrap', 'controller'=>'users','admin'=>true));
?>