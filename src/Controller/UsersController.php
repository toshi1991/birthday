<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
	public function initialize() {
		parent::initialize();

		$this->loadComponent('Cookie');
	}

	public function top()
	{

	}

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Messages']
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

	/**
	 * Login
	 */
	public function login($guest = false) {
		$this->loadComponent('Auth',[
			'authenticate' => [
				'Form' => [
					'fields' => [
						'username' => 'user_name',
						'password' => 'password'
					]
				]
			]
		]);

		if ($guest) {
			$new_data = $this->Users->newEntity();
			$guest_data = array('user_name' => "GUEST_TMP", 'password' => '12345');
			$new_data = $this->Users->patchEntity($new_data, $guest_data);
			if ($this->Users->save($new_data)) {
				$new_data->user_name = "GUEST" . $new_data->id;
				$new_data->password = '12345';//$guest_data['password'];
				if ($this->Users->save($new_data)) {
					$this->request->data = $new_data;
					$user = $this->Auth->identify();
					if($user){
						$this->Auth->setUser($user);
						return $this->redirect($this->Auth->redirectUrl());
					}
					$this->Flash->error('ゲストログインに失敗しました。再度お試しください。');
				}
			} else {
				$this->Flash->error('ログインに失敗しました。');
				return $this->redirect(['controller' => 'Pages']);
			}
			return $this->redirect(['controller' => 'messages', 'action' => 'add']);
		} else {
			if($this->request->is('post')){
				$user = $this->Auth->identify();
				if($user){
					$this->Auth->setUser($user);
					return $this->redirect($this->Auth->redirectUrl());
				}
				$this->Flash->error('ユーザー名かパスワードが間違ってます。');
			}
		}
	}

	/**
	 * My Page
	 */
	public function mypage() {

	 }
}
