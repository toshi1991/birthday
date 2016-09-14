<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Sns Controller
 *
 * @property \App\Model\Table\SnsTable $Sns
 */
class SnsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $sns = $this->paginate($this->Sns);

        $this->set(compact('sns'));
        $this->set('_serialize', ['sns']);
    }

    /**
     * View method
     *
     * @param string|null $id Sn id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sn = $this->Sns->get($id, [
            'contain' => []
        ]);

        $this->set('sn', $sn);
        $this->set('_serialize', ['sn']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sn = $this->Sns->newEntity();
        if ($this->request->is('post')) {
            $sn = $this->Sns->patchEntity($sn, $this->request->data);
            if ($this->Sns->save($sn)) {
                $this->Flash->success(__('The sn has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The sn could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('sn'));
        $this->set('_serialize', ['sn']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Sn id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sn = $this->Sns->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sn = $this->Sns->patchEntity($sn, $this->request->data);
            if ($this->Sns->save($sn)) {
                $this->Flash->success(__('The sn has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The sn could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('sn'));
        $this->set('_serialize', ['sn']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Sn id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sn = $this->Sns->get($id);
        if ($this->Sns->delete($sn)) {
            $this->Flash->success(__('The sn has been deleted.'));
        } else {
            $this->Flash->error(__('The sn could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
