<?php
App::uses('AuthBootstrapAppController', 'AuthBootstrap.Controller');
/**
 * Roles Controller
 *
 * @property Role $Role
 */
class RolesController extends AuthBootstrapAppController {


    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('*'));
    }

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
        $this->paginate = array(
            'Role' => array(
                'recursive' => -1,
            )
        );
        $roles = $this->paginate('Role');

        // add user count
        foreach ($roles as $key=>$role) {
            $conditions = array(
                'User.role_id' => $role['Role']['id']
            );
            $roles[$key]['User']['count'] = $this->Role->User->find('count',compact('conditions'));
        }
        $this->set(compact('roles'));
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
	public function admin_view($id = null) {
		$this->Role->id = $id;
		if (!$this->Role->exists()) {
			throw new NotFoundException(__('Invalid role'));
		}
		$this->set('role', $this->Role->read(null, $id));
	}

    /**
     * add method
     *
     * @return void
     */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Role->create();
			if ($this->Role->save($this->request->data)) {
				$this->Session->setFlash(__('The role has been saved'),'Flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The role could not be saved. Please, try again.'),'Flash/error');
			}
		}
	}

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
	public function admin_edit($id = null) {
		$this->Role->id = $id;
		if (!$this->Role->exists()) {
			throw new NotFoundException(__('Invalid role'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Role->save($this->request->data)) {
				$this->Session->setFlash(__('The role has been saved'),'Flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The role could not be saved. Please, try again.'),'Flash/error');
			}
		} else {
			$this->request->data = $this->Role->read(null, $id);
		}
	}

    /**
     * delete method
     *
     * @param string $id
     * @return void
     */
	public function admin_delete($id = null) {
        throw new MethodNotAllowedException();
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Role->id = $id;
		if (!$this->Role->exists()) {
			throw new NotFoundException(__('Invalid role'));
		}
		if ($this->Role->delete()) {
			$this->Session->setFlash(__('Role deleted'),'Flash/success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Role was not deleted'),'Flash/error');
		$this->redirect(array('action' => 'index'));
	}
}
