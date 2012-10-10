<?php
    Router::connect('/admin', array('plugin'=>'auth_bootstrap','controller' => 'users', 'action' => 'home','admin'=>true));