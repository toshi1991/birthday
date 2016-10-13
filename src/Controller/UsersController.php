<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
	public function initialize() {
		parent::initialize();

		$this->loadComponent('Auth',[
			'authenticate' => [
				'Form' => [
					'fields' => [
						'username' => 'user_name',
						'password' => 'password'
					]
				]
			],
			'logoutRedirect' => [ // ログアウト後に遷移するアクションを指定
                'controller' => 'Messages',
                'action' => 'index',
            ],
			'loginAction' => [
				'controller' => 'users',
				'action' => 'login'
			]
		]);

		$this->Auth->allow(['login', 'add']);
	}

	public function top()
	{

	}

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     *//*
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }*/

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     *//*
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Messages']
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }*/

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
				$user = $this->Auth->identify();
				if ($user) {
					$this->Auth->setUser($user);
				}
				$this->Flash->success('登録完了しました。');
                return $this->redirect(['controller' => 'messages', 'action' => 'add']);
            } else {
                $this->Flash->error('登録に失敗しました。再度お試しください。');
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
		$this->Auth->allow();
		if ($guest) {
			$new_data = $this->Users->newEntity();
			$guest_data = array('user_name' => "GUEST".time(), 'password' => '12345');
			$new_data = $this->Users->patchEntity($new_data, $guest_data);
			if ($this->Users->save($new_data)) {
				$this->request->data["user_name"] = $new_data["user_name"];
				$this->request->data["password"] = "12345";
				$user = $this->Auth->identify();
				if($user){
					$this->Auth->setUser($user);
					//return $this->redirect($this->Auth->redirectUrl());
					return $this->redirect(['controller' => 'messages', 'action' => 'add']);
				} else {
						$this->log('Guest Auth failed.', 'error');
						$this->log(print_r($this->request, true), 'error');
						$this->log(print_r($user, true), 'error');
				}
			} else {
				$this->log("Saving user data failed.", 'error');
			}

			$this->Flash->error('ゲストログインに失敗しました。再度お試しください。');
			return $this->redirect(['controller' => 'Pages']);
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

	 public function logout() {
		 return $this->redirect($this->Auth->logout());
	 }
}
