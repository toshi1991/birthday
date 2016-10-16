<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Movies Controller
 *
 * @property \App\Model\Table\MoviesTable $Movies
 */
class MoviesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Messages']
        ];
        $movies = $this->paginate($this->Movies);

        $this->set(compact('movies'));
        $this->set('_serialize', ['movies']);
    }

    /**
     * View method
     *
     * @param string|null $id Movie id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $movie = $this->Movies->get($id, [
            'contain' => ['Messages']
        ]);

        $this->set('movie', $movie);
        $this->set('_serialize', ['movie']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $movie = $this->Movies->newEntity();
        if ($this->request->is('ajax')) {
            $res = ["result" => 'ng', 'error' => '', 'filename' => ''];
			$this->autoRender = FALSE;

			$data = $this->request->data;
			if(!key_exists('video', $data)) {
				error_log("Video data not found.");
                error_log(print_r($this->request->data, true));
                $res["error"] =  'エラーが発生しました。ページをリロードして再度お試しください。';
				echo json_encode($res);
                return null;
			}

			$tmp_name = $data['video']["tmp_name"];
			if (! file_exists($tmp_name) || ! is_uploaded_file($tmp_name)) {
				$res['error'] = "アップロードに失敗しました。";
                echo json_encode($res);
                return null;
			}

			$new_name = time() . '_' . $data['video']['name'];
			if (! move_uploaded_file($tmp_name, "videos/$new_name")) {

                $res['error'] = 'エラーが発生しました。';
                $this->log('move_uploaded_file failed.', 'error');
                $this->log(print_r($this->request->data, true), 'error');
                echo json_encode($res);
                return null;
            }

            $movie = $this->Movies->patchEntity($movie, $this->request->data);
			$movie->path = $new_name;
            if ($this->Movies->save($movie)) {
                $res['result'] = 'ok';
				$res['filename'] = $new_name;
                echo json_encode($res);
                return null;
            } else {
				$res['error'] = "動画の追加に失敗しました。再度お試しください。";
                echo json_encode($res);
                return null;
			}
			error_log(print_r($movie, true));
            echo json_encode($res);
            return null;
        }
        $messages = $this->Movies->Messages->find('list', ['limit' => 200]);
        $this->set(compact('movie', 'messages'));
        $this->set('_serialize', ['movie']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Movie id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $movie = $this->Movies->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $movie = $this->Movies->patchEntity($movie, $this->request->data);
            if ($this->Movies->save($movie)) {
                $this->Flash->success(__('The movie has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The movie could not be saved. Please, try again.'));
            }
        }
        $messages = $this->Movies->Messages->find('list', ['limit' => 200]);
        $this->set(compact('movie', 'messages'));
        $this->set('_serialize', ['movie']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Movie id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $movie = $this->Movies->get($id);
        if ($this->Movies->delete($movie)) {
            $this->Flash->success(__('The movie has been deleted.'));
        } else {
            $this->Flash->error(__('The movie could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
