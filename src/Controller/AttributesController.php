<?php
namespace CscItCenterForScience\AttributeTestService\Controller;

use CscItCenterForScience\AttributeTestService\Controller\AppController;
use Cake\Validation\Validator;
use Cake\Utility\Xml;
use Cake\Event\Event;

/**
 * Attributes Controller
 *
 * @property \Attribute\Model\Table\AttributesTable $Attributes
 */
class AttributesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $attributes = $this->paginate($this->Attributes);

        $this->set(compact('attributes'));
        $this->set('_serialize', ['attributes']);
    }
    public function map()
    {
      $xml = Xml::build('/etc/shibboleth/attribute-map.xml');
      foreach ($xml->Attribute as $attr) {
        $attributeMap[(string)$attr->attributes()->id][] = (string)$attr->attributes()->name;
      }
      foreach ($attributeMap as $key => $values):
        unset($oid);
        unset($name);
        $schema = "Undetected";

        if (count($values)>2) 
          die('too much');
        foreach ($values as $value) :
          if (preg_match_all( "/[0-9]/", $value )>3)
            $oid = $value;
          else {
            $temp = explode(':',$value);
            $name = end($temp);
            if (substr(strtolower($name), 0, strlen('schac')) === 'schac') 
              $schema = 'schac';
            if (substr(strtolower($name), 0, strlen('eduperson')) === 'eduperson')
              $schema = 'eduperson';
            if (substr(strtolower($name), 0, strlen('funeteduperson')) === 'funeteduperson')
              $schema = 'funeteduperson';
          }
        endforeach;
        if (!isset($oid)) $oid=null;

        $attributes = array('friendlyname'=>$name, 'name'=>$name,'oid'=>$oid,'schema'=>$schema);
        if ($this->Attributes->findByOid($oid)->isEmpty()) {
          $attribute = $this->Attributes->newEntity();
          $attribute = $this->Attributes->patchEntity($attribute, $attributes);
          $this->Attributes->save($attribute);
        }
      endforeach;
      $this->setAction('index');
    }

    public function test()
    {
      if ($this->request->env('Shib-Session-ID')===null) $this->Flash->warning('To test your attribute releases, you have to login first');
      $this->loadModel('Releases');
      foreach ($this->Attributes->find('all') as $attribute) :
        unset($temp);
        unset($errors);
        $temp['validator'] = $attribute['validation'];
        $attribute['value'] = $this->request->env($attribute->name);
        $validated = 'N/A';
        if (!empty($attribute['validation'])) {
          $validator = new Validator();
          $validator
            ->allowEmpty('value')
            ->add('value', 'validFormat', [
              'rule' => array('custom', '/^('.$attribute['validation'].')$/i'),
              'message' => 'RegEx match fails.'
            ]);
            $errors = $validator->errors(array('value'=>$attribute['value']));
            $validated = 'FAIL';

        }
        $temp['value'] = $attribute['value'];
        if (!empty($errors)) $temp['errors'] = $errors['value'];
        
        $attributes[$attribute['schema']] [$attribute['name']] = $temp;
        if (!empty($attribute['value'])) {
          $persistentid_array = preg_split('/!/',$this->request->env('persistent-id'));
          $persistentid = end($persistentid_array);
          $attr_release = array('attribute_name'=>$attribute['name'],'idp'=>$this->request->env('Shib-Identity-Provider'),'persistentid'=>$persistentid,'validated'=>$validated);
          $query = $this->Releases->find()->andWhere(['attribute_name'=>$attribute['name'],'idp'=>$this->request->env('Shib-Identity-Provider'),'persistentid'=>$persistentid]);
          if ($query->isEmpty()) {
            $release = $this->Releases->newEntity();
          } else {
            $id = $query->first()->id;
            $release = $this->Releases->get($id, ['contain' => [] ]);
          }
          $release = $this->Releases->patchEntity($release, $attr_release);
          $this->Releases->save($release);
        }
      endforeach;
      $this->set(compact('attributes'));
      $this->set('_serialize', ['attributes']);
    }

    /**
     * View method
     *
     * @param string|null $id Attribute id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $attribute = $this->Attributes->get($id, [
            'contain' => []
        ]);

        $this->set('attribute', $attribute);
        $this->set('_serialize', ['attribute']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $attribute = $this->Attributes->newEntity();
        if ($this->request->is('post')) {
            $attribute = $this->Attributes->patchEntity($attribute, $this->request->data);
            if ($this->Attributes->save($attribute)) {
                $this->Flash->success(__('The attribute has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The attribute could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('attribute'));
        $this->set('_serialize', ['attribute']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Attribute id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $attribute = $this->Attributes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $attribute = $this->Attributes->patchEntity($attribute, $this->request->data);
            if ($this->Attributes->save($attribute)) {
                $this->Flash->success(__('The attribute has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The attribute could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('attribute'));
        $this->set('_serialize', ['attribute']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Attribute id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $attribute = $this->Attributes->get($id);
        if ($this->Attributes->delete($attribute)) {
            $this->Flash->success(__('The attribute has been deleted.'));
        } else {
            $this->Flash->error(__('The attribute could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
