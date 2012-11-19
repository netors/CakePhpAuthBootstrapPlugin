<?php
App::uses('AppController', 'Controller');
/**
 * AuthBootstrap Controller
 *
 * @property AuthBootstrap $AuthBootstrap
 */
class AuthBootstrapAppController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array(
        'Acl',
        'Auth' => array(
            'authorize' => array(
                'Actions' => array(
                    'userModel' => 'User',
                    'actionPath' => 'controllers'
                )
            ),
        ),
        'RequestHandler',
        'Session',
    );

    /**
     * Helpers
     *
     * @var array
     */
    public $helpers = array(
        'Html',
        'Form',
        'Time',
        'Number',
        'TwitterBootstrapCakeBake.BootstrapIcon',
        'Session',
        'TwitterBootstrap.BootstrapForm',
        'TwitterBootstrap.BootstrapHtml',
        'TwitterBootstrap.BootstrapPaginator',
    );

}