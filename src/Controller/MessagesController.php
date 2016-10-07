<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Messages Controller
 *
 * @property \App\Model\Table\MessagesTable $Messages
 */
class MessagesController extends AppController
{
	public function initialize()
	{
	    parent::initialize();
	    $this->loadComponent('Flash');

	    //Auth
		$this->loadComponent('Auth',[
			'loginAction' => [
				'controller' => 'users',
				'action' => 'login'
			]
		]);
	}

	public function beforeFilter(Event $event)
    {
		parent::beforeFilter($event);
	}

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$user = $this->Auth->user();

		$opt = ['contain' => ['Users'], 'limit' => 5];
		if (! $user['admin_flg']) {
			$opt['conditions'] = ['user_id' => $user["id"]];
		}
		$this->paginate = $opt;

        $messages = $this->paginate($this->Messages);

        $this->set(compact('messages'));
        $this->set('_serialize', ['messages']);
    }

    /**
     * View method
     *
     * @param string|null $id Message id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $message = $this->Messages->get($id, [
            'contain' => ['Users', 'Images', 'Movies']
        ]);

        $this->set('message', $message);
        $this->set('_serialize', ['message']);
    }

    /**
     * Add method
     *	メッセージ投稿画面
	 *
     * @return \Cake\Network\Response|void renders view.
     */
    public function add()
    {
		// Authコンポーネントからユーザー情報取得
		$user = $this->Auth->user();

		// ゲストユーザーの場合は表示するユーザー名を'ゲスト'に置き換え
		$user['user_name'] = preg_replace('/GUEST.*/i', 'ゲスト', $user["user_name"]);

		// 投稿データ作成
		$message = $this->Messages->newEntity();

		// POSTされた場合は保存処理を行う
		if ($this->request->is('post')) {
            $message = $this->Messages->patchEntity($message, $this->request->data);

			// ユーザーIDを割り当て
			$message->user_id = $user['id'];

			// 保存処理
            if ($this->Messages->save($message)) {
				// 成功時は編集画面へリダイレクト
                $this->Flash->success('投稿しました。');
                return $this->redirect(['action' => 'edit', $message->id]);
            } else {
				// 失敗時はエラー表示
                $this->Flash->error('投稿に失敗しました。再度お試しください。');
            }
        }

		// Viewへデータを渡す
        $this->set(compact('message', 'user'));
        $this->set('_serialize', ['message']);
    }

    /**
     * Edit method
     *	メッセージ編集画面
	 *
     * @param string $id Message id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id)
    {
		// checking logged-in
		$user = $this->Auth->user();

		// 指定されたメッセージを取得
        $message = $this->Messages->get($id, [
            'contain' => ['Images', 'Movies']
        ]);

		if ($message->user_id != $user['id']) {
			$this->Flash->error('ログインしてください。');
			$this->redirect(['controller' => 'users', 'action' => 'logout']);
		}

        if ($this->request->is(['patch', 'post', 'put'])) {
            $message = $this->Messages->patchEntity($message, $this->request->data);
            if ($this->Messages->save($message)) {
                $this->Flash->success('更新しました。');

                return $this->redirect(['action' => 'edit', $id]);
            } else {
                $this->Flash->error('投稿に失敗しました。再度お試しください。');
            }
        }

        $users = $this->Messages->Users->find('list', ['limit' => 200]);

		$this->set(compact('message', 'users'));
        $this->set('_serialize', ['message']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Message id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $message = $this->Messages->get($id);
        if ($this->Messages->delete($message)) {
            $this->Flash->success(__('The message has been deleted.'));
        } else {
            $this->Flash->error(__('The message could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
