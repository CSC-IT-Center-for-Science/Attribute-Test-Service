<?php
namespace cscfi\AttributeTestService\Controller;

use cscfi\AttributeTestService\Controller\AppController;
use Cake\Collection\Collection;

/**
 * Releases Controller
 *
 * @property \Attribute\Model\Table\ReleasesTable $Releases
 */
class ReleasesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $releases = $this->Releases->find('all')->all();
        $collection = new Collection($releases);
        $attribute_names = array_unique($collection->extract('attribute_name')->toArray());
        $idps = array_unique($collection->extract('idp')->toArray());
        $releasesByIdp = $collection->groupBy('idp')->toArray();
        foreach ($idps as $idp) :
          foreach ($attribute_names as $attribute) :
            $releasesByIdPbyAttribute = $collection->match(['idp'=>$idp,'attribute_name'=>$attribute]);
            $temp_result = $releasesByIdPbyAttribute->countBy(function ($result) {
            return strtolower($result->validated) == 'fail' ? 'fail' : 'pass';
            });
            $results[$idp][$attribute] = $temp_result->toArray();
          endforeach;
        endforeach;
        # My attributes
        $persistentid_array = preg_split('/!/',$this->request->env('persistent-id'));
        $persistentid = end($persistentid_array);
        $myAttributesTemp = $this->Releases->find()->andWhere(['idp'=>$this->request->env('Shib-Identity-Provider'),'persistentid'=>$persistentid])->all();
        $myAttributesCollection = new Collection($myAttributesTemp);
        $myAttributes = $myAttributesCollection->groupBy('attribute_name')->toArray();
        $this->set(compact('myAttributes'));
        $this->set('_serialize', ['myAttributes']);
        $this->set(compact('results'));
        $this->set('_serialize', ['results']);
        $this->set(compact('idps'));
        $this->set('_serialize', ['idps']);
        $this->set(compact('attribute_names'));
        $this->set('_serialize', ['attribute_names']);
    }

    /**
     * View method
     *
     * @param string|null $id Release id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $release = $this->Releases->get($id, [
            'contain' => []
        ]);

        $this->set('release', $release);
        $this->set('_serialize', ['release']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $release = $this->Releases->newEntity();
        if ($this->request->is('post')) {
            $release = $this->Releases->patchEntity($release, $this->request->data);
            if ($this->Releases->save($release)) {
                $this->Flash->success(__('The release has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The release could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('release'));
        $this->set('_serialize', ['release']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Release id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $release = $this->Releases->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $release = $this->Releases->patchEntity($release, $this->request->data);
            if ($this->Releases->save($release)) {
                $this->Flash->success(__('The release has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The release could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('release'));
        $this->set('_serialize', ['release']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Release id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $release = $this->Releases->get($id);
        if ($this->Releases->delete($release)) {
            $this->Flash->success(__('The release has been deleted.'));
        } else {
            $this->Flash->error(__('The release could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
