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
			$this->autoRender = FALSE;
			
			$data = $this->request->data;
			if(!key_exists('video', $data)) {
				error_log("Video data not found.");
				echo 'Video data not found.';
				exit();
			}
			
			$tmp_name = $data['video']["tmp_name"];
			if (! is_uploaded_file($tmp_name)) {
				error_log("Video file is not uploaded.");
				echo '<pre>';
				var_dump($data);
				echo 'ng';
				exit();
			}
			
			$new_name = time() . '_' . $data['video']['name'];
			move_uploaded_file($tmp_name, "videos/$new_name");
			
            $movie = $this->Movies->patchEntity($movie, $this->request->data);
			$movie->path = $new_name;
            if ($this->Movies->save($movie)) {
				$res = array('filename' => $new_name);
                echo json_encode($res);
            } else {
				error_log("Video data save failed.");
				echo "<pre>";
				var_dump($movie);
				echo 'ng';
			}
			error_log(print_r($movie, true));
			exit(0);
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
