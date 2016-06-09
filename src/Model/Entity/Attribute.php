<?php
namespace Attribute\Model\Entity;

use Cake\ORM\Entity;

/**
 * Attribute Entity.
 *
 * @property int $id
 * @property string $friendlyname
 * @property string $oid
 * @property string $name
 * @property string $schema
 * @property string $validation
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Attribute extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
