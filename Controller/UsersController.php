<?php
App::uses('AuthBootstrapAppController', 'AuthBootstrap.Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AuthBootstrapAppController {

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
		parent::beforeFilter();
		$this->Auth->allow('admin_login','login','logout','forget_password','reset_password','register');
	}

    /**
     * home method
     *
     * @return void
     */
    public function admin_home() {
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
    public function admin_profile() {
        $id = $this->Session->read('Auth.User.id');
		$this->User->recursive = -1;
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $conditions = array('User.id'=>$id);
        $user = $this->User->find('first',compact('conditions'));
        $this->set(compact('user'));
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
	 * register method
	 *
	 * @return void
	 */
	public function register() {
		if ($this->request->is('post')) {
			$this->request->data['User']['role_id'] = Configure::read('Role.user');
            $this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'),'Flash/success');
				$this->redirect(array('plugin'=>null,'controller'=>'pages', 'action' => 'home'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'),'Flash/error');
			}
		}
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
        $conditions = array('User.id' => $id);
        $user = $this->User->find('first',compact('conditions'));
        if ($this->Session->read('Auth.User.user_id')!=Configure::read('Role.master')&&$user['User']['role_id']==Configure::read('Role.master')) {
            $this->Session->setFlash(__('You are not authorized to edit this user.'),'Flash/error');
            $this->redirect(array('action' => 'index'));
        }
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'),'Flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'),'Flash/error');
			}
		} else {
            unset($user['User']['password']);
			$this->request->data = $user;
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
     * admin_change_email method
     *
     * @return void
     */
	public function admin_change_email() {
		if ($this->request->is('post')) {
			$this->User->recursive = -1;
			$conditions = array('User.email'=>$this->data['User']['new_email']);
			$user = $this->User->find('first',compact('conditions'));

			if (empty($user)) {
                $data = array(
                	'new_email'	=> '"'.$this->data['User']['new_email'].'"',
                    'new_email_key' => 'MD5('.time().')'
                );
                $conditions = array('User.id'=>$this->Session->read('Auth.User.id'));
                $this->User->updateAll($data, $conditions);

                //$this->User->recursive = -1;
                //$conditions = array('User.email'=>$this->data['User']['email']);
                $user = $this->User->find('first',compact('conditions'));

                $email = new CakeEmail('smtp');
                //$email->to($this->data['User']['new_email']);
                $email->to('alvin@locbit.com');
                $email->subject(__('Change Email from Locbit'));
                $email->template('Users/change_email', 'default');
                $email->helpers('Time','Html');
                $email->theme($this->theme);
                $email->viewVars(compact('user'));
                $email->send();

                $this->Session->setFlash(__('The new email has been sent!'),'Flash/success');
                $this->redirect(array('controller' => 'users', 'action' => 'profile', 'admin'=>true));
            } else {
                $this->Session->setFlash(__('The email you provided has been registered'),'Flash/error');
            }
		}
	}

	/**
     * admin_forgot_password method
     *
     * @return void
     */
	public function forgot_password() {
		if ($this->Session->read('Auth')){
			$this->Session->setFlash(__('You are logged in!'),'Flash/info');
			$this->redirect($this->referer());
		}

		if ($this->request->is('post')) {
			$this->User->recursive = -1;
			$conditions = array('User.email'=>$this->request->data['User']['email']);
			$user = $this->User->find('first',compact('conditions'));

			if (!empty($user)) {
                $data = array(
                    'new_password_requested' => 'NOW()',
                    'new_password_hash' => 'MD5('.time().')'
                );
                $condition = array('User.id'=>$user['User']['id']);
                $this->User->updateAll($data, $condition);

                //$this->User->recursive = -1;
                //$conditions = array('User.email'=>$this->request->data['User']['email']);
                $user = $this->User->find('first',compact('conditions'));

                $email = new CakeEmail('smtp');
                $email->to($user['User']['email']);
                $email->subject(__('Reset password from Locbit'));
                $email->template('Users/forgot_password', 'default');
                $email->helpers('Time','Html');
                $email->theme($this->theme);
                $email->viewVars(compact('user'));
                $email->send();

                $this->Session->setFlash(__('The recovery password email has been sent!'),'Flash/success');
            } else {
                $this->Session->setFlash(__('The email you provided is not registered'),'Flash/error');
            }
		}
	}

	/**
     * admin_reset_email method
     *
     * @return void
     */
	public function admin_reset_email($user_id, $email_key) {
		$this->User->recursive = -1;
		if($this->Session->read('Auth.User.id') != $user_id) {
			$this->Session->setFlash(__('Invalid User ID!'),'Flash/error');
			$this->redirect(array('plugin'=>null,'controller'=>'pages','action'=>'home','admin'=>false));
		}
		$conditions = array(
            'User.id' => $user_id,
            'User.new_email_key' => $email_key
        );
		$user = $this->User->find('first',compact('conditions'));
		if (!empty($user)) {
			$this->User->id = $user['User']['id'];
            $data = array(
                    'User' => array(
                        'email'		=> $user['User']['new_email'],
                        'new_email_key'=> null,
                        'new_email'=> null,
                    )
            );
            if ($this->User->save($data)){
                $this->Session->setFlash(__('New Email has been saved.'),'Flash/success');
                $this->redirect(array('controller' => 'users', 'action' => 'home', 'admin'=>true));
            } else {
                $this->Session->setFlash(__('There is problem of saving new email.'),'Flash/error');
            }
        } else {
            $this->Session->setFlash(__('This link does not exist or it is no loger valid.'),'Flash/error');
            $this->redirect(array('controller'=>'users','action'=>'forgot_password','admin'=>false));
        }
	}

	/**
     * reset_password method
     *
     * @return void
     */
	public function reset_password($hash, $password_hash) {
		$this->User->recursive = -1;
		if($this->Session->read('Auth')) {
			$this->Session->setFlash(__('You have already login!'),'Flash/error');
			$this->redirect(array('plugin'=>null,'controller'=>'pages','action'=>'home','admin'=>false));
		}
		$conditions = array(
            'User.hash' => $hash,
            'User.new_password_hash' => $password_hash,
            'DATE_ADD(User.new_password_requested, INTERVAL 1 DAY) > NOW()'
        );
		$user = $this->User->find('first',compact('conditions'));
		if (!empty($user)) {
            if ($this->request->is('post')) {
                $this->User->recursive = -1;
                if ($this->request->data['User']['new_password'] === $this->request->data['User']['repeat_password']) {
                    if ($user['User']['is_active']) {
                        $this->User->id = $user['User']['id'];
                        $data = array(
                                'User' => array(
                                    'password'				=> $this->request->data['User']['new_password'],
                                    'new_password_key'		=> null,
                                    'new_password_requested'=> null,
                                )
                        );
                        if ($this->User->save($data)){
                            $this->Session->setFlash(__('New Password has been saved.'),'Flash/success');
                            $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin'=>false));
                        } else {
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
        } else {
            $this->Session->setFlash(__('This link does not exist or it is no loger valid.'),'Flash/error');
            $this->redirect(array('controller'=>'users','action'=>'forgot_password','admin'=>false));
        }
	}

    /**
     * admin_change_password method
     *
     * @return void
     */
    public function admin_change_password() {
        $id = $this->Session->read('Auth.User.id');
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }

        if ($this->request->is('post')) {
            $conditions = array(
                'User.id' => $id,
                'User.password' => Security::hash($this->request->data['User']['current_password'], 'sha1', true)
            );
            $this->User->recursive = -1;
            $user = $this->User->find('first',compact('conditions'));

            if (!empty($user)) {
                if ($this->request->data['User']['new_password'] === $this->request->data['User']['repeat_password']) {
                    $this->User->id = $id;
                    $data = array(
                        'User' => array(
                            'password'	=> $this->request->data['User']['new_password'],
                        ));
                    if ($this->User->save($data)) {
                        $this->Session->setFlash(__('New Password has been saved.'),'Flash/success');
                        $this->redirect(array('action'=>'profile','admin'=>true));
                    } else {
                        $this->Session->setFlash(__('Password was not saved. Please, try again.'),'Flash/error');
                    }
                } else {
                    $this->Session->setFlash(__('New and repeat password do not match.'),'Flash/error');
                }
            } else {
                $this->Session->setFlash(__('Current password does not match.'),'Flash/error');
            }
        }
        $conditions = array('User.id' => $id);
        $user = $this->User->find('first',compact('conditions'));
        $this->set(compact('user'));
    }
}
