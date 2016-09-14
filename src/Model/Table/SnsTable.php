<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sns Model
 *
 * @method \App\Model\Entity\Sn get($primaryKey, $options = [])
 * @method \App\Model\Entity\Sn newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Sn[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Sn|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sn patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Sn[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Sn findOrCreate($search, callable $callback = null)
 */
class SnsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('sns');
        $this->displayField('id');
        $this->primaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('sns_name');

        return $validator;
    }
}
