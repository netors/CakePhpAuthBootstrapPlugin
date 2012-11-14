<?php
App::uses('AuthBootstrapAppController', 'AuthBootstrap.Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AuthBootstrapAppController {

    /**
     * Models
     *
     * @var array
     */

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Filter.Filter','Email');

    /**
     * Helpers
     *
     * @var array
     */
    public $helpers = array('Filter.Filter');

    /**
     * Filters
     *
     * @var array
     */
    public $filters = array(
		'admin_index' => array(
			'User' => array(
                'User.name' => array(
                    'label' => 'Name'
                ),
                'User.lastname' => array(
                    'label' => 'Lastname'
                ),
                'User.username' => array(
                    'label' => 'Username'
                ),
                'User.email' => array(
                    'label' => 'Email'
                ),
                'User.role_id' => array(
                    'type' => 'select',
                    'label' => 'Role',
                    'selector' => 'getRoleList'
                ),
			)
		),
	);

    /**
     * beforeFilter
     */
    public function beforeFilter() {
    	//debug($this->Session->read('Auth'));
    	
		parent::beforeFilter();
		$this->Auth->allow('admin_login','login','logout','admin_add','forget_password','reset_password');
	}

    /**
     * home method
     *
     * @return void
     */
    public function admin_home()  {
        switch ($this->Session->read('Auth.User.role_id')) {
            case Configure::read('Role.master'):
                break;
            case Configure::read('Role.admin'):
            case Configure::read('Role.user'):
                break;
            default:
                $this->redirect(array('action'=>'login'));
                throw new MethodNotAllowedException();
                break;
        }
    }

    /**
     * profile method
     *
     * @return void
     */
    public function admin_profile()  {
        $id = $this->Session->read('Auth.User.id');
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid admin'));
        }
        $this->set('admin', $this->User->read(null, $id));
    }

	/**
	 * index method
	 *
	 * @return void
	 */
	public function admin_index() {
        $this->paginate = array(
            'User' => array(
                'contain' => array('Role'),
            )
        );
        $users = $this->paginate('User');
		$this->set(compact('users'));
	}

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
	public function admin_view($id = null) {
		$this->User->recursive = 2;
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add($role_id = null) {
		if ($this->request->is('post')) {
			$this->request->data['User']['is_active'] = 1;
            if ($this->request->data['User']['role_id']==Configure::read('Role.master')) unset($this->request->data['User']['role_id']);
            $this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'),'Flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'),'Flash/error');
			}
        } else {
            $this->request->data['User']['role_id'] = $role_id;
        }
		$roles = $this->User->Role->find('list',array('conditions'=>array('id !='=>Configure::read('Role.master'))));
		$this->set(compact('roles'));
	}


    /**
     * admin_edit method
     *
     * @param string $id
     * @return void
     */
	public function admin_edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'),'Flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'),'Flash/error');
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
        $roles = $this->User->Role->find('list',array('conditions'=>array('id !='=>Configure::read('Role.master'))));
        $this->set(compact('roles'));
	}

    /**
     * delete method
     *
     * @param string $id
     * @return void
     *
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'),'Flash/success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted'),'Flash/error');
		$this->redirect(array('action' => 'index'));
	}
     */
    /**
     * admin_deactivate method
     *
     * @param string $id
     * @return void
     */
	public function admin_deactivate($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->updateAll(array('is_active'=>0),array('User.id'=>$id))) {
			$this->Session->setFlash(__('User deactivated'),'Flash/success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deactivated'),'Flash/error');
		$this->redirect(array('action' => 'index'));
	}

    /**
     * admin_activate method
     *
     * @param string $id
     * @return void
     */
	public function admin_activate($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->updateAll(array('is_active'=>1),array('User.id'=>$id))) {
			$this->Session->setFlash(__('User activated'),'Flash/success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not activated'),'Flash/error');
		$this->redirect(array('action' => 'index'));
	}

	/**
	 * admin_login method
	 *
	 * @return void
	 */
	public function admin_login() {
		if ($this->Session->read('Auth.User')) {
			$this->Session->setFlash(__('You are logged in!'),'Flash/info');
			$this->redirect('/', null, false);
		}
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
                if ($this->Session->read('Auth.User.is_active')) {
                    $this->redirect($this->Auth->redirect());
                } else {
                    $this->Session->setFlash(__('This account is inactive. Contact your administrator.'),'Flash/error');
                    $this->redirect($this->Auth->logout());
                }
			} else {
				$this->Session->setFlash(__('Your username or password was incorrect.'),'Flash/error');
			}
		}
	}

	/**
	 * admin_logout method
	 *
	 * @return void
	 */
	public function admin_logout() {
		$this->Session->setFlash(__('Good bye!'),'Flash/info');
		$this->redirect($this->Auth->logout());
	}

	/**
     * logout method
     *
     * @return void
     */
	public function logout() {
		$this->Session->setFlash(__('Good bye!'),'Flash/info');
		$this->redirect($this->Auth->logout());
	}
	
	/**
     * admin_forget_password method
     *
     * @return void
     */
	public function forget_password() {
		if($this->Session->read('Auth')){
			$this->Session->setFlash(__('You have already login!'),'Flash/error');
			$this->redirect(array('plugin'=>null,'controller'=>'pages','action'=>'home','admin'=>false));
		}
		if ($this->request->is('post')) {
			$this->User->recursive = -1;
			$conditions = array('User.email'=>$this->data['User']['email']);
			$result = $this->User->find('first',compact('conditions'));
			if(!$result) {
				$this->Session->setFlash(__('The email is not existed. Please try again'),'Flash/error');
				return;
			}
			$new_password_key = Security::hash(time(),'md5');
			$this->User->updateAll(
					array('new_password_requested'=>'NOW()',
						  'new_password_key'	  =>'"'.$new_password_key.'"'
						  ), array('User.id'=>$result['User']['id']));
			$email = new CakeEmail('smtp');
			$email->to($result['User']['email']);
	        $email->subject(__('Forgot Password from Locbit'));
	        $email->template('users/forget_password', 'default');
	        $email->helpers('Time','Html');
			$email->theme('locbit');
	        $email->viewVars(
	            array(
	                'title'	 		=> 'Forgot Password from Locbit',
	                'userhash'		=> $result['User']['hash'],
	                'password_key'	=> $new_password_key
	            )
	        );
	        $email->send();
			$this->Session->setFlash(__('The email has been sent'),'Flash/success');
			$this->redirect(array('plugin'=>null,'controller'=>'pages','action'=>'home','admin'=>false));
		}
	}

	/**
     * reset_password method
     *
     * @return void
     */
	public function reset_password($userhash,$password_key) {
		$this->User->recursive = -1;
		if($this->Session->read('Auth')){
			$this->Session->setFlash(__('You have already login!'),'Flash/error');
			$this->redirect(array('plugin'=>null,'controller'=>'pages','action'=>'home','admin'=>false));
		}
		$conditions = array('User.hash'=>$userhash,'User.new_password_key'=>$password_key,'NOW() - User.new_password_requested <='=>Configure::read('Email.expiration_time'));
		$result = $this->User->find('first',compact('conditions'));
		if(!$result) {
			$this->Session->setFlash(__('The link is not valid or expired. Please make sure the URL is correct.'),'Flash/error');
			return;
		}
		if ($this->request->is('post')) {
			$this->User->recursive = -1;
			if($this->data['User']['new_password'] === $this->data['User']['repeat_password']){
				if ($result['User']['is_active']) {
					$this->User->id = $result['User']['id'];
					$data = array(
							'User' => array(
								'password'				=> $this->data['User']['new_password'],
								'new_password_key'		=> NULL,
								'new_password_requested'=> NULL,
							));
					if($this->User->save($data)){
						$this->Session->setFlash(__('New Password has been saved.'),'Flash/success');
						$this->redirect(array('plugin'=>null,'controller'=>'pages','action'=>'home','admin'=>false));
					}else{
						$this->Session->setFlash(__('There is problem of saving password.'),'Flash/error');
					}
                } else {
                    $this->Session->setFlash(__('This account is inactive. Contact your administrator.'),'Flash/error');
                    $this->redirect($this->Auth->logout());
                }
			}
			else{
				$this->Session->setFlash(__('Make sure the repeat password is matched new password.'),'Flash/error');
			}
		}
	}

    /**
     * change_password method
     *
     * @return void
     */
    public function change_password() {
        // @todo: to be implemented
        // @todo: ask for new password twice
        if ($this->request->is('post')) {
			$this->User->recursive = -1;
			if($this->data['User']['new_password'] === $this->data['User']['repeat_password']){
				if ($this->Session->read('Auth.User.is_active')) {
					$this->User->id = $this->Session->read('Auth.User.id');
					$data = array(
							'User' => array(
								'password'	=> $this->data['User']['new_password'],
							));
					if($this->User->save($data)){
						$this->Session->setFlash(__('New Password has been saved.'),'Flash/success');
					}else{
						$this->Session->setFlash(__('There is problem of saving password.'),'Flash/error');
					}
                } else {
                    $this->Session->setFlash(__('This account is inactive. Contact your administrator.'),'Flash/error');
                    $this->redirect($this->Auth->logout());
                }
			}
			else{
				$this->Session->setFlash(__('Make sure the repeat password is matched new password.'),'Flash/error');
			}
		}
    }
}
